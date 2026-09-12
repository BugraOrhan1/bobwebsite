<?php
/**
 * De Reinigingsdokter — frontcontroller (Kirby-vrij).
 * Alle pagina-routes lopen via dit bestand.
 */

require __DIR__ . '/app/bootstrap.php';
require APP_DIR . '/citycontent.php';

$path = request_path();

// Normaliseer: trailing slash weghalen (behalve root)
if ($path !== '' && substr($_SERVER['REQUEST_URI'] ?? '/', -1) === '/') {
    redirect('/' . $path);
}

/* -------------------------------------------------------------- */
/* Speciale routes                                                 */
/* -------------------------------------------------------------- */

if ($path === 'sitemap.xml') {
    header('Content-Type: application/xml; charset=utf-8');
    echo render_sitemap();
    exit;
}

if ($path === 'robots.txt') {
    header('Content-Type: text/plain; charset=utf-8');
    echo "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /data/\nDisallow: /app/\n\nSitemap: " . url('sitemap.xml') . "\n";
    exit;
}

/* -------------------------------------------------------------- */
/* Contactformulier (POST)                                         */
/* -------------------------------------------------------------- */

if ($path === 'contact' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    handle_contact_post();
}

/* -------------------------------------------------------------- */
/* Pagina-routes                                                   */
/* -------------------------------------------------------------- */

$segments = $path === '' ? [] : explode('/', $path);

// Home
if ($path === '') {
    $page = page_by_slug('');
    $ctx = make_ctx('home', ['page' => $page],
        $page['meta_title'] ?? null, $page['meta_description'] ?? null,
        url(''), 'body__home');
    render_page($ctx);
    exit;
}

// Diensten-overzicht
if ($path === 'reinigen') {
    $page = page_by_slug('reinigen');
    $crumbs = [
        ['title' => 'Home', 'url' => '/'],
        ['title' => $page['title'], 'url' => '/reinigen'],
    ];
    $ctx = make_ctx('services', [
        'page' => $page,
        'servicesList' => all_services(),
    ], $page['meta_title'] ?? null, $page['meta_description'] ?? null, url('reinigen'));
    render_page($ctx);
    exit;
}

// Dienst of stadspagina
if ($segments[0] === 'reinigen' && isset($segments[1])) {
    $service = service_by_slug($segments[1]);
    if ($service) {
        $page = service_page($service);
        // Contextueel WhatsApp-bericht: dienst (+ eventueel stad)
        $GLOBALS['WA_PREFILL'] = 'Hallo, ik wil graag ' . $service['title'] . ' aanvragen. Kunnen jullie mij een prijsindicatie geven?';

        if (!isset($segments[2])) {
            // Dienstpagina
            $crumbs = [
                ['title' => 'Home', 'url' => '/'],
                ['title' => 'Reinigen', 'url' => '/reinigen'],
                ['title' => $service['title'], 'url' => '/reinigen/' . $service['slug']],
            ];
            $metaTitle = $page['meta_title'] ?? ($service['title'] . ' | ' . setting('site_title'));
            $ctx = make_ctx('service', [
                'page' => $page,
                'service' => $service,
                'crumbs' => $crumbs,
            ], $metaTitle, $page['meta_description'] ?? null, url('reinigen/' . $service['slug']));
            $ctx['breadcrumb_schema'] = $crumbs;
            render_page($ctx);
            exit;
        }

        $city = city_by_slug($segments[2]);
        if ($city && (int)$city['enabled'] === 1) {
            $GLOBALS['WA_PREFILL'] = 'Hallo, ik wil graag ' . $service['title'] . ' in ' . $city['name'] . ' aanvragen. Kunnen jullie mij een prijsindicatie geven?';
            // Stadspagina
            $crumbs = [
                ['title' => 'Home', 'url' => '/'],
                ['title' => 'Reinigen', 'url' => '/reinigen'],
                ['title' => $service['title'], 'url' => '/reinigen/' . $service['slug']],
                ['title' => $city['name'], 'url' => '/reinigen/' . $service['slug'] . '/' . $city['slug']],
            ];
            $h1 = $service['title'] . ' in ' . $city['name'] . ' en omgeving';
            $metaTitle = $h1 . ' | ' . setting('site_title');
            $metaDesc = $service['title'] . ' in ' . $city['name'] . ' en omgeving. Reiniging op locatie, 100% milieuvriendelijk, reactie binnen 2 uur. ' . str_limit(setting('site_description'), 90);
            $ctx = make_ctx('city', [
                'page' => $page,
                'service' => $service,
                'city' => $city,
                'crumbs' => $crumbs,
                'introHtml' => city_intro_text($service, $city),
                'nearby' => nearby_cities_links($service, $city, 10),
            ], $metaTitle, $metaDesc, url('reinigen/' . $service['slug'] . '/' . $city['slug']));
            $ctx['breadcrumb_schema'] = $crumbs;
            render_page($ctx);
            exit;
        }
    }
}

// Vaste pagina's op slug
$page = page_by_slug($path);
if ($page) {
    $crumbs = [
        ['title' => 'Home', 'url' => '/'],
        ['title' => $page['title'], 'url' => '/' . $page['slug']],
    ];
    $viewMap = [
        'prices' => 'prices',
        'reviews' => 'reviews',
        'contact' => 'contact',
        'thanks' => 'thanks',
        'page' => 'page',
        'legal' => 'legal',
        'portfolio' => 'portfolio',
    ];
    $view = $viewMap[$page['template']] ?? 'page';
    $bodyClass = $page['template'] === 'contact' ? 'body__contact'
        : ($page['template'] === 'prices' || $page['template'] === 'reviews' ? 'body__page' : 'body__default');

    $vars = ['page' => $page, 'crumbs' => $crumbs];
    if ($view === 'contact') { $vars['errors'] = []; $vars['old'] = []; }

    $ctx = make_ctx($view, $vars,
        $page['meta_title'] ?? null, $page['meta_description'] ?? null,
        url($page['slug']), $bodyClass);
    $ctx['breadcrumb_schema'] = $crumbs;
    render_page($ctx);
    exit;
}

/* -------------------------------------------------------------- */
/* 404                                                             */
/* -------------------------------------------------------------- */

http_response_code(404);
$ctx = make_ctx('error', [],
    'Pagina niet gevonden | ' . setting('site_title'),
    'Deze pagina bestaat niet meer.', url($path), 'body__default');
render_page($ctx);
exit;

/* ================================================================ */
/* Functies                                                          */
/* ================================================================ */

function handle_contact_post(): void
{
    if (!csrf_check()) {
        http_response_code(419);
        exit('Sessie verlopen. Ga terug en probeer het opnieuw.');
    }

    $post = $_POST;
    $errors = [];
    $data = [
        'fullName' => trim($post['fullName'] ?? ''),
        'phone'    => trim($post['phone'] ?? ''),
        'email'    => trim($post['email'] ?? ''),
        'woonplaats' => trim($post['woonplaats'] ?? ''),
        'message'  => trim($post['message'] ?? ''),
        'lead'     => trim($post['lead'] ?? '--'),
    ];

    // Honeypot: bots vullen het verborgen veld in
    if (!empty($post['website'])) {
        redirect('/contact/bedankt');
    }

    if ($data['fullName'] === '') $errors['fullName'] = 'Vul alstublieft uw naam in.';
    if ($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Vul alstublieft een geldig e-mailadres in.';
    }
    if ($data['message'] === '') $errors['message'] = 'Vul alstublieft een bericht in.';

    if ($errors) {
        $page = page_by_slug('contact');
        $ctx = make_ctx('contact', [
            'page' => $page,
            'crumbs' => [['title' => 'Home', 'url' => '/'], ['title' => 'Contact', 'url' => '/contact']],
            'errors' => $errors,
            'old' => $data,
        ], $page['meta_title'] ?? null, $page['meta_description'] ?? null, url('contact'), 'body__contact');
        render_page($ctx);
        exit;
    }

    // Bijlage verwerken
    $attachment = '';
    if (!empty($_FILES['filefield']['name']) && $_FILES['filefield']['error'] === UPLOAD_ERR_OK) {
        $maxSize = 8 * 1024 * 1024;
        if (filesize($_FILES['filefield']['tmp_name']) <= $maxSize) {
            $ext = strtolower(pathinfo($_FILES['filefield']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'heic'];
            if (in_array($ext, $allowed, true)) {
                if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0775, true);
                $fname = date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
                if (move_uploaded_file($_FILES['filefield']['tmp_name'], UPLOAD_DIR . '/' . $fname)) {
                    $attachment = $fname;
                }
            }
        }
    }

    // gclid (Google Ads) uit cookie of POST
    $gclid = trim($post['gclid'] ?? '') ?: ($_COOKIE['rds_gclid'] ?? '');

    $leadId = lead_add([
        'name' => $data['fullName'],
        'phone' => $data['phone'],
        'email' => $data['email'],
        'city' => $data['woonplaats'],
        'message' => $data['message'],
        'source' => $data['lead'],
        'gclid' => $gclid,
        'page' => $_SERVER['HTTP_REFERER'] ?? '',
        'ip' => client_ip(),
        'attachment' => $attachment,
    ]);

    // E-mail notificatie naar eigenaar
    $to = setting('notify_email');
    if ($to) {
        $subject = 'Nieuwe lead via website: ' . $data['fullName'];
        $body = "Er is een nieuw contactformulier ingevuld op de website.\n\n"
            . "Naam: {$data['fullName']}\n"
            . "Telefoon: {$data['phone']}\n"
            . "E-mail: {$data['email']}\n"
            . "Woonplaats: {$data['woonplaats']}\n"
            . "Bron: {$data['lead']}\n"
            . "GCLID: {$gclid}\n"
            . "Bijlage: " . ($attachment ? '/data/uploads/' . $attachment : 'geen') . "\n\n"
            . "Bericht:\n{$data['message']}\n";
        $headers = 'From: ' . setting('site_title') . ' <' . setting('contact_email') . ">\r\n"
            . 'Reply-To: ' . $data['email'] . "\r\n"
            . "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($to, $subject, $body, $headers);
    }

    // Bevestiging naar de klant
    if ($data['email']) {
        $subjectC = 'We hebben uw bericht ontvangen — ' . setting('site_title');
        $bodyC = "Beste {$data['fullName']},\n\n"
            . "Bedankt voor uw bericht! We hebben het ontvangen en nemen zo snel mogelijk contact met u op.\n\n"
            . "Sneller antwoord nodig? Stuur ons een WhatsApp-bericht (met foto) via " . whatsapp_link() . "\n\n"
            . "Met vriendelijke groet,\n" . setting('site_title') . "\n" . phone_display() . "\n";
        $headersC = 'From: ' . setting('site_title') . ' <' . setting('contact_email') . ">\r\n"
            . "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($data['email'], $subjectC, $bodyC, $headersC);
    }

    redirect('/contact/bedankt');
}

function render_sitemap(): string
{
    $urls = [];
    $add = function (string $path, string $prio) use (&$urls) {
        $urls[] = ['loc' => url($path), 'priority' => $prio];
    };

    $add('', '1.0');
    foreach (menu_pages() as $p) $add($p['slug'], '0.8');
    $add('portfolio', '0.5');

    foreach (all_services() as $s) {
        $add('reinigen/' . $s['slug'], '0.9');
    }
    foreach (all_services() as $s) {
        foreach (all_cities() as $c) {
            $add('reinigen/' . $s['slug'] . '/' . $c['slug'], '0.6');
        }
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
        . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        $xml .= "<url><loc>" . htmlspecialchars($u['loc']) . "</loc><priority>{$u['priority']}</priority></url>\n";
    }
    $xml .= "</urlset>\n";
    return $xml;
}

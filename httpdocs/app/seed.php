<?php
/**
 * Seed-script: migreert alle Kirby-content (httpdocs/content) naar SQLite.
 * Draaien via CLI:  php app/seed.php
 *
 * - Maakt de database aan (data/site.sqlite)
 * - Kopieert afbeeldingen/video's naar media/
 * - Zaait instellingen, pagina's, diensten, steden, reviews en prijzen
 * - Maakt de admin-gebruiker aan
 */

if (PHP_SAPI !== 'cli') { exit("Alleen via CLI draaien: php app/seed.php\n"); }

require __DIR__ . '/config.php';
require __DIR__ . '/helpers.php';
require __DIR__ . '/db.php';
require __DIR__ . '/content.php';

$contentRoot = WEB_ROOT . '/content';
if (!is_dir($contentRoot)) {
    exit("Content-map niet gevonden: $contentRoot\n");
}

echo "=== De Reinigingsdokter — Kirby → SQLite migratie ===\n";

/* ------------------------------------------------------------------ */
/* Kirby tekstbestand parsen                                           */
/* ------------------------------------------------------------------ */

function kirby_parse(string $file): array
{
    if (!file_exists($file)) return [];
    $raw = file_get_contents($file);
    // normaliseer scheiders
    $parts = preg_split('/\n----\n/', str_replace("\r\n", "\n", $raw));
    $fields = [];
    foreach ($parts as $part) {
        $part = trim($part, "\n");
        if ($part === '') continue;
        if (!preg_match('/^([A-Za-z0-9_-]+):\s?(.*)$/s', $part, $m)) continue;
        $key = strtolower($m[1]);
        $val = $m[2];
        $fields[$key] = trim($val, "\n");
    }
    return $fields;
}

/** Mini-YAML-lijst parser voor Kirby structure-velden */
function kirby_yaml_list(?string $raw): array
{
    if ($raw === null || trim($raw) === '') return [];
    $lines = preg_split('/\n/', str_replace("\r\n", "\n", $raw));
    $items = [];
    $cur = null;
    $blockKey = null;      // huidige block-scalar key
    $blockMode = null;     // '>' of '|'
    $blockLines = [];

    $flushBlock = function () use (&$cur, &$blockKey, &$blockMode, &$blockLines) {
        if ($cur !== null && $blockKey !== null) {
            $cur[$blockKey] = $blockMode === '|'
                ? implode("\n", $blockLines)
                : implode(' ', array_map('trim', $blockLines));
        }
        $blockKey = null; $blockMode = null; $blockLines = [];
    };

    $handleField = function (string $key, string $val) use (&$cur, &$blockKey, &$blockMode, &$blockLines) {
        $key = strtolower($key);
        $val = trim($val);
        if ($val === '>' || $val === '|') { $blockKey = $key; $blockMode = $val; $blockLines = []; }
        elseif ($val !== '') $cur[$key] = $val;
    };

    foreach ($lines as $line) {
        // Nieuw item in de lijst
        if (preg_match('/^-\s*$/', $line)) {
            $flushBlock();
            if ($cur !== null && count($cur) > 0) $items[] = $cur;
            $cur = [];
            continue;
        }
        if (preg_match('/^-\s+([A-Za-z0-9_-]+):\s*(.*)$/', $line, $m)) {
            $flushBlock();
            if ($cur !== null && count($cur) > 0) $items[] = $cur;
            $cur = [];
            $handleField($m[1], $m[2]);
            continue;
        }
        // Veldregel op 2-space indent (beeindigt een lopend block)
        if (preg_match('/^ {2}([A-Za-z0-9_-]+):\s?(.*)$/', $line, $m)) {
            $flushBlock();
            $handleField($m[1], $m[2]);
            continue;
        }
        // Block-scalar content (dieper geindent)
        if ($blockKey !== null) {
            if (trim($line) === '') { continue; }
            if (preg_match('/^ {3,}(.*)$/', $line, $mm)) { $blockLines[] = trim($mm[1]); continue; }
            $flushBlock();
        }
    }
    $flushBlock();
    if ($cur !== null && count($cur) > 0) $items[] = $cur;
    return $items;
}

/** Simpele YAML-lijst van bestandsnamen ("- foto.jpg") */
function kirby_yaml_files(?string $raw): array
{
    if (!$raw) return [];
    $out = [];
    foreach (preg_split('/\n/', $raw) as $line) {
        if (preg_match('/^-\s+(.+)$/', trim($line), $m)) $out[] = trim($m[1]);
    }
    return $out;
}

/* ------------------------------------------------------------------ */
/* Media kopiëren                                                      */
/* ------------------------------------------------------------------ */

function copy_dir_media(string $src, string $dst): int
{
    if (!is_dir($src)) return 0;
    $n = 0;
    foreach (scandir($src) as $f) {
        if ($f === '.' || $f === '..') continue;
        $sp = $src . '/' . $f;
        $dp = $dst . '/' . $f;
        if (is_dir($sp)) {
            $n += copy_dir_media($sp, $dp);
        } else {
            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','svg','webp','mp4','webm'])) {
                if (!is_dir($dst)) mkdir($dst, 0775, true);
                if (!file_exists($dp)) copy($sp, $dp);
                $n++;
            }
        }
    }
    return $n;
}

// home-afbeeldingen
$n = copy_dir_media($contentRoot . '/1-home', MEDIA_DIR . '/home');
echo "Media home: $n bestanden\n";

// diensten-afbeeldingen (inclusief iconen, video's)
$n = 0;
foreach (scandir($contentRoot . '/2-reinigen') as $f) {
    if ($f === '.' || $f === '..') continue;
    $sp = $contentRoot . '/2-reinigen/' . $f;
    if (is_dir($sp)) {
        // hernoem genummerde dirs: 1-meubelreiniging -> meubelreiniging; 1-amsterdam -> amsterdam
        $clean = preg_replace('/^\d+-/', '', $f);
        if ($clean === '1-amsterdam') $clean = 'amsterdam';
        $n += copy_dir_media($sp, MEDIA_DIR . '/reinigen/' . $clean);
    } else {
        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif','svg','webp','mp4','webm'])) {
            if (!is_dir(MEDIA_DIR . '/reinigen')) mkdir(MEDIA_DIR . '/reinigen', 0775, true);
            if (!file_exists(MEDIA_DIR . '/reinigen/' . $f)) copy($sp, MEDIA_DIR . '/reinigen/' . $f);
            $n++;
        }
    }
}
echo "Media diensten: $n bestanden\n";

$n = copy_dir_media($contentRoot . '/6-portfolio', MEDIA_DIR . '/portfolio');
echo "Media portfolio: $n bestanden\n";

/* ------------------------------------------------------------------ */
/* Instellingen                                                        */
/* ------------------------------------------------------------------ */

$site = kirby_parse($contentRoot . '/site.nl.txt');

function k_year_replace(string $s): string
{
    return str_replace(['(date: Year)', '(date: year)'], date('Y'), $s);
}

$defaults = [
    'site_title'        => $site['title'] ?? 'De Reinigingsdokter',
    'site_description'  => $site['description'] ?? '',
    'slogan'            => $site['globel-slogan'] ?? 'We zorgen voor een schoon gevoel dat is onze zorg!',
    'menu_label'        => $site['globel-menu'] ?? 'Menu',
    'close_label'       => $site['globel-close'] ?? 'Close',
    'footer_sitemap_title' => $site['footer-sitemap-title'] ?? 'Schoon gevoel',
    'footer_sitemap_desc'  => k_year_replace($site['footer-sitemap-desc'] ?? ''),
    'footer_contact_title' => $site['footer-contact-title'] ?? 'Contactgegevens',
    'footer_contact_desc'  => $site['footer-contact-desc'] ?? '',
    'review_badge_title'   => $site['review-title'] ?? 'Voortreffelijk',
    'review_badge_sub'     => $site['review-sub'] ?? '43 beoordelingen',
    'review_badge_nr'      => $site['review-nr'] ?? '9,6',
    'phone_display'        => '06-47249157',
    'whatsapp_number'      => '31647249157',
    'whatsapp_message'     => 'Hallo, ik kom graag in contact voor een reiniging. Kunnen jullie mij helpen?',
    'whatsapp_float'       => '1',
    'notify_email'         => 'info@reinigingsdokter.nl',
    'contact_email'        => 'info@reinigingsdokter.nl',
    'address_street'       => 'Laan der Verenigde Naties 40',
    'address_zip'          => '3314 DA',
    'address_city'         => 'Dordrecht',
    'address_region'       => 'Zuid-Holland',
    'facebook'             => 'https://www.facebook.com/Dereinigingsdokter/',
    'instagram'            => 'https://www.instagram.com/dereinigingsdokter/',
    'analytics_id'         => 'G-7QV8FFJCF4',
    'ads_id'               => '',
    'ads_conversion_form'  => '',
    'ads_conversion_whatsapp' => '',
    'base_url'             => '',
];
foreach ($defaults as $k => $v) setting_save($k, html_entity_decode((string)$v, ENT_QUOTES, 'UTF-8'));
echo "Instellingen: " . count($defaults) . " gezet\n";

/* ------------------------------------------------------------------ */
/* Pagina-hulpfuncties                                                 */
/* ------------------------------------------------------------------ */

$pdo = db();

function upsert_page(string $slug, string $template, string $title, int $inMenu, int $sort): int
{
    $pdo = db();
    $st = $pdo->prepare('INSERT INTO pages (slug, template, title, in_menu, sort, active, updated_at)
        VALUES (?,?,?,?,?,1, datetime("now"))
        ON CONFLICT(slug) DO UPDATE SET template=excluded.template, title=excluded.title,
        in_menu=excluded.in_menu, sort=excluded.sort, updated_at=datetime("now")');
    $st->execute([$slug, $template, $title, $inMenu, $sort]);
    $st2 = $pdo->prepare('SELECT id FROM pages WHERE slug = ?');
    $st2->execute([$slug]);
    return (int)$st2->fetchColumn();
}

function save_fields(int $pageId, array $fields): void
{
    foreach ($fields as $k => $v) {
        if ($v === null || !is_string($v)) continue;
        $v = html_entity_decode($v, ENT_QUOTES, 'UTF-8');
        page_save_field($pageId, strtolower($k), $v);
    }
}

/* ------------------------------------------------------------------ */
/* Home                                                                */
/* ------------------------------------------------------------------ */

$home = kirby_parse($contentRoot . '/1-home/home.nl.txt');
$homeId = upsert_page('', 'home', $home['title'] ?? 'Home', 1, 1);
save_fields($homeId, [
    'title' => $home['title'] ?? 'Home',
    'meta_title' => $home['meta-title'] ?? '',
    'meta_description' => $home['meta-description'] ?? '',
    'hero_title' => $home['hero-title'] ?? '',
    'hero_subtitle' => "Wij reinigen meubels, banken, matrassen, interieur van auto's, tapijten op locatie door heel Nederland en België.",
    'hero_image' => $home['hero-image'] ?? '',
    'plus_title' => $home['plus-title'] ?? '',
    'plus_list' => $home['plus-list'] ?? '',
    'plus_photos' => $home['plus-photos'] ?? '',
    'review_title' => $home['review-title'] ?? 'Dit vinden onze klanten',
]);
echo "Home pagina gezaaid\n";

/* ------------------------------------------------------------------ */
/* Reinigen-overzicht                                                  */
/* ------------------------------------------------------------------ */

$services = kirby_parse($contentRoot . '/2-reinigen/services.nl.txt');
$reinigenId = upsert_page('reinigen', 'services', $services['title'] ?? 'Reinigen', 1, 2);
save_fields($reinigenId, [
    'meta_title' => $services['meta-title'] ?? '',
    'meta_description' => $services['meta-description'] ?? '',
    'intro_title' => $services['intro-title'] ?? '',
    'intro_description' => $services['intro-description'] ?? '',
    'content_examples' => json_encode(kirby_yaml_list($services['content-examples'] ?? '')),
    'enable_contact' => '0',
]);
echo "Reinigen-overzicht gezaaid\n";

/* ------------------------------------------------------------------ */
/* Diensten                                                            */
/* ------------------------------------------------------------------ */

$serviceDirs = [];
foreach (scandir($contentRoot . '/2-reinigen') as $d) {
    if ($d === '.' || $d === '..') continue;
    $full = $contentRoot . '/2-reinigen/' . $d;
    if (!is_dir($full)) continue;
    $txt = $full . '/service.nl.txt';
    if (!file_exists($txt)) continue;
    $slug = preg_replace('/^\d+-/', '', $d);
    $serviceDirs[] = ['dir' => $full, 'txt' => $txt, 'slug' => $slug, 'sort' => (int)$d];
}
usort($serviceDirs, fn($a, $b) => $a['sort'] <=> $b['sort']);

foreach ($serviceDirs as $sd) {
    $f = kirby_parse($sd['txt']);
    $title = $f['title'] ?? ucfirst($sd['slug']);

    // icon
    $icon = '';
    foreach (glob($sd['dir'] . '/icon-*.svg') as $ic) {
        $rel = 'reinigen/' . $sd['slug'] . '/' . basename($ic);
        if (file_exists(MEDIA_DIR . '/' . $rel)) $icon = $rel;
    }

    $st = $pdo->prepare('INSERT INTO services (slug, title, label, icon, sort, active)
        VALUES (?,?,?,?,?,1) ON CONFLICT(slug) DO UPDATE SET title=excluded.title,
        label=excluded.label, icon=excluded.icon, sort=excluded.sort');
    $st->execute([$sd['slug'], $title, $f['label'] ?? $title, $icon, $sd['sort']]);

    $pageId = upsert_page('reinigen/' . $sd['slug'], 'service', $title, 0, $sd['sort']);
    save_fields($pageId, [
        'meta_title' => $f['meta-title'] ?? '',
        'meta_description' => $f['meta-description'] ?? '',
        'intro_title' => $f['intro-title'] ?? $title,
        'intro_description' => $f['intro-description'] ?? '',
        'enable_contact' => $f['enable-contact'] ?? '1',
        'content_description' => $f['content-description'] ?? '',
        'content_intro_price' => $f['content-intro-price'] ?? '',
        'content_price' => $f['content-price'] ?? '',
        'content_text_pre' => $f['content-text-pre'] ?? '',
        'content_img_pre' => $f['content-img-pre'] ?? '',
        'content_text_after' => $f['content-text-after'] ?? '',
        'content_img_after' => $f['content-img-after'] ?? '',
        'content_showpriceid' => $f['content-showpriceid'] ?? '',
        'content_video_description' => $f['content-video-description'] ?? '',
        'content_video_text' => $f['content-video-text'] ?? '',
        'content_examples' => json_encode(kirby_yaml_list($f['content-examples'] ?? '')),
        'label' => $f['label'] ?? $title,
        'icon' => $icon,
    ]);
    echo "Dienst: $title\n";
}

/* ------------------------------------------------------------------ */
/* Tarieven                                                            */
/* ------------------------------------------------------------------ */

$prices = kirby_parse($contentRoot . '/3-tarieven/prices.nl.txt');
$pricesId = upsert_page('tarieven', 'prices', $prices['title'] ?? 'Tarieven', 1, 3);
save_fields($pricesId, [
    'meta_title' => $prices['meta-title'] ?? '',
    'meta_description' => $prices['meta-description'] ?? '',
    'intro_title' => $prices['intro-title'] ?? 'Dit zijn onze tarieven',
    'intro_description' => $prices['intro-description'] ?? '',
]);
echo "Tarieven gezaaid\n";

/* ------------------------------------------------------------------ */
/* Reviews                                                             */
/* ------------------------------------------------------------------ */

$revPage = kirby_parse($contentRoot . '/4-reviews/reviews.nl.txt');
$reviewsId = upsert_page('reviews', 'reviews', $revPage['title'] ?? 'Reviews', 1, 4);
save_fields($reviewsId, [
    'meta_title' => $revPage['meta-title'] ?? '',
    'meta_description' => $revPage['meta-description'] ?? '',
    'intro_title' => 'Dit vinden onze klanten',
    'intro_description' => $revPage['intro-description'] ?? '',
]);

$reviewItems = kirby_yaml_list($revPage['review-list'] ?? '');
$pdo->exec('DELETE FROM reviews');
$stR = $pdo->prepare('INSERT INTO reviews (title, name, content, service, country, active, sort) VALUES (?,?,?,?,?,1,?)');
$ri = 0;
foreach ($reviewItems as $r) {
    $stR->execute([
        html_entity_decode($r['s_title'] ?? '', ENT_QUOTES, 'UTF-8'),
        html_entity_decode($r['s_name'] ?? '', ENT_QUOTES, 'UTF-8'),
        html_entity_decode($r['s_content'] ?? '', ENT_QUOTES, 'UTF-8'),
        $r['s_sevice'] ?? '',
        $r['s_country'] ?? 'nl',
        $ri++,
    ]);
}
echo "Reviews: $ri gezaaid\n";

/* ------------------------------------------------------------------ */
/* Contact                                                             */
/* ------------------------------------------------------------------ */

$con = kirby_parse($contentRoot . '/5-contact/contact.nl.txt');
$contactId = upsert_page('contact', 'contact', $con['title'] ?? 'Contact', 1, 5);
save_fields($contactId, [
    'meta_title' => $con['meta-title'] ?? '',
    'meta_description' => $con['meta-description'] ?? '',
    'intro_title' => $con['intro-title'] ?? 'Neem contact op met De Reinigingsdokter',
    'intro_description' => $con['intro-description'] ?? '',
    'form_message' => $con['form-message'] ?? '',
    'thank_you_message' => $con['thank-you-message'] ?? '',
    'side_address' => $con['side-address'] ?? '',
]);
echo "Contact gezaaid\n";

$bedankt = kirby_parse($contentRoot . '/5-contact/1-bedankt/page.nl.txt')
    ?: kirby_parse($contentRoot . '/5-contact/1-bedankt/contact.nl.txt')
    ?: kirby_parse($contentRoot . '/5-contact/1-bedankt/default.nl.txt');
if (!$bedankt) {
    // zoek een txt in de map
    $files = glob($contentRoot . '/5-contact/1-bedankt/*.txt');
    if ($files) $bedankt = kirby_parse($files[0]);
}
$bedanktId = upsert_page('contact/bedankt', 'thanks', $bedankt['title'] ?? 'Bedankt', 0, 6);
save_fields($bedanktId, [
    'meta_title' => $bedankt['meta-title'] ?? 'Bedankt voor uw bericht',
    'meta_description' => $bedankt['meta-description'] ?? '',
    'thank_you_message' => $bedankt['thank-you-message'] ?? "## Bedankt voor uw bericht!\nWe nemen zo snel mogelijk contact met u op.",
]);
echo "Bedankt-pagina gezaaid\n";

/* ------------------------------------------------------------------ */
/* Portfolio                                                           */
/* ------------------------------------------------------------------ */

$port = kirby_parse($contentRoot . '/6-portfolio/service.nl.txt');
$portId = upsert_page('portfolio', 'page', $port['title'] ?? 'Portfolio', 0, 7);
save_fields($portId, [
    'meta_title' => $port['meta-title'] ?: ($port['title'] ?? 'Portfolio'),
    'meta_description' => $port['meta-description'] ?? '',
    'intro_title' => $port['intro-title'] ?? 'Portfolio',
    'intro_description' => $port['intro-description'] ?? '',
    'content_description' => $port['content-description'] ?? '',
    'content_text_pre' => $port['content-text-pre'] ?? '',
    'content_img_pre' => $port['content-img-pre'] ?? '',
    'content_text_after' => $port['content-text-after'] ?? '',
    'content_img_after' => $port['content-img-after'] ?? '',
    'enable_contact' => '0',
    'media_dir' => 'portfolio',
]);
echo "Portfolio gezaaid\n";

/* ------------------------------------------------------------------ */
/* Prijzen (uit de oude shared/prices-blokken)                         */
/* ------------------------------------------------------------------ */

$priceData = [
    'Bankreiniging' => [
        ['Tweezitsbank', '€ 39'], ['Driezitsbank', '€ 49'], ['Vierzitsbank', '€ 79'],
        ['Vijfzitsbank', '€ 99'], ['Impregneren', 'op aanvraag'],
    ],
    'Stoelreiniging' => [
        ['Meubelreiniging fauteuil', '€ 39'], ['Meubelreiniging loveseat', '€ 79'],
        ['Meubelreiniging eetkamerstoel', '€ 25'],
    ],
    'Matrasreiniging' => [
        ['Kindermatras', '€ 30'], ['1 Persoonsmatras', '€ 39'],
        ['Twijfelaar matras', '€ 59'], ['2 Persoonsmatras', '€ 79'],
    ],
    'Auto interieurreiniging' => [
        ['Auto interieurreiniging', '€ 69'],
    ],
    'Tapijt reiniging' => [
        ['Tapijt reiniging', '€ 4,50 per m²'],
    ],
    'Gevelreiniging' => [
        ['Prijzen op aanvraag', ''],
    ],
    'Zonnepanelen reinigen' => [
        ['1 - 15 zonnepanelen', '€ 85'], ['16 - 24 zonnepanelen', '€ 105'],
        ['25 - 40 zonnepanelen', '€ 135'],
    ],
    'Kantoorpanden' => [
        ['Prijzen op aanvraag', ''], ['Restaurants', ''], ['Winkelcentra', ''],
        ['Scholen', ''], ['Kinderdagverblijven', ''], ['Appartementencomplexen', ''],
    ],
];

$pdo->exec('DELETE FROM price_items');
$pdo->exec('DELETE FROM price_groups');
$stG = $pdo->prepare('INSERT INTO price_groups (title, sort) VALUES (?,?)');
$stI = $pdo->prepare('INSERT INTO price_items (group_id, name, price, sort) VALUES (?,?,?,?)');
$gi = 0;
foreach ($priceData as $group => $items) {
    $stG->execute([$group, $gi]);
    $gid = (int)$pdo->lastInsertId();
    $ii = 0;
    foreach ($items as $it) $stI->execute([$gid, $it[0], $it[1], $ii++]);
    $gi++;
}
echo "Prijzen: $gi groepen gezaaid\n";

/* ------------------------------------------------------------------ */
/* Steden                                                              */
/* ------------------------------------------------------------------ */

$cityList = require __DIR__ . '/citydata.php';
$pdo->exec('DELETE FROM cities');
$stC = $pdo->prepare('INSERT OR IGNORE INTO cities (slug, name, province, enabled) VALUES (?,?,?,1)');
$ci = 0;
foreach ($cityList as $c) {
    $name = trim($c[0]);
    $stC->execute([slugify($name), $name, trim($c[1])]);
    $ci++;
}
$total = (int)$pdo->query('SELECT COUNT(*) FROM cities')->fetchColumn();
echo "Steden: $total unieke plaatsen gezaaid (uit $ci invoer)\n";

/* ------------------------------------------------------------------ */
/* Admin-gebruiker                                                     */
/* ------------------------------------------------------------------ */

$exists = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
if ($exists === 0) {
    $st = $pdo->prepare('INSERT INTO users (username, password_hash, must_change) VALUES (?,?,1)');
    $st->execute(['admin', password_hash('Reiniging@2026!', PASSWORD_DEFAULT)]);
    echo "Admin-gebruiker aangemaakt: admin / Reiniging@2026! (verander dit direct na de eerste login)\n";
} else {
    echo "Admin-gebruiker bestaat al — niet overschreven\n";
}

echo "\n=== Migratie klaar ===\n";
echo "Database: " . DATA_DIR . "/site.sqlite\n";

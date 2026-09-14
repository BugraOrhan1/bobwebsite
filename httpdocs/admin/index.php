<?php
/**
 * Admin-paneel — frontcontroller.
 * Alleen toegankelijk met login; alle wijzigingen via POST + CSRF.
 */

require dirname(__DIR__) . '/app/bootstrap.php';

$basePath = '/admin';

/* ------------------------------------------------------------------ */
/* Auth                                                                */
/* ------------------------------------------------------------------ */

function admin_logged_in(): bool
{
    return !empty($_SESSION['admin_uid']);
}

function admin_require_login(): void
{
    if (!admin_logged_in()) redirect('/admin/login');
}

function login_blocked(string $ip): bool
{
    $st = db()->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip = ? AND created_at > ?');
    $st->execute([$ip, time() - 900]);
    return (int)$st->fetchColumn() >= 8;
}

function register_attempt(string $ip): void
{
    $st = db()->prepare('INSERT INTO login_attempts (ip, created_at) VALUES (?, ?)');
    $st->execute([$ip, time()]);
    db()->prepare('DELETE FROM login_attempts WHERE created_at < ?')->execute([time() - 3600]);
}

/* ------------------------------------------------------------------ */
/* Routing                                                             */
/* ------------------------------------------------------------------ */

$path = request_path();            // bijv. admin/leads
$route = substr($path, strlen('admin')) ?: '/';
$route = '/' . trim($route, '/');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Login/logout altijd toegestaan
if ($route === '/login') {
    if (admin_logged_in()) redirect('/admin');
    if ($method === 'POST') {
        if (!csrf_check()) redirect('/admin/login');
        $ip = client_ip();
        if (login_blocked($ip)) {
            flash_set('Te veel pogingen. Probeer het over 15 minuten opnieuw.', 'err');
            redirect('/admin/login');
        }
        $username = trim($_POST['username'] ?? '');
        $password = (string)($_POST['password'] ?? '');
        $st = db()->prepare('SELECT * FROM users WHERE username = ?');
        $st->execute([$username]);
        $user = $st->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_uid'] = (int)$user['id'];
            $_SESSION['admin_user'] = $user['username'];
            db()->prepare('DELETE FROM login_attempts WHERE ip = ?')->execute([$ip]);
            redirect('/admin');
        }
        register_attempt($ip);
        flash_set('Onjuiste gebruikersnaam of wachtwoord.', 'err');
        redirect('/admin/login');
    }
    admin_view('login');
    exit;
}

if ($route === '/logout') {
    $_SESSION = [];
    session_destroy();
    redirect('/admin/login');
}

admin_require_login();

/* ------------------------------------------------------------------ */
/* Bijlage downloaden (afgeschermd via login)                          */
/* ------------------------------------------------------------------ */

if ($route === '/bijlage') {
    $id = (int)($_GET['id'] ?? 0);
    $st = db()->prepare('SELECT attachment FROM leads WHERE id = ?');
    $st->execute([$id]);
    $att = $st->fetchColumn();
    $file = $att ? UPLOAD_DIR . '/' . basename($att) : '';
    if (!$file || !file_exists($file)) { flash_set('Bijlage niet gevonden.', 'err'); redirect('/admin/leads'); }
    header('Content-Type: ' . (mime_content_type($file) ?: 'application/octet-stream'));
    header('Content-Disposition: inline; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

/* ------------------------------------------------------------------ */
/* Dashboard                                                           */
/* ------------------------------------------------------------------ */

if ($route === '/') {
    $pdo = db();
    $stats = [
        'leads_total' => (int)$pdo->query('SELECT COUNT(*) FROM leads')->fetchColumn(),
        'leads_unread' => (int)$pdo->query('SELECT COUNT(*) FROM leads WHERE is_read = 0')->fetchColumn(),
        'leads_week' => (int)$pdo->query("SELECT COUNT(*) FROM leads WHERE created_at >= datetime('now','-7 days')")->fetchColumn(),
        'leads_month' => (int)$pdo->query("SELECT COUNT(*) FROM leads WHERE created_at >= datetime('now','-30 days')")->fetchColumn(),
        'cities' => city_page_count(),
        'reviews' => (int)$pdo->query('SELECT COUNT(*) FROM reviews')->fetchColumn(),
    ];
    $recentLeads = $pdo->query('SELECT * FROM leads ORDER BY id DESC LIMIT 8')->fetchAll();
    $user = db()->prepare('SELECT must_change FROM users WHERE id = ?');
    $user->execute([$_SESSION['admin_uid']]);
    $mustChange = (int)$user->fetchColumn() === 1;
    admin_view('dashboard', compact('stats', 'recentLeads', 'mustChange'));
    exit;
}

/* ------------------------------------------------------------------ */
/* Leads                                                               */
/* ------------------------------------------------------------------ */

if ($route === '/leads') {
    $pdo = db();
    if ($method === 'POST' && csrf_check()) {
        $action = $_POST['action'] ?? '';
        $id = (int)($_POST['id'] ?? 0);
        if ($action === 'read') $pdo->prepare('UPDATE leads SET is_read = 1 WHERE id = ?')->execute([$id]);
        if ($action === 'unread') $pdo->prepare('UPDATE leads SET is_read = 0 WHERE id = ?')->execute([$id]);
        if ($action === 'delete') {
            $lead = $pdo->prepare('SELECT attachment FROM leads WHERE id = ?');
            $lead->execute([$id]);
            $att = $lead->fetchColumn();
            if ($att && file_exists(UPLOAD_DIR . '/' . basename($att))) unlink(UPLOAD_DIR . '/' . basename($att));
            $pdo->prepare('DELETE FROM leads WHERE id = ?')->execute([$id]);
            flash_set('Lead verwijderd.');
        }
        if ($action === 'mark_all') { $pdo->exec('UPDATE leads SET is_read = 1'); flash_set('Alle leads gemarkeerd als gelezen.'); }
        redirect('/admin/leads');
    }
    $page = max(1, (int)($_GET['p'] ?? 1));
    $perPage = 20;
    $total = (int)$pdo->query('SELECT COUNT(*) FROM leads')->fetchColumn();
    $st = $pdo->prepare('SELECT * FROM leads ORDER BY id DESC LIMIT ? OFFSET ?');
    $st->bindValue(1, $perPage, PDO::PARAM_INT);
    $st->bindValue(2, ($page - 1) * $perPage, PDO::PARAM_INT);
    $st->execute();
    $leads = $st->fetchAll();
    admin_view('leads', ['leads' => $leads, 'total' => $total, 'page' => $page, 'perPage' => $perPage]);
    exit;
}

/* ------------------------------------------------------------------ */
/* Pagina's                                                            */
/* ------------------------------------------------------------------ */

if ($route === '/paginas') {
    $pages = db()->query('SELECT * FROM pages ORDER BY sort ASC, id ASC')->fetchAll();
    admin_view('pages_list', ['pages' => $pages]);
    exit;
}

if ($route === '/paginas/edit') {
    $id = (int)($_GET['id'] ?? 0);
    $st = db()->prepare('SELECT * FROM pages WHERE id = ?');
    $st->execute([$id]);
    $p = $st->fetch();
    if (!$p) { flash_set('Pagina niet gevonden.', 'err'); redirect('/admin/paginas'); }
    $p = page_with_fields($p);

    if ($method === 'POST' && csrf_check()) {
        $pdo = db();
        $pdo->prepare('UPDATE pages SET title = ?, in_menu = ?, updated_at = datetime("now") WHERE id = ?')
            ->execute([trim($_POST['title'] ?? $p['title']), isset($_POST['in_menu']) ? 1 : 0, $id]);
        $editable = ['meta_title','meta_description','hero_title','hero_subtitle','plus_title','plus_list',
            'review_title','intro_title','intro_description','form_message','thank_you_message',
            'side_address','content_description','content_intro_price','content_price'];
        foreach ($editable as $key) {
            if (array_key_exists($key, $_POST)) {
                page_save_field($id, $key, clean_html($_POST[$key]));
            }
        }
        flash_set('Pagina opgeslagen.');
        redirect('/admin/paginas/edit?id=' . $id);
    }
    admin_view('pages_edit', ['p' => $p]);
    exit;
}

/* ------------------------------------------------------------------ */
/* Diensten                                                            */
/* ------------------------------------------------------------------ */

if ($route === '/diensten') {
    $services = all_services(false);
    if ($method === 'POST' && csrf_check()) {
        $pdo = db();
        $pdo->prepare('UPDATE services SET active = ?, title = ? WHERE id = ?')
            ->execute([isset($_POST['active']) ? 1 : 0, trim($_POST['title'] ?? ''), (int)$_POST['id']]);
        flash_set('Dienst opgeslagen.');
        redirect('/admin/diensten');
    }
    admin_view('services_list', ['services' => $services]);
    exit;
}

if ($route === '/diensten/edit') {
    $slug = $_GET['slug'] ?? '';
    $service = service_by_slug($slug);
    if (!$service) { flash_set('Dienst niet gevonden.', 'err'); redirect('/admin/diensten'); }
    $p = service_page($service);

    if ($method === 'POST' && csrf_check()) {
        $editable = ['meta_title','meta_description','intro_title','intro_description','content_description',
            'content_intro_price','content_price','content_showpriceid','content_video_description','label'];
        foreach ($editable as $key) {
            if (array_key_exists($key, $_POST)) page_save_field($p['id'], $key, clean_html($_POST[$key]));
        }
        if (isset($_POST['enable_contact'])) page_save_field($p['id'], 'enable_contact', '1');
        else page_save_field($p['id'], 'enable_contact', '0');
        db()->prepare('UPDATE services SET title = ?, label = ? WHERE id = ?')
            ->execute([trim($_POST['title'] ?? $service['title']), trim($_POST['label'] ?? ($service['label'] ?? '')), $service['id']]);
        flash_set('Dienst opgeslagen.');
        redirect('/admin/diensten/edit?slug=' . urlencode($slug));
    }
    admin_view('services_edit', ['service' => $service, 'p' => $p]);
    exit;
}

/* ------------------------------------------------------------------ */
/* Steden                                                              */
/* ------------------------------------------------------------------ */

if ($route === '/steden') {
    $pdo = db();
    if ($method === 'POST' && csrf_check()) {
        $action = $_POST['action'] ?? '';
        if ($action === 'toggle') {
            $pdo->prepare('UPDATE cities SET enabled = 1 - enabled WHERE id = ?')->execute([(int)$_POST['id']]);
        }
        if ($action === 'bulk') {
            $ids = array_map('intval', $_POST['ids'] ?? []);
            $state = isset($_POST['enable']) ? 1 : 0;
            if ($ids) {
                $in = implode(',', $ids);
                $pdo->exec("UPDATE cities SET enabled = $state WHERE id IN ($in)");
            }
            flash_set('Steden bijgewerkt.');
        }
        redirect('/admin/steden' . (!empty($_POST['q']) ? '?q=' . urlencode($_POST['q']) : '') . (!empty($_POST['prov']) ? '&prov=' . urlencode($_POST['prov']) : ''));
    }
    $q = trim($_GET['q'] ?? '');
    $prov = trim($_GET['prov'] ?? '');
    $sql = 'SELECT * FROM cities WHERE 1=1';
    $args = [];
    if ($q !== '') { $sql .= ' AND name LIKE ?'; $args[] = '%' . $q . '%'; }
    if ($prov !== '') { $sql .= ' AND province = ?'; $args[] = $prov; }
    $sql .= ' ORDER BY name ASC LIMIT 200';
    $st = $pdo->prepare($sql);
    $st->execute($args);
    $cities = $st->fetchAll();
    $provinces = $pdo->query('SELECT DISTINCT province FROM cities ORDER BY province')->fetchAll(PDO::FETCH_COLUMN);
    $counts = [
        'total' => (int)$pdo->query('SELECT COUNT(*) FROM cities')->fetchColumn(),
        'enabled' => (int)$pdo->query('SELECT COUNT(*) FROM cities WHERE enabled = 1')->fetchColumn(),
    ];
    admin_view('cities_list', compact('cities', 'provinces', 'q', 'prov', 'counts'));
    exit;
}

if ($route === '/steden/edit') {
    $id = (int)($_GET['id'] ?? 0);
    $st = db()->prepare('SELECT * FROM cities WHERE id = ?');
    $st->execute([$id]);
    $city = $st->fetch();
    if (!$city) { flash_set('Stad niet gevonden.', 'err'); redirect('/admin/steden'); }

    if ($method === 'POST' && csrf_check()) {
        db()->prepare('UPDATE cities SET name = ?, province = ?, intro = ?, enabled = ? WHERE id = ?')
            ->execute([
                trim($_POST['name'] ?? $city['name']),
                trim($_POST['province'] ?? $city['province']),
                clean_html($_POST['intro'] ?? ''),
                isset($_POST['enabled']) ? 1 : 0,
                $id,
            ]);
        flash_set('Stadspagina opgeslagen. De intro-tekst wordt nu gebruikt op álle dienstenpagina\'s van deze plaats.');
        redirect('/admin/steden/edit?id=' . $id);
    }
    admin_view('cities_edit', ['city' => $city]);
    exit;
}

/* ------------------------------------------------------------------ */
/* Prijzen                                                             */
/* ------------------------------------------------------------------ */

if ($route === '/prijzen') {
    $pdo = db();
    if ($method === 'POST' && csrf_check()) {
        // Verwijderingen
        foreach (array_keys($_POST['delete_group'] ?? []) as $gid) {
            $gid = (int)$gid;
            $pdo->prepare('DELETE FROM price_items WHERE group_id = ?')->execute([$gid]);
            $pdo->prepare('DELETE FROM price_groups WHERE id = ?')->execute([$gid]);
        }
        foreach (array_keys($_POST['delete_item'] ?? []) as $iid) {
            $pdo->prepare('DELETE FROM price_items WHERE id = ?')->execute([(int)$iid]);
        }
        // Updates bestaande items
        foreach ($_POST['item'] ?? [] as $iid => $vals) {
            $iid = (int)$iid;
            if ($iid <= 0) continue;
            $pdo->prepare('UPDATE price_items SET name = ?, price = ? WHERE id = ?')
                ->execute([trim($vals['name'] ?? ''), trim($vals['price'] ?? ''), $iid]);
        }
        foreach ($_POST['group'] ?? [] as $gid => $vals) {
            $gid = (int)$gid;
            if ($gid <= 0) continue;
            $pdo->prepare('UPDATE price_groups SET title = ? WHERE id = ?')
                ->execute([trim($vals['title'] ?? ''), $gid]);
        }
        // Nieuwe groep
        if (trim($_POST['new_group_title'] ?? '') !== '') {
            $pdo->prepare('INSERT INTO price_groups (title, sort) VALUES (?, 99)')
                ->execute([trim($_POST['new_group_title'])]);
        }
        // Nieuwe items
        foreach ($_POST['new_item'] ?? [] as $ni) {
            $gid = (int)($ni['group'] ?? 0);
            if ($gid > 0 && trim($ni['name'] ?? '') !== '') {
                $pdo->prepare('INSERT INTO price_items (group_id, name, price, sort) VALUES (?,?,?,99)')
                    ->execute([$gid, trim($ni['name']), trim($ni['price'] ?? '')]);
            }
        }
        flash_set('Prijzen opgeslagen.');
        redirect('/admin/prijzen');
    }
    $groups = price_groups_with_items();
    admin_view('prices', ['groups' => $groups]);
    exit;
}

/* ------------------------------------------------------------------ */
/* Reviews                                                             */
/* ------------------------------------------------------------------ */

if ($route === '/reviews') {
    $pdo = db();
    if ($method === 'POST' && csrf_check()) {
        $action = $_POST['action'] ?? '';
        if ($action === 'delete') {
            $pdo->prepare('DELETE FROM reviews WHERE id = ?')->execute([(int)$_POST['id']]);
            flash_set('Review verwijderd.');
        }
        if ($action === 'approve') {
            $pdo->prepare('UPDATE reviews SET active = 1, pending = 0 WHERE id = ?')->execute([(int)$_POST['id']]);
            flash_set('Review goedgekeurd en gepubliceerd op de site.');
        }
        if ($action === 'toggle') {
            $pdo->prepare('UPDATE reviews SET active = 1 - active WHERE id = ?')->execute([(int)$_POST['id']]);
        }
        redirect('/admin/reviews');
    }
    $reviews = $pdo->query('SELECT * FROM reviews ORDER BY service ASC, sort ASC')->fetchAll();
    admin_view('reviews_list', ['reviews' => $reviews]);
    exit;
}

if ($route === '/reviews/edit') {
    $pdo = db();
    $id = (int)($_GET['id'] ?? 0);
    $review = ['id' => 0, 'title' => '', 'name' => '', 'content' => '', 'service' => '', 'active' => 1];
    if ($id > 0) {
        $st = $pdo->prepare('SELECT * FROM reviews WHERE id = ?');
        $st->execute([$id]);
        $found = $st->fetch();
        if (!$found) { flash_set('Review niet gevonden.', 'err'); redirect('/admin/reviews'); }
        $review = $found;
    }
    $serviceLabels = $pdo->query('SELECT DISTINCT label FROM services ORDER BY label')->fetchAll(PDO::FETCH_COLUMN);

    if ($method === 'POST' && csrf_check()) {
        $data = [
            trim($_POST['title'] ?? ''),
            trim($_POST['name'] ?? ''),
            trim($_POST['content'] ?? ''),
            trim($_POST['service'] ?? ''),
            isset($_POST['active']) ? 1 : 0,
        ];
        if ($id > 0) {
            $pdo->prepare('UPDATE reviews SET title=?, name=?, content=?, service=?, active=? WHERE id=?')
                ->execute(array_merge($data, [$id]));
        } else {
            $pdo->prepare('INSERT INTO reviews (title, name, content, service, active, sort) VALUES (?,?,?,?,?,99)')
                ->execute($data);
        }
        flash_set('Review opgeslagen.');
        redirect('/admin/reviews');
    }
    admin_view('reviews_edit', ['review' => $review, 'serviceLabels' => $serviceLabels]);
    exit;
}

/* ------------------------------------------------------------------ */
/* FAQ's                                                               */
/* ------------------------------------------------------------------ */

if ($route === '/faq') {
    $pdo = db();
    if ($method === 'POST' && csrf_check()) {
        $action = $_POST['action'] ?? '';
        if ($action === 'delete') $pdo->prepare('DELETE FROM faqs WHERE id = ?')->execute([(int)$_POST['id']]);
        if ($action === 'toggle') $pdo->prepare('UPDATE faqs SET active = 1 - active WHERE id = ?')->execute([(int)$_POST['id']]);
        redirect('/admin/faq');
    }
    $faqs = $pdo->query('SELECT * FROM faqs ORDER BY sort ASC, id ASC')->fetchAll();
    admin_view('faqs_list', ['faqs' => $faqs]);
    exit;
}

if ($route === '/faq/edit') {
    $pdo = db();
    $id = (int)($_GET['id'] ?? 0);
    $faq = ['id' => 0, 'question' => '', 'answer' => '', 'active' => 1];
    if ($id > 0) {
        $st = $pdo->prepare('SELECT * FROM faqs WHERE id = ?');
        $st->execute([$id]);
        $found = $st->fetch();
        if (!$found) { flash_set('FAQ niet gevonden.', 'err'); redirect('/admin/faq'); }
        $faq = $found;
    }
    if ($method === 'POST' && csrf_check()) {
        $data = [trim($_POST['question'] ?? ''), trim($_POST['answer'] ?? ''), isset($_POST['active']) ? 1 : 0];
        if ($id > 0) {
            $pdo->prepare('UPDATE faqs SET question = ?, answer = ?, active = ? WHERE id = ?')
                ->execute(array_merge($data, [$id]));
        } else {
            $pdo->prepare('INSERT INTO faqs (question, answer, active, sort) VALUES (?,?,?,99)')->execute($data);
        }
        flash_set('FAQ opgeslagen.');
        redirect('/admin/faq');
    }
    admin_view('faqs_edit', ['faq' => $faq]);
    exit;
}

/* ------------------------------------------------------------------ */
/* Instellingen                                                        */
/* ------------------------------------------------------------------ */

if ($route === '/instellingen') {
    if ($method === 'POST' && csrf_check()) {
        $keys = ['site_title','site_description','slogan','phone_display','whatsapp_number','whatsapp_message',
            'whatsapp_float','notify_email','contact_email','address_street','address_zip','address_city',
            'address_region','facebook','instagram','analytics_id','ads_id','ads_conversion_form',
            'ads_conversion_whatsapp','base_url','footer_sitemap_desc','footer_contact_title',
            'footer_sitemap_title','review_badge_title','review_badge_sub','review_badge_nr','kvk_number',
            'smtp_host','smtp_port','smtp_user','smtp_pass'];
        if (trim((string)($_POST['smtp_pass'] ?? '')) === '') unset($_POST['smtp_pass']); // wachtwoord niet per ongeluk leegslaan
        foreach ($keys as $k) {
            if (array_key_exists($k, $_POST)) setting_save($k, trim((string)$_POST[$k]));
        }
        if (isset($_POST['send_testmail'])) {
            $to = trim((string)setting('notify_email'));
            if ($to === '') {
                flash_set('Vul eerst het notificatie-e-mailadres in.', 'err');
            } else {
                $res = rds_mail_send($to, 'Testmail ' . setting('site_title'),
                    "Dit is een testmail vanaf uw website.\n\nAls u dit leest, werkt het versturen van lead-mails.");
                if ($res[0]) flash_set('Testmail verzonden naar ' . $to . ' — check ook de spamfolder.');
                else flash_set('Verzenden mislukt: ' . $res[1] . ' (zie mail-log onderaan)', 'err');
            }
            redirect('/admin/instellingen');
        }
        flash_set('Instellingen opgeslagen.');
        redirect('/admin/instellingen');
    }
    admin_view('settings', ['settings' => db_settings_all()]);
    exit;
}

/* ------------------------------------------------------------------ */
/* Account (wachtwoord wijzigen)                                       */
/* ------------------------------------------------------------------ */

if ($route === '/account') {
    if ($method === 'POST' && csrf_check()) {
        $st = db()->prepare('SELECT * FROM users WHERE id = ?');
        $st->execute([$_SESSION['admin_uid']]);
        $user = $st->fetch();
        if (!password_verify($_POST['current'] ?? '', $user['password_hash'])) {
            flash_set('Huidige wachtwoord is onjuist.', 'err');
        } elseif (strlen($_POST['password'] ?? '') < 8) {
            flash_set('Nieuwe wachtwoord moet minimaal 8 tekens zijn.', 'err');
        } elseif (($_POST['password'] ?? '') !== ($_POST['password2'] ?? '')) {
            flash_set('De nieuwe wachtwoorden komen niet overeen.', 'err');
        } else {
            db()->prepare('UPDATE users SET password_hash = ?, must_change = 0 WHERE id = ?')
                ->execute([password_hash($_POST['password'], PASSWORD_DEFAULT), $user['id']]);
            flash_set('Wachtwoord gewijzigd.');
            redirect('/admin');
        }
        redirect('/admin/account');
    }
    admin_view('account');
    exit;
}

/* ------------------------------------------------------------------ */
/* Media                                                               */
/* ------------------------------------------------------------------ */

if ($route === '/media') {
    if ($method === 'POST' && csrf_check() && !empty($_FILES['file']['name']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif','webp','svg'], true) && filesize($_FILES['file']['tmp_name']) <= 10*1024*1024) {
            $dir = MEDIA_DIR . '/uploads';
            if (!is_dir($dir)) mkdir($dir, 0775, true);
            $name = date('Ymd-His') . '-' . slugify(pathinfo($_FILES['file']['name'], PATHINFO_FILENAME)) . '.' . $ext;
            move_uploaded_file($_FILES['file']['tmp_name'], $dir . '/' . $name);
            flash_set('Afbeelding geüpload: /media/uploads/' . $name);
        } else {
            flash_set('Upload mislukt: alleen jpg/png/gif/webp/svg tot 10 MB.', 'err');
        }
        redirect('/admin/media');
    }
    $files = [];
    foreach (['uploads', 'home', 'reinigen', 'portfolio'] as $sub) {
        $dir = MEDIA_DIR . '/' . $sub;
        if (!is_dir($dir)) continue;
        foreach (scandir($dir) as $f) {
            if ($f === '.' || $f === '..' || is_dir($dir . '/' . $f)) continue;
            $files[] = '/media/' . $sub . '/' . $f;
        }
    }
    admin_view('media', ['files' => $files]);
    exit;
}

/* ------------------------------------------------------------------ */
/* Portfolio (voor/na-foto's)                                          */
/* ------------------------------------------------------------------ */

if ($route === '/portfolio') {
    $pdo = db();
    if ($method === 'POST' && csrf_check()) {
        $action = $_POST['action'] ?? '';
        $id = (int)($_POST['id'] ?? 0);
        if ($action === 'delete') $pdo->prepare('DELETE FROM portfolio_items WHERE id = ?')->execute([$id]);
        if ($action === 'toggle') $pdo->prepare('UPDATE portfolio_items SET active = 1 - active WHERE id = ?')->execute([$id]);
        if ($action === 'up' || $action === 'down') {
            $st = $pdo->prepare('SELECT sort FROM portfolio_items WHERE id = ?');
            $st->execute([$id]);
            $cur = $st->fetchColumn();
            if ($cur !== false) {
                $dir = $action === 'up' ? -1 : 1;
                $st2 = $pdo->prepare('SELECT id, sort FROM portfolio_items ORDER BY sort ASC, id ASC');
                $st2->execute();
                $rows = $st2->fetchAll();
                $idx = null;
                foreach ($rows as $i => $r) if ((int)$r['id'] === $id) { $idx = $i; break; }
                $swap = $idx !== null ? ($rows[$idx + $dir] ?? null) : null;
                if ($swap) {
                    $pdo->prepare('UPDATE portfolio_items SET sort = ? WHERE id = ?')->execute([(int)$swap['sort'], $id]);
                    $pdo->prepare('UPDATE portfolio_items SET sort = ? WHERE id = ?')->execute([(int)$cur, (int)$swap['id']]);
                }
            }
        }
        redirect('/admin/portfolio');
    }
    $items = $pdo->query('SELECT * FROM portfolio_items ORDER BY sort ASC, id ASC')->fetchAll();
    admin_view('portfolio_list', ['items' => $items]);
    exit;
}

if ($route === '/portfolio/edit') {
    $pdo = db();
    $id = (int)($_GET['id'] ?? 0);
    $item = ['id' => 0, 'title' => '', 'before_img' => '', 'after_img' => '', 'active' => 1];
    if ($id > 0) {
        $st = $pdo->prepare('SELECT * FROM portfolio_items WHERE id = ?');
        $st->execute([$id]);
        $found = $st->fetch();
        if (!$found) { flash_set('Portfolio-item niet gevonden.', 'err'); redirect('/admin/portfolio'); }
        $item = $found;
    }
    if ($method === 'POST' && csrf_check()) {
        $data = [
            trim($_POST['title'] ?? ''),
            trim($_POST['before_img'] ?? ''),
            trim($_POST['after_img'] ?? ''),
            isset($_POST['active']) ? 1 : 0,
        ];
        if ($id > 0) {
            $pdo->prepare('UPDATE portfolio_items SET title = ?, before_img = ?, after_img = ?, active = ? WHERE id = ?')
                ->execute(array_merge($data, [$id]));
        } else {
            $sort = (int)$pdo->query('SELECT COALESCE(MAX(sort),0) FROM portfolio_items')->fetchColumn() + 1;
            $pdo->prepare('INSERT INTO portfolio_items (title, before_img, after_img, active, sort) VALUES (?,?,?,?,?)')
                ->execute(array_merge($data, [$sort]));
        }
        flash_set('Portfolio-item opgeslagen.');
        redirect('/admin/portfolio');
    }
    // Beschikbare foto's voor de kieslijst
    $media = [];
    foreach (['portfolio', 'uploads', 'reinigen', 'home'] as $sub) {
        $dir = MEDIA_DIR . '/' . $sub;
        if (!is_dir($dir)) continue;
        foreach (scandir($dir) as $f) {
            if (preg_match('/\.(jpe?g|png|webp)$/i', $f)) $media[$sub][] = '/media/' . $sub . '/' . $f;
        }
    }
    admin_view('portfolio_edit', ['item' => $item, 'media' => $media]);
    exit;
}

/* Fallback */
redirect('/admin');

/* ================================================================== */
/* View-helper                                                         */
/* ================================================================== */

function admin_view(string $name, array $vars = []): void
{
    view('admin/' . $name, $vars);
}

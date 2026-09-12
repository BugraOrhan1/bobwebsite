<?php
/**
 * Hulpfuncties voor de hele site.
 */

/** HTML-escapen */
function h(?string $s): string
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

/** Basisslug van een string */
function slugify(string $text): string
{
    $text = mb_strtolower(trim($text), 'UTF-8');
    $map = ['ä'=>'a','ö'=>'o','ü'=>'u','ë'=>'e','ï'=>'i','á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','à'=>'a','è'=>'e','â'=>'a','ê'=>'e','ô'=>'o','ç'=>'c','ñ'=>'n'];
    $text = strtr($text, $map);
    $text = preg_replace('/[^a-z0-9]+/u', '-', $text);
    return trim($text, '-');
}

/** Basis-URL van de site (dynamisch, of overschreven via instelling 'base_url') */
function base_url(): string
{
    static $base = null;
    if ($base !== null) return $base;
    $setting = setting('base_url');
    if (!empty($setting)) { $base = rtrim($setting, '/'); return $base; }
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
    $scheme = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $base = $scheme . '://' . $host;
    return $base;
}

/** Absolute URL voor een pad */
function url(string $path = ''): string
{
    if ($path === '' ) return base_url() . '/';
    return base_url() . '/' . ltrim($path, '/');
}

/** Relatief pad binnen de site (handig voor assets) */
function asset(string $path): string
{
    return '/assets/' . ltrim($path, '/');
}

/** Media-URL */
function media_url(string $path): string
{
    return '/media/' . ltrim($path, '/');
}

/** WhatsApp-link met vooringesteld bericht */
/** WhatsApp-link met paginacontext (dienst/stad) als vooringevuld bericht. */
function wa_context_link(): string
{
    return whatsapp_link($GLOBALS['WA_PREFILL'] ?? null);
}

function whatsapp_link(?string $message = null): string
{
    $nr = preg_replace('/[^0-9]/', '', setting('whatsapp_number', '31647249157'));
    $msg = $message !== null ? $message : setting('whatsapp_message', '');
    $url = 'https://api.whatsapp.com/send?phone=' . $nr;
    if ($msg !== '') $url .= '&text=' . rawurlencode($msg);
    return $url;
}

/** Telefoon-nummer (display) */
function phone_display(): string
{
    return setting('phone_display', '06-47249157');
}

/** tel:-link */
function phone_href(): string
{
    return 'tel:' . str_replace([' ', '-'], '', setting('phone_display', '06-47249157'));
}

/** Instelling ophalen met default */
function setting(string $key, ?string $default = null): ?string
{
    static $cache = null;
    if ($cache === null) $cache = db_settings_all();
    return isset($cache[$key]) && $cache[$key] !== '' ? $cache[$key] : $default;
}

/** Markdown/Kirbytext-achtige tekst naar HTML (voor gezaaide content) */
function ktext(?string $text): string
{
    if ($text === null || trim($text) === '') return '';
    $lines = preg_split('/\r\n|\r|\n/', (string)$text);
    $html = '';
    $list = null; // 'ul' | 'ol'
    $para = [];

    $flushPara = function () use (&$para, &$html) {
        if ($para) {
            $html .= '<p>' . ktext_inline(implode('<br>', $para)) . '</p>';
            $para = [];
        }
    };
    $flushList = function () use (&$list, &$html) {
        if ($list) { $html .= "</$list>"; $list = null; }
    };

    foreach ($lines as $line) {
        $t = trim($line);
        if ($t === '') { $flushPara(); $flushList(); continue; }

        // Kirbytag: (link: url text: label) of (link: url)
        if (preg_match('/^\(link:\s*(\S+)\s+text:\s*(.+)\)$/', $t, $m)) {
            $flushPara(); $flushList();
            $html .= '<a href="' . h($m[1]) . '" rel="noopener">' . h(trim($m[2])) . '</a>';
            continue;
        }
        // Heading ## / ###
        if (preg_match('/^(#{1,4})\s*(.*)$/', $t, $m)) {
            $flushPara(); $flushList();
            $lvl = min(strlen($m[1]) + 1, 6); // ## -> h2? Kirby: ## is h2
            $lvl = max(2, strlen($m[1]));
            $html .= '<h' . $lvl . '>' . ktext_inline(trim($m[2])) . '</h' . $lvl . '>';
            continue;
        }
        // Lijst-item
        if (preg_match('/^[-*]\s+(.*)$/', $t, $m)) {
            $flushPara();
            if ($list !== 'ul') { $flushList(); $html .= '<ul>'; $list = 'ul'; }
            $html .= '<li>' . ktext_inline(trim($m[1])) . '</li>';
            continue;
        }
        $flushList();
        $para[] = $t;
    }
    $flushPara(); $flushList();
    return $html;
}

/** Inline opmaak: vet, cursief, kirby-links, mail */
function ktext_inline(string $s): string
{
    $s = h($s);
    // (link: url text: label) — ook al gedeeltelijk ge-escaped
    $s = preg_replace_callback('/\(link:\s*([^\s)]+)\s+text:\s*([^)]+)\)/', function ($m) {
        return '<a href="' . $m[1] . '" rel="noopener">' . trim($m[2]) . '</a>';
    }, $s);
    $s = preg_replace_callback('/\(link:\s*([^\s)]+)\)/', function ($m) {
        return '<a href="' . $m[1] . '" rel="noopener">' . $m[1] . '</a>';
    }, $s);
    $s = preg_replace_callback('/\(email:\s*([^\s)]+)\s+text:\s*([^)]+)\)/', function ($m) {
        return '<a href="mailto:' . $m[1] . '">' . trim($m[2]) . '</a>';
    }, $s);
    // vet / cursief
    $s = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $s);
    $s = preg_replace('/(?<!\*)\*([^*]+?)\*(?!\*)/', '<em>$1</em>', $s);
    return $s;
}

/** Sanitize door gebruiker ingevoerde HTML (admin) */
function clean_html(?string $html): string
{
    if ($html === null) return '';
    // verwijder script/style/iframe ed.
    $html = preg_replace('#<(script|style|iframe|object|embed|form|link|meta)[^>]*>.*?</\1>#is', '', (string)$html);
    $html = preg_replace('#<(script|style|iframe|object|embed|form|link|meta)[^>]*/?>#i', '', $html);
    $html = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
    $html = preg_replace('/\sjavascript:[^"\'>\s]*/i', '', $html);
    return trim($html);
}

/** CSRF */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . h(csrf_token()) . '">';
}
function csrf_check(): bool
{
    return isset($_POST['_csrf']) && hash_equals(csrf_token(), (string)$_POST['_csrf']);
}

/** Huidig pad (zonder query) */
function request_path(): string
{
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH) ?: '/';
    $path = urldecode($path);
    $path = trim($path, '/');
    return $path;
}

/** Redirect helper */
function redirect(string $to): void
{
    header('Location: ' . $to, true, 302);
    exit;
}

/** Beperkte tekst */
function str_limit(?string $s, int $len = 160): string
{
    $s = trim(strip_tags((string)$s));
    if (mb_strlen($s) <= $len) return $s;
    return rtrim(mb_substr($s, 0, $len)) . '…';
}

/** Notificatie-flash in sessie */
function flash_set(string $msg, string $type = 'ok'): void
{
    $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
}
function flash_get(): ?array
{
    if (!empty($_SESSION['flash'])) { $f = $_SESSION['flash']; unset($_SESSION['flash']); return $f; }
    return null;
}

/** IP van bezoeker */
function client_ip(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

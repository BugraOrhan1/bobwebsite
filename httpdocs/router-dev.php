<?php
/**
 * Router voor de PHP-ingebouwde webserver (alleen lokale ontwikkeling/preview).
 * Op productie regelt .htaccess dit.
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Bestaande bestanden direct serveren
$file = __DIR__ . $uri;
if ($uri !== '/' && file_exists($file) && !is_dir($file)
    && !substr($uri, 0, 5) !== '/app/' && substr($uri, 0, 6) !== '/data/') {
    return false;
}

// Blokkeer app/data
if (substr($uri, 0, 5) === '/app/' || substr($uri, 0, 6) === '/data/') {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}

// Admin
if ($uri === '/admin' || substr($uri, 0, 7) === '/admin/') {
    require __DIR__ . '/admin/index.php';
    return true;
}

require __DIR__ . '/index.php';
return true;

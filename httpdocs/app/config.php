<?php
/**
 * De Reinigingsdokter — centrale configuratie
 * Kirby-vrij, draait op elke standaard PHP-hosting (PHP 7.4+, PDO SQLite).
 */

define('APP_DIR', __DIR__);
define('WEB_ROOT', dirname(__DIR__));
define('DATA_DIR', WEB_ROOT . '/data');
define('MEDIA_DIR', WEB_ROOT . '/media');
define('UPLOAD_DIR', DATA_DIR . '/uploads');

// Foutafhandeling: op productie alleen loggen, niet tonen.
define('APP_DEBUG', getenv('APP_DEBUG') === '1');
error_reporting(E_ALL);
ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', DATA_DIR . '/php-error.log');

date_default_timezone_set('Europe/Amsterdam');
mb_internal_encoding('UTF-8');

// Versie voor cache-busting van css/js
define('APP_VERSION', '3.1.0');

// Start sessie (voor admin-login en CSRF)
if (session_status() === PHP_SESSION_NONE) {
    session_name('rdsess');
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    ]);
    session_start();
}

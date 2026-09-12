<?php
/**
 * Database-laag: SQLite via PDO. Geen installatie nodig — het bestand
 * wordt automatisch aangemaakt bij de eerste request.
 */

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        if (!is_dir(DATA_DIR)) mkdir(DATA_DIR, 0775, true);
        $file = DATA_DIR . '/site.sqlite';
        $isNew = !file_exists($file);
        $pdo = new PDO('sqlite:' . $file);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->exec('PRAGMA journal_mode=WAL');
        $pdo->exec('PRAGMA foreign_keys=ON');
        db_migrate($pdo);
    }
    return $pdo;
}

function db_migrate(PDO $pdo): void
{
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS settings (
        key TEXT PRIMARY KEY,
        value TEXT
    );
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password_hash TEXT NOT NULL,
        must_change INTEGER DEFAULT 1,
        created_at TEXT DEFAULT (datetime('now'))
    );
    CREATE TABLE IF NOT EXISTS pages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        slug TEXT UNIQUE NOT NULL,
        template TEXT NOT NULL DEFAULT 'page',
        title TEXT NOT NULL,
        in_menu INTEGER DEFAULT 0,
        sort INTEGER DEFAULT 0,
        active INTEGER DEFAULT 1,
        updated_at TEXT
    );
    CREATE TABLE IF NOT EXISTS fields (
        page_id INTEGER NOT NULL,
        fkey TEXT NOT NULL,
        value TEXT,
        PRIMARY KEY (page_id, fkey)
    );
    CREATE TABLE IF NOT EXISTS services (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        slug TEXT UNIQUE NOT NULL,
        title TEXT NOT NULL,
        label TEXT,
        icon TEXT,
        sort INTEGER DEFAULT 0,
        active INTEGER DEFAULT 1
    );
    CREATE TABLE IF NOT EXISTS cities (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        slug TEXT UNIQUE NOT NULL,
        name TEXT NOT NULL,
        province TEXT,
        enabled INTEGER DEFAULT 1,
        intro TEXT
    );
    CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        name TEXT,
        content TEXT,
        service TEXT,
        country TEXT DEFAULT 'nl',
        active INTEGER DEFAULT 1,
        sort INTEGER DEFAULT 0
    );
    CREATE TABLE IF NOT EXISTS price_groups (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        sort INTEGER DEFAULT 0
    );
    CREATE TABLE IF NOT EXISTS price_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        group_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        price TEXT,
        sort INTEGER DEFAULT 0
    );
    CREATE TABLE IF NOT EXISTS leads (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        created_at TEXT DEFAULT (datetime('now')),
        name TEXT, phone TEXT, email TEXT, city TEXT,
        message TEXT, source TEXT, gclid TEXT, page TEXT,
        ip TEXT, attachment TEXT, is_read INTEGER DEFAULT 0
    );
    CREATE TABLE IF NOT EXISTS login_attempts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ip TEXT, created_at INTEGER
    );
    CREATE TABLE IF NOT EXISTS portfolio_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        before_img TEXT,
        after_img TEXT,
        active INTEGER DEFAULT 1,
        sort INTEGER DEFAULT 0
    );
    CREATE TABLE IF NOT EXISTS faqs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        question TEXT NOT NULL,
        answer TEXT,
        active INTEGER DEFAULT 1,
        sort INTEGER DEFAULT 0
    );
    ");
}

/* ---------- settings ---------- */

function db_settings_all(): array
{
    static $cache = null;
    if ($cache !== null) return $cache;
    $rows = db()->query('SELECT key, value FROM settings')->fetchAll();
    $cache = [];
    foreach ($rows as $r) $cache[$r['key']] = $r['value'];
    return $cache;
}

function setting_save(string $key, ?string $value): void
{
    $st = db()->prepare('INSERT INTO settings (key, value) VALUES (?, ?)
        ON CONFLICT(key) DO UPDATE SET value = excluded.value');
    $st->execute([$key, (string)$value]);
}

/* ---------- pages & fields ---------- */

function page_by_slug(string $slug): ?array
{
    $st = db()->prepare('SELECT * FROM pages WHERE slug = ? AND active = 1');
    $st->execute([$slug]);
    $p = $st->fetch();
    if (!$p) return null;
    return page_with_fields($p);
}

function page_with_fields(array $p): array
{
    $st = db()->prepare('SELECT fkey, value FROM fields WHERE page_id = ?');
    $st->execute([$p['id']]);
    foreach ($st->fetchAll() as $f) $p[$f['fkey']] = $f['value'];
    return $p;
}

function page_field(int $pageId, string $key, ?string $default = null): ?string
{
    $st = db()->prepare('SELECT value FROM fields WHERE page_id = ? AND fkey = ?');
    $st->execute([$pageId, $key]);
    $v = $st->fetchColumn();
    return ($v === false || $v === null || $v === '') ? $default : $v;
}

function page_save_field(int $pageId, string $key, ?string $value): void
{
    $st = db()->prepare('INSERT INTO fields (page_id, fkey, value) VALUES (?, ?, ?)
        ON CONFLICT(page_id, fkey) DO UPDATE SET value = excluded.value');
    $st->execute([$pageId, $key, (string)$value]);
}

/* ---------- leads ---------- */

function lead_add(array $d): int
{
    $st = db()->prepare('INSERT INTO leads (name, phone, email, city, message, source, gclid, page, ip, attachment)
        VALUES (?,?,?,?,?,?,?,?,?,?)');
    $st->execute([
        $d['name'] ?? '', $d['phone'] ?? '', $d['email'] ?? '', $d['city'] ?? '',
        $d['message'] ?? '', $d['source'] ?? '', $d['gclid'] ?? '', $d['page'] ?? '',
        $d['ip'] ?? '', $d['attachment'] ?? '',
    ]);
    return (int)db()->lastInsertId();
}

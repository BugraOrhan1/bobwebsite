<?php
/**
 * Content-toegangslaag: diensten, steden, reviews, prijzen, menu.
 */

function all_services(bool $onlyActive = true): array
{
    $sql = 'SELECT * FROM services' . ($onlyActive ? ' WHERE active = 1' : '') . ' ORDER BY sort ASC, id ASC';
    return db()->query($sql)->fetchAll();
}

function service_by_slug(string $slug): ?array
{
    $st = db()->prepare('SELECT * FROM services WHERE slug = ?');
    $st->execute([$slug]);
    $s = $st->fetch();
    return $s ?: null;
}

/** De content-pagina die bij een dienst hoort (slug: reinigen/{slug}) */
function service_page(array $service): ?array
{
    return page_by_slug('reinigen/' . $service['slug']);
}

function all_cities(bool $onlyEnabled = true): array
{
    $sql = 'SELECT * FROM cities' . ($onlyEnabled ? ' WHERE enabled = 1' : '') . ' ORDER BY name ASC';
    return db()->query($sql)->fetchAll();
}

function city_by_slug(string $slug): ?array
{
    $st = db()->prepare('SELECT * FROM cities WHERE slug = ?');
    $st->execute([$slug]);
    $c = $st->fetch();
    return $c ?: null;
}

function cities_by_province(string $province, int $excludeId = 0, int $limit = 8): array
{
    $st = db()->prepare('SELECT * FROM cities WHERE province = ? AND enabled = 1 AND id != ? ORDER BY RANDOM() LIMIT ' . (int)$limit);
    $st->execute([$province, $excludeId]);
    return $st->fetchAll();
}

function all_reviews(bool $onlyActive = true): array
{
    $sql = 'SELECT * FROM reviews' . ($onlyActive ? ' WHERE active = 1' : '') . ' ORDER BY sort ASC, id ASC';
    return db()->query($sql)->fetchAll();
}

function reviews_for_service(string $label, int $limit = 6): array
{
    $st = db()->prepare('SELECT * FROM reviews WHERE active = 1 AND service = ? ORDER BY sort ASC, id ASC LIMIT ' . (int)$limit);
    $st->execute([$label]);
    return $st->fetchAll();
}

function price_groups_with_items(): array
{
    $groups = db()->query('SELECT * FROM price_groups ORDER BY sort ASC, id ASC')->fetchAll();
    $items = db()->query('SELECT * FROM price_items ORDER BY sort ASC, id ASC')->fetchAll();
    $byGroup = [];
    foreach ($items as $it) $byGroup[$it['group_id']][] = $it;
    foreach ($groups as &$g) $g['items'] = $byGroup[$g['id']] ?? [];
    return $groups;
}

function menu_pages(): array
{
    $rows = db()->query("SELECT * FROM pages WHERE in_menu = 1 AND active = 1 ORDER BY sort ASC")->fetchAll();
    $out = [];
    foreach ($rows as $r) if ($r['slug'] !== '') $out[] = $r;
    return $out;
}

/** Aantal stadspagina's (voor dashboard/sitemap) */
function city_page_count(): int
{
    $c = (int)db()->query('SELECT COUNT(*) FROM cities WHERE enabled = 1')->fetchColumn();
    $s = (int)db()->query('SELECT COUNT(*) FROM services WHERE active = 1')->fetchColumn();
    return $c * $s;
}

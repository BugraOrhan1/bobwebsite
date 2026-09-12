<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Admin — <?= h(setting('site_title')) ?></title>
<link rel="stylesheet" href="/assets/css/admin.css?v=<?= APP_VERSION ?>">
</head>
<body class="admin">
<div class="admin-shell">
    <aside class="admin-side">
        <div class="admin-side__brand">
            <img src="/assets/logo/Gemini_Generated_Image_e5gvwve5gvwve5gv-removebg-preview.png" alt="Logo">
            <span>Beheer</span>
        </div>
        <nav class="admin-nav">
            <?php
            $items = [
                '/admin' => ['🏠', 'Dashboard'],
                '/admin/leads' => ['📥', 'Leads'],
                '/admin/paginas' => ['📄', "Pagina's"],
                '/admin/diensten' => ['🧽', 'Diensten'],
                '/admin/steden' => ['📍', "Stadspagina's"],
                '/admin/prijzen' => ['💶', 'Prijzen'],
                '/admin/reviews' => ['⭐', 'Reviews'],
                '/admin/media' => ['🖼️', 'Media'],
                '/admin/instellingen' => ['⚙️', 'Instellingen'],
                '/admin/account' => ['🔑', 'Mijn account'],
            ];
            $current = rtrim('/' . request_path(), '/') ?: '/admin';
            ?>
            <?php foreach ($items as $href => $it): ?>
                <?php $active = ($href === '/admin') ? ($current === '/admin') : (strpos($current, $href) === 0); ?>
                <a class="admin-nav__item<?= $active ? ' is-active' : '' ?>" href="<?= $href ?>">
                    <span class="admin-nav__icon"><?= $it[0] ?></span> <?= h($it[1]) ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="admin-side__bottom">
            <a href="/" target="_blank" rel="noopener">🌐 Bekijk site</a>
            <a href="/admin/logout">🚪 Uitloggen</a>
        </div>
    </aside>
    <main class="admin-main">
        <?php if ($f = flash_get()): ?>
            <div class="admin-flash admin-flash--<?= h($f['type']) ?>"><?= h($f['msg']) ?></div>
        <?php endif; ?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Inloggen — <?= h(setting('site_title')) ?></title>
<link rel="stylesheet" href="/assets/css/admin.css?v=<?= APP_VERSION ?>">
</head>
<body class="admin admin--login">
<div class="login-card">
    <img class="login-card__logo" src="/assets/logo/Gemini_Generated_Image_e5gvwve5gvwve5gv-removebg-preview.png" alt="Logo">
    <h1>Inloggen</h1>
    <p class="login-card__sub">Beheerpaneel — alleen voor beheerders</p>
    <?php if ($f = flash_get()): ?>
        <div class="admin-flash admin-flash--<?= h($f['type']) ?>"><?= h($f['msg']) ?></div>
    <?php endif; ?>
    <form method="post" action="/admin/login" autocomplete="on">
        <?= csrf_field() ?>
        <label for="username">Gebruikersnaam</label>
        <input id="username" type="text" name="username" required autofocus autocomplete="username">
        <label for="password">Wachtwoord</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">
        <button class="btn btn--primary" type="submit">Inloggen</button>
    </form>
</div>
</body>
</html>

<?php /** @var array $ctx */ ?>
<head><meta charset="utf-8"><title><?= h($ctx['meta_title']) ?></title>
<meta name="description" content="<?= h($ctx['meta_description']) ?>"/>
<?php $gtag = setting('analytics_id'); $adsId = setting('ads_id'); $consent = $_COOKIE['rd_consent'] ?? null; ?>
<?php if ($gtag && $consent === 'yes'): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= h($gtag) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= h($gtag) ?>');</script>
<?php endif; ?>
<?php if ($adsId && $consent === 'yes'): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= h($adsId) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= h($adsId) ?>');</script>
<?php endif; ?>
<meta http-equiv="language" content="nl">
<meta name="robots" content="index, follow">
<meta name="author" content="<?= h(setting('site_title')) ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta property="og:title" content="<?= h($ctx['meta_title']) ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= h(setting('site_title')) ?>">
<meta property="og:url" content="<?= h($ctx['canonical']) ?>">
<meta property="og:description" content="<?= h($ctx['meta_description']) ?>">
<meta property="og:image" content="<?= h(base_url() . '/assets/logo/Gemini_Generated_Image_e5gvwve5gvwve5gv-removebg-preview.png') ?>">
<meta name="theme-color" content="#002970">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/_prod/style-prod.min.css?v=<?= APP_VERSION ?>">
<link rel="stylesheet" href="/assets/css/app.css?v=<?= APP_VERSION ?>">
<link rel="canonical" href="<?= h($ctx['canonical']) ?>" />
<link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="/assets/img/favicon/site.webmanifest">
<link rel="mask-icon" href="/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
</head>

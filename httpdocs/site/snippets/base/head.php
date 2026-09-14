<?php
$env = c::get('env');
$googleAnalytics = c::get('google-analytics');
$version = site()->version();
$title = '';
$description = '';

if (isset($isMeta) && $isMeta  == 'override') {
    $title = $page->parent()->title() . ' in ' . $page->title()->text() . ' en omgeving';
} else {
    $title =  $page->meta_title()->isNotEmpty()? $page->meta_title() :$site->title();
    $title =  $title;
}

$meta_description = $page->meta_description()->isNotEmpty() ? $page->meta_description() : $site->description();
$description = isset($isMeta) && $isMeta  == 'override'
        ? $page->parent()->title() . ' in ' . $page->title()->text() . ' en omgeving. | ' . $meta_description
        : $meta_description;

?><!DOCTYPE html>
<html lang="<?= site()->language() ? site()->language()->code() : 'en' ?>"><head><meta charset="utf-8"><title><?= $title ?></title>
<meta name="description" content="<?= $description ?>"/>
<?php if ($googleAnalytics): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $googleAnalytics ?>"></script>
<script> window.dataLayer = window.dataLayer || [];function gtag() {dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '<?= $googleAnalytics ?>');</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-7QV8FFJCF4"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-7QV8FFJCF4');
</script>

<?php endif ?>
<meta http-equiv="language" content="nl">
<meta http-equiv="content-language" content="nl">
<meta name="robots" content="index, follow, noodp">
<meta name="author" content="<?= $site->author()->html() ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta property="og:title" content="<?= $title ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= $site->title() ?>">
<meta property="og:url" content="<?= e ( $page->isHomePage() , $page->url(). '/' , $page->url()  )  ?>">
<?php if ( $page->isHomePage() ): ?>
<?php $photo = $site->photo()->toFile() ?>
<meta property="og:image" content="<?= $photo->url() ?>">
<meta property="og:image:width" content="<?= $photo->width() ?>">
<meta property="og:image:height" content="<?= $photo->height() ?>">
<meta property="og:image:type" content="image/jpeg">
<?php endif ?>
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<meta name="env" content="<?= $env ?>">

<?php if($env === "prod"): ?>
    <?= css('/assets/_prod/style-prod.min.css?v=' . $version) ?>
<?php elseif(str::contains($env, 'test')): ?>
    <?= css('/assets/_dev/style-test-dev.min.css?v=' . $version) ?>
<?php elseif(str::contains($env, 'local') ): ?>
    <?= css('/assets/_con/style.css?v=' . $version) ?>
<?php else: ?>
    <?= css('/assets/_con/style-test.css?v=' . $version) ?>
<?php endif ?>
<?php if ( $page->isHomePage() ): ?>
<link rel="canonical" href="<?= $page->url(). '/' ?>" />
<?php else: ?>
<link rel="canonical" href="<?= $page->url() ?>" />
<?php endif ?>
<link rel="apple-touch-icon" sizes="180x180" href="<?= $kirby->urls()->assets() ?>/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= $kirby->urls()->assets() ?>/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= $kirby->urls()->assets() ?>/img/favicon/favicon-16x16.png">
<link rel="manifest" href="<?= $kirby->urls()->assets() ?>/img/favicon/site.webmanifest">
<link rel="mask-icon" href="<?= $kirby->urls()->assets() ?>/img/favicon/safari-pinned-tab.svg" color="#5bbad5">

</head>
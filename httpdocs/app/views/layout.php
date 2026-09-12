<?php /** @var array $ctx */ ?>
<!DOCTYPE html>
<html lang="nl">
<?php view('head', ['ctx' => $ctx]); ?>
<body class="<?= h($ctx['bodyClass']) ?>">
<div class="all">
<?php view('header'); ?>

<main class="main">
<?php view('pages/' . $ctx['pageView'], $ctx['vars']); ?>
</main>

<?php view('cta_footer'); ?>
</div>
<?php view('whatsapp_float'); ?>
<?php view('mobile_bar'); ?>
<?php view('cookie_banner'); ?>
<?php view('scripts', ['ctx' => $ctx]); ?>
</body>
</html>

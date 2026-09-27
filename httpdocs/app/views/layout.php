<?php /** @var array $ctx */ ?>
<!DOCTYPE html>
<html lang="nl">
<?php view('head', ['ctx' => $ctx]); ?>
<body class="<?= h($ctx['bodyClass']) ?>">
<?php $promo = trim((string)setting('promo_text')); if ($promo !== ''): ?>
<div class="promo-bar">📣 <?= h($promo) ?> · <a href="/contact">vraag direct een prijs</a></div>
<?php endif; ?>
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

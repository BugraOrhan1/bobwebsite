<?php snippet('base/head') ?>

<body class="body__home">
<div class="all">
  <?php snippet('base/header') ?>

  <main class="main">
    <?php snippet('components/hero-02') ?>
    <?php snippet('components/lane-service') ?>
    <?php snippet('components/lane-plus') ?>

    <?php snippet('components/lane-prices-home') ?>

    <?php snippet('components/lane-reviews') ?>

  </main>

  <?php snippet('base/footer') ?>
  <?php snippet('base/script') ?>

  <?php if (c::get('env') != "prod"): ?>

  <?php else: ?>

  <?php endif ?>

	
</div>
</body>
</html>
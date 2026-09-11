<?php snippet('base/head') ?>

<body class="body__default">
<div class="all">
  <?php snippet('base/header') ?>

  <main class="main">
    <section class="lane">
      <div class="container-fluid">
        <div class="lane__content">
          <h2 class="lane__title"><?= $page->title()->html() ?></h2>
          <h1 class="lane__subtitle"><?= $page->subTitle()->html() ?></h1>
        </div>
      </div>
    </section>
    <section class="lane">
      <div class="container-fluid">
        <div class="lane__content">
          <p class="lane__para">
            We verontschuldigen ons, maar de door je gevraagde pagina kan niet gevonden worden. Het is waarschijnlijk verlopen, verplaatst, of hernoemd. Als je
            de pagina-URL handmatig in je browser hebt ingevoerd, controleer dan je spelling en probeer het opnieuw of ga door en bezoek onze homepage.
          </p>
          <p class="box-cta__reservation"><a class="_btn button-02" href="<?= url('home') ?>">Terug naar de home pagina</a></p>
        </div>
      </div>
    </section>

  </main>

  <?php snippet('base/footer') ?>
  <?php snippet('base/script') ?>

</div>
</body>
</html>

<?php snippet('base/head') ?>

<body class="body__error">
<div class="all">
  <?php snippet('base/header') ?>

  <main class="main">
    <section class="article-02">
      <div class="container-fluid">
        <div class="article-02__col-1 ">
        <div class="article-02__content">
            <br/>
            <br/>
            <br/>
            <div class="cont-html">
              <h1 class="lane__subtitle"><?= $page->sub_title()->html() ?></h1>
              <h2 class=""><?= $page->title()->html() ?></h2>

                <p class="lane__para">
                    <?= $page->sub_para()->html() ?>
                </p>
                <p class="box-cta__reservation"><a class="_btn button-02" href="<?= url('home') ?>"><?= $page->button_text()->text() ?></a></p>
            </div>
        </div>
        </div>
      </div>
    </section>

  </main>

  <?php snippet('base/footer') ?>
  <?php snippet('base/script') ?>


</div>
</body>
</html>

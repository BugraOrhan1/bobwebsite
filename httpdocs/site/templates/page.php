<?php

?>
<?php snippet('base/head') ?>
<body class="body__home">
<div class="all">
    <?php snippet('base/header') ?>

    <main class="main">
        <section class="lane lane__error">
            <div class="container-fluid">
                <div class="lane__content">
                    <h1 class="lane__subtitle"><?= $page->sub_title()->html() ?></h1>
                    <h2 class="lane__title"><?= $page->title()->html() ?></h2>
                </div>
            </div>
            <div class="container-fluid">
                <div class="lane__content">


                  test


                </div>
            </div>
    </main>

    <?php snippet('base/footer') ?>
    <?php snippet('base/script') ?>

    <?php if (c::get('env') != "prod"): ?>

    <?php else: ?>

    <?php endif ?>


</div>
</body>
</html>
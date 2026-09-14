<?php /** Tarievenpagina. $page, $crumbs */ ?>
<section class="article-02">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">

                <?php view('breadcrumb', ['crumbs' => $crumbs]); ?>
                <div class="article-02__content">
                    <div class="cont-html">
                        <h1 class="lane__title"><?= h($page['intro_title']) ?></h1>
                        <?= ktext($page['intro_description']) ?>
                    </div>
                    <?php view('prices_block', ['groups' => price_groups_with_items()]); ?>

                    <div class="cont-html">
                        <p><strong>Prijs op maat?</strong> Stuur ons een foto via WhatsApp of het contactformulier en ontvang binnen 2 uur een scherpe all-in prijs.</p>
                    </div>
                    <?php view('group_communication'); ?>
                </div>

            </div>


            <div class="article-02__col-2">
                <div class="article-02__box">
                    <?php view('sidebar', ['showWhy' => true]); ?>
                </div>
            </div>
        </div>
    </div>
</section>

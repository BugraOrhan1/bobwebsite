<?php /** Reviewspagina. $page, $crumbs */ ?>
<section class="article-02 article-02--review">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php view('breadcrumb', ['crumbs' => $crumbs]); ?>

                <div class="article-02__content">
                    <div class="cont-html">
                        <h1 class="lane__title"><?= h($page['intro_title']) ?></h1>
                        <?= ktext($page['intro_description'] ?? '') ?>
                    </div>

                    <?php
                    $reviews = all_reviews();
                    usort($reviews, fn($a, $b) => strcmp($a['service'], $b['service']));
                    ?>
                    <?php if ($reviews): ?>
                    <div class="review review--full-show-3">
                        <?php view('reviews_block', ['reviews' => $reviews, 'showHeading' => true]); ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</section>

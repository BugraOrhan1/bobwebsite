<?php /** Juridische pagina (privacy/cookies). $page, $crumbs */ ?>
<section class="article-02">
    <div class="container-fluid">
        <div class="article-02__main">
            <div class="article-02__col-1">
                <?php view('breadcrumb', ['crumbs' => $crumbs]); ?>
                <div class="article-02__content">
                    <div class="cont-html legal-page">
                        <h1 class="lane__title"><?= h($page['intro_title']) ?></h1>
                        <?= clean_html($page['content_html'] ?? '') ?>
                    </div>
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

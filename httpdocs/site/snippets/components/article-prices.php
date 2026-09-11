<section class="article-02">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">

                <?php snippet('shared/breadcrumb'); ?>
                <div class="article-02__content">
                    <div class="cont-html">
                        <h1 class="lane__title"><?= $page->intro_title()->text()?></h1>
                        <?= $page->intro_description()->kirbytext() ?>
                    </div>
                    <?php snippet('/components/item/prices',array('prices' => 'all'));?>
                </div>

            </div>


            <div class="article-02__col-2">
                <div class="article-02__box">
                    <?php snippet('shared/share-sidebar'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
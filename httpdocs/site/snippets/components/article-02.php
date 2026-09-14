<section class="article-02">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php
                    snippet('shared/breadcrumb');
                ?>
                <div class="article-02__content">
                    <div class="cont-html">

                        <h1 class="lane__title"><?= $page->intro_title()->text()?></h1>
                        <?= $page->intro_description()->kirbytext() ?>

                        <?php  if($page->enable_contact() == '1'):
                           snippet('shared/group-communication');
                         endif ?>

                        <?= $page->content_description()->kirbytext() ?>
                    </div>

                    <?php snippet('/components/item/example');?>

                    <div class="cont-html">
                        <?= $page->content_intro_price()->kirbytext() ?>
                        <?= $page->content_price()->kirbytext() ?>
                    </div>
                    <?php snippet('/components/item/prices'); ?>


                    <?php $reviewPage = $site->find('reviews'); ?>
                    <?php $reviews = $reviewPage->review_list()->toStructure()->filterBy('s_sevice', $page->label()->text() )->sortBy('s_sevice', 'asc'); ?>
                    <?php if (!empty($reviews) && count($reviews) > 0): ?>
                    <div class="review review--full">
                        <div class="cont-html"><h2><?= $reviewPage->intro_title()->text(); ?></h2></div>
                        <?php snippet('/components/item/reviews', array('reviews' => $reviews->limit(6), 'showHeading' => '0', 'amountColumn' => '2' ) ); ?>
                    </div>
                    <?php endif ?>

                    <?php if($page->enable_contact() == '1'): ?>
                    <?php snippet('shared/group-communication'); ?>
                    <?php endif ?>

                </div>

            </div>


            <div class="article-02__col-2">

                <div class="article-02__box">
                    <?php snippet('shared/share-sidebar'); ?>
                </div>

            </div>
        </div>


        <?php snippet('shared/share-locations', array('pageReiniging' => $page) ); ?>

    </div>
</section>
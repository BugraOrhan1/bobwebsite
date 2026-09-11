<section class="article-02 article-02--review">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php
                    snippet('shared/breadcrumb');
                ?>

                <div class="article-02__content">
                    <?php
                    $reviews = $page->review_list()->toStructure()->sortBy('s_sevice', 'asc');


                    //$len = count($reviews);
                    //$reviewsFirst = $reviews->limit($len / 2);
                    //$reviewsSecond = $reviews->offset($len / 2)->limit($len);
                    ?>
                    <div class="cont-html">
                        <h1 class="lane__title"><?= $page->intro_title()->text()?></h1>
                        <?= $page->intro_description()->kirbytext() ?>
                    </div>

                    <?php if (!empty($reviews)): ?>
                    <div class="review review--full-show-3">
                        <?php snippet('/components/item/reviews',array('reviews' => $reviews,'showHeading' => '1'));?>
                    </div>
                    <?php endif ?>


                </div>
            </div>

        </div>
    </div>
</section>
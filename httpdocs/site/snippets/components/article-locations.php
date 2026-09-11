<?php
// get keywoords

$types = $page->content_type();
$parent = $page->parent();
$keyword = $page->parent()->title();

?>

<section class="article-02">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php
                    snippet('shared/breadcrumb');
                ?>
                <div class="article-02__content">
                    <div class="cont-html">

                        <h1 class="lane__title">
                            <?= $page->parent()->title() ?> in <?= $page->title()->text()?> en omgeving
                        </h1>
                         <!-- algemene tekst met keywoord changes -->
                        <?= $parent->intro_description()->kirbytext() ?>

                        <?php  if($parent->enable_contact() == '1'):
                           snippet('shared/group-communication');
                         endif ?>
                        <?= $parent->content_description()->kirbytext() ?>
                    </div>

                    <?php snippet('/components/item/example',array('showParent' => 'yes'));?>

                    <div class="cont-html">
                        <?= $parent->content_intro_price()->kirbytext() ?>
                        <?= $parent->content_price()->kirbytext() ?>
                    </div>

                    <?php snippet('/components/item/prices', array('showParent' => 'yes') );?>

                    <?php  if($parent->enable_contact() == '1'):
                        snippet('shared/group-communication');
                    endif ?>

                </div>



            </div>


            <div class="article-02__col-2">
                <div class="article-02__box">
                    <?php snippet('shared/share-sidebar'); ?>
                </div>
            </div>
        </div>

        <?php snippet('shared/share-locations', array('pageReiniging' => $page->parent()) ); ?>

    </div>
</section>
<?php

// send reviews outside
if (empty($reviews)) {
    $reviews = $page->review_list()->toStructure();
}
if (!empty($showHeading) && $showHeading == 1) {
    //$showHeading = true;
} else {
   $showHeading = 0;
}
if (empty($amountColumn)) {
    $amountColumn = 3;
}

$s_sevice = '';
$s_start_ul = true;
$s_end_ul = false;

?>
<?php if (!empty($reviews)): ?>

    <?php foreach ($reviews as $_review): ?>

        <?php if($showHeading && $s_sevice != $_review->s_sevice()->text() ):  ?>
            <?php $s_sevice = $_review->s_sevice()->text();  ?>
            <?php $s_start_ul = true;  ?>
            </ul>
            <div class="review__item-title ">
                <h2 class="title"><?= $s_sevice ?></h2>
            </div>
        <?php endif ?>


        <?php if($s_start_ul ):  ?>
            <?php $s_start_ul = false;  ?>
            <ul class="review__items">
        <?php endif ?>

            <li class="review__item">
                <blockquote class="review__block">
                    <div class="review__service"><p class="review__categorie"><?= $_review->s_sevice()->text() ?></p></div>
                    <p class="review__name" >
                        <?= $_review->s_name()->text() ?> <span class="review__<?= $_review->s_country()->text() ?>"></span>
                    </p>
                    <h3 class="review__title"><?= $_review->s_title()->text() ?></h3>
                    <div class="review__content">
                        <?= $_review->s_content()->kirbytext() ?>
                    </div>
                </blockquote>
            </li>
    <?php endforeach; ?>
    </ul>
<?php endif ?>
<?php
  $reviewPage = $site->find('reviews');
  $reviews = $reviewPage->review_list()->toStructure();


  $len = count($reviews);
  $reviewsFirst = $reviews->limit($len / 2);
  $reviewsSecond = $reviews->offset($len / 2)->limit($len);
?>

<?php if (!empty($reviews)): ?>

  <section class="lane  lane-reviews   ">
    <div class="container-fluid">
      <h2 class="lane-reviews__title"><?= $page->review_title()->text()?></h2>
      <div class="review review--full">
          <?php snippet('/components/item/reviews',array('reviews' => $reviewsFirst->limit(2), 'showHeading' => '0' )); ?>
          <?php snippet('/components/item/reviews',array('reviews' => $reviewsSecond->limit(2), 'showHeading' => '0')); ?>
      </div>
    </div>

  </section>
<?php endif ?>
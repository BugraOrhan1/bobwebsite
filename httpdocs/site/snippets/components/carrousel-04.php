<?php
// SETTINGS

  // Object review
  // review-title
  // review-text
  // review-name
  // review-ref
?>
<?php if(!empty($reviews)):  ?>
<section class="lane carrousel-04">
  <div class="container-fluid"><h2 class="carrousel-04__title">Tevreden klanten</h2></div>
  <div class="container-fluid">
    <div class="carrousel-04__items js-carrousel-04">

      <?php foreach( $reviews as $_review): ?>
      <div class="carrousel-04__item">
        <div class="carrousel-04__content content__review">
            <blockquote>
              <?= $_review->s_content()->kirbytext() ?>
              <h4 class="content__review--name"><?= $_review->s_name()->text() ?></h4>
              <?php if(!$_review->s_reference()->empty()): ?>
              <p class="content__review--ref"><?= $_review->s_reference()->text() ?></p>
              <?php endif ?>
            </blockquote>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>
<?php endif ?>
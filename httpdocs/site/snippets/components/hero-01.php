<?php
// SETTINGS

  // header height:   default or small by class.

  // Object hero-01
  // img
  // title

  // Object review | zorg voor een default spot ( [n t h] en mogelijkheid tot override )
  // review__title
  // review__sub
  // review__nr

  $classSmall = $page->hero_size()->bool()? "" : 'hero-01__small' ;

if (true):
?>
<section class="lane hero-01 <?= $classSmall ?>">
  <div class="hero-01__media">
    <?php if($image = $page->hero_image()->toFile()): ?>
        <img class="hero-01__img"
             src="<?= $image->url() ?>"
             alt="<?= $image->hero_image_txt()->text() ?>">
    <?php endif ?>
  </div>

  <div class="hero-01__fluid">
     <div class="hero-01__content">
        <div class="row bottom-xs">
          <div class="col-xs-9 col-sm-7 col-md-6 ">
              <h2 class="hero-01__title"><?= $page->hero_title()->text() ?></h2>
           </div>
          <div class="col-xs-3 col-sm-5 col-md-6">
              <a class="box-review" href="<?= $site->language()->url() .'/'. $site->review_anchor() ?>" >
                 <div class="box-review__group">
                    <h3 class="box-review__title"><?= $site->review_title()->text() ?></h3>
                    <p class="box-review__sub"><?= $site->review_sub()->text() ?></p>
                 </div>
                 <div class="box-review__nr"><span><?= $site->review_nr()->text() ?></span></div>
               </a>
           </div>
        </div>
     </div>
  </div>
</section>
<?php endif ?>
<?php
// SETTINGS

  // header height:   default or small by class.

  // Object hero-02
  // img
  // title

  // Object review | zorg voor een default spot ( [n t h] en mogelijkheid tot override )
  // review__title
  // review__sub
  // review__nr

  $classSmall = $page->hero_size()->bool()? "" : 'hero-02__small' ;

if (true):
?>
<section class="lane hero-02 <?= $classSmall ?>">
    <div class="hero-02__row ">
        <div class="hero-02__col ">
            <div class="hero-02__content">
                <h1 class="hero-02__title"><?= $page->hero_title()->text() ?></h1>
                <h2 class="hero-02__subtitle">Wij reinigen
                    meubels, banken, matrassen, interieur van auto's, tapijten
                    op locatie door heel Nederland en Belgie.</h2>

                <?php snippet('shared/group-communication') ?>
            </div>
        </div>
  </div>
</section>
<?php endif ?>
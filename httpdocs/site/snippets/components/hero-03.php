<?php
// SETTINGS

  // header height:   default or small by class.

  // Object hero-03
  // img
  // title

  // Object review | zorg voor een default spot ( [n t h] en mogelijkheid tot override )
  // review__title
  // review__sub
  // review__nr

  $classSmall = $page->hero_size()->bool()? "" : 'hero-03__small' ;

if (true):
?>
<section class="lane hero-03 <?= $classSmall ?>">
  <div class="container-fluid hero-03__fluid">
     <div class="hero-03__content">
        <div class="row ">
          <div class="col-xs-12 col-sm-10 col-md-6 col-lg-5 ">
              <figure class="lane__fig">
                  <img width="400" src="<?= url('/assets/img/voorbeeld/De-Reinigingsdokter-schoon-gevoel-web.jpg')?>"
                       alt="De Reinigingsdokter geeft een schoon gevoel dat is onze zorg!"
                        />
              </figure>
           </div>
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-7 ">
                <h1 class="hero-03__title"><?= $page->hero_title()->text() ?></h1>
                <p class="hero-03__para">Van het reinigen van een eenvoudige eetkamerstoel tot grote bankcombinaties in stof en leer. U verdient een schone omgeving en dat is onze specialiteit.</p>

                <h2>
                    Reiniging van u interieur
                </h2>
                <p>Onder andere bankstellen, eetkamer stoelen, sofa's, autostoelen, matrassen en tapijt reiniging</p>

                <?php snippet('shared/group-communication') ?>

            </div>
        </div>
     </div>
  </div>
</section>
<?php endif ?>
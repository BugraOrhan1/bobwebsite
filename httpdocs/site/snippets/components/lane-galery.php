<?php
  $photos = $page->photos()->yaml();
?>
<?php if (!empty($photos)): ?>

  <section class="lane lane-plus ">
  <div class="container-fluid">
    <div class="lane-plus_content gallery js-gallery">
      <div class="f-main gallery__items">

        <?php foreach ($photos as $image): ?>
          <?php if ($image = $page->image($image)): ?>
            <?php
            $_isRatioHorizon = $image->ratio() > 1;
            if ($_isRatioHorizon) {
              $imgResizeBig = $image->resize(1600, 1088);
              $imgResize = $image->resize(500, 340);
              $_isHorizonOrVertical = "horizontal";
            } else {
              $imgResizeBig = $image->resize(null, 1088);
              $imgResize = $image->resize(null, 250);
               $_isHorizonOrVertical = "vertical";
            }
            ?>

             <a class="gallery__item gallery--<?= $_isHorizonOrVertical ?>"
             href="<?= $imgResizeBig->url() ?>"
             title="<?= $image->filename() ?>"
             >
                <img class="gallery__img" src="<?= $imgResize->url() ?>" alt="<?= $image->filename() ?>">
             </a>
          <?php endif ?>
        <?php endforeach; ?>

      </div>
    </div>
  </div>

  </section>
<?php endif ?>
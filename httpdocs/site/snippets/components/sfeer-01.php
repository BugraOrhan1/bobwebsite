<?php
 $photos = $site->sfeer_photos()->yaml();
?>
<?php  if(!empty($photos)): ?>
<section class="lane sfeer-01 ">
  <div class="sfeer-01__items js-sfeer-01">
    <?php foreach( $photos as $image): ?>
      <?php if($image = $site->image($image)): ?>
      <?php
        //$imageCrop = $image->crop(150);
      ?>
      <div class="sfeer-01__item"><img class="sfeer-01__img" src="<?= $image->url()  ?>" alt="<?= $image->filename ()  ?>"></div>
      <?php endif ?>
    <?php endforeach; ?>
  </div>
</section>
<?php endif ?>
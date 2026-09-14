<?php
?>
<?php  if(!empty($photos)): ?>
  <div class="carrousel-01__items js-carrousel-01">

    <?php foreach( $photos as $image): ?>
    <div class="carrousel-01__item">
      <div class="carrousel-01__content ">
         <?php if($image = $page->image($image)): ?>
           <?php $imageCrop = $image->crop(150);  ?>
           <img class="carrousel-01__img" src="<?= $image->url()  ?>" data-lazy="<?= $image->url()  ?>" alt="<?= $image->filename ()  ?>">
         <?php endif ?>
      </div>
    </div>
    <?php endforeach; ?>

  </div>

<?php endif ?>
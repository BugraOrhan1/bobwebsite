<?php
?>
<?php  if(!empty($photos)): ?>
<div class="foto">
    <div class="foto__items">
        <?php foreach( $photos as $photo): ?>


            <?php
                $image = $page->image( $photo );
                $imgResize = $image->crop(358, 252);  // 358, 252

            ?>


        <div class="foto__item">
             <?php if($image): ?>
               <?php $imageCrop = $image->crop(300);  ?>
               <img  class="foto__img" height="300" width="300" src="<?= $imageCrop->url()  ?>" alt="<?= $imageCrop->filename ()  ?>">
             <?php endif ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php endif ?>
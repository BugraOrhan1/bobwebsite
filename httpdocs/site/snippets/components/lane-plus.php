<?php
// SETTINGS

  // Object plus
  // plus-reverse [left of right]
  // plus-intro
  // plus-items
  // plus-item
  // plus-exception

  // multi
  // plus-img
  // plus-alt

if (true):
?>
<section class="lane lane-plus">
  <div class="container-fluid">
      <div class="f-main">

        <div class="f-01">
          <h2 class="plus-intro"><?= $page->plus_title()->text() ?></h2>
            <div class="cont-html">
          <?= $page->plus_list()->kirbytext() ?>
            </div>
        </div>
        <div class="f-03">
            <h2 class="plus-intro">Onze voorbeelden</h2>
          <?php
            $_photos = $page->plus_photos()->yaml();
            snippet('components/foto', array('photos' => $_photos ) )
          ?>
        </div>
      </div>

    </div>
  </div>

</section>
<?php endif ?>
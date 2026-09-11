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

    <div class="lane-plus_content">

      <?php
        $reverseClass = "f-main";
        if($page->plus_reverse()->exists())  {
          $reverseClass = $page->plus_reverse()? $reverseClass : "f-main-reverse";
        }
      ?>
      <div class="plus <?= $reverseClass ?>">
        <div class="f-02">
          <?php
            $_photos = $page->plus_photos()->yaml();
            snippet('components/carrousel-01', array('photos' => $_photos ) )
          ?>
        </div>
      </div>

    </div>
  </div>

</section>
<?php endif ?>
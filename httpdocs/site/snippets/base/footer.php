<?php snippet('components/box-cta') ?>
<footer>
  <div class="container-fluid">
    <div class="footer f-main">

      <div class="f-item">
        <h3 class="footer_title"><?= $site->footer_sitemap_title()->text() ?></h3>

        <div class="footer_html">
          <?= $site->footer_sitemap_desc()->kirbytext() ?>
        </div>
      </div>

        <div class="f-item">
            <h3 class="footer_title">Onze facebook</h3>
            <?php snippet('shared/share-facebook'); ?>
        </div>

      <div class="f-item">
        <h3 class="footer_title"><?= $site->footer_contact_title()->text() ?></h3>
        <address class="footer_html">
           <?= $site->footer_contact_desc()->kirbytext() ?>
        </address>
      </div>

      <div class="f-item">

      </div>

    </div>
   </div>
</footer>
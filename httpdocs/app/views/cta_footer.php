<section class="lane box-cta">
    <div class="container-fluid">
        <div class="box-cta__quote">
            <h2 class="box-cta__title">Wil je meer weten?</h2>
            <div class="box-cta__content">
                <p class="box-cta__para"><?= h(setting('slogan')) ?></p>
            </div>

            <?php view('group_communication'); ?>

        </div>
    </div>
</section>

<footer>
  <div class="container-fluid">
    <div class="footer f-main">

      <div class="f-item">
        <h3 class="footer_title"><?= h(setting('footer_sitemap_title')) ?></h3>
        <div class="footer_html">
          <?= ktext(setting('footer_sitemap_desc')) ?>
        </div>
      </div>

        <div class="f-item">
            <h3 class="footer_title">Volg ons</h3>
            <div class="footer-social">
                <img src="/assets/logo/Gemini_Generated_Image_e5gvwve5gvwve5gv-removebg-preview.png" alt="Logo De Reinigingsdokter">
                <div>
                    <strong>De Reinigingsdokter</strong>
                    <a href="<?= h(setting('facebook')) ?>" target="_blank" rel="noopener">Facebook →</a><br>
                    <a href="<?= h(setting('instagram')) ?>" target="_blank" rel="noopener">Instagram →</a>
                </div>
            </div>
        </div>

      <div class="f-item">
        <h3 class="footer_title"><?= h(setting('footer_contact_title')) ?></h3>
        <address class="footer_html">
            <?= h(setting('site_title')) ?><br>
            W: <a href="<?= h(whatsapp_link('Wat mogen we voor jou doen?')) ?>" target="_blank" rel="noopener">Whatsapp ons</a><br>
            B: <a href="<?= phone_href() ?>"><?= h(phone_display()) ?></a><br>
            E: <a href="mailto:<?= h(setting('contact_email')) ?>"><?= h(setting('contact_email')) ?></a>
        </address>
      </div>

      <div class="f-item">
        <div class="footer_legal">
            <a href="/privacy">Privacyverklaring</a>
            <a href="/cookies">Cookies</a>
            <?php if (setting('kvk_number')): ?>
                <span>KvK: <?= h(setting('kvk_number')) ?></span>
            <?php endif; ?>
            <span>© <?= date('Y') ?> <?= h(setting('site_title')) ?></span>
        </div>
      </div>

    </div>
   </div>
</footer>

<?php /** $page: home-pagina met fields */ ?>
<section class="lane hero-02 <?= empty($page['hero_size']) ? 'hero-02__small' : '' ?>">
    <div class="hero-02__row ">
        <div class="hero-02__col ">
            <div class="hero-02__content">
                <h1 class="hero-02__title"><?= h($page['hero_title']) ?></h1>
                <h2 class="hero-02__subtitle"><?= h($page['hero_subtitle']) ?></h2>

                <div class="hero-trust" aria-label="Beoordeling">
                    <span class="hero-trust__nr"><?= h(setting('review_badge_nr', '9,6')) ?></span>
                    <span class="hero-trust__txt">
                        <strong><?= h(setting('review_badge_title', 'Voortreffelijk')) ?></strong>
                        <?= h(setting('review_badge_sub', '43 beoordelingen')) ?>
                    </span>
                </div>

                <?php view('group_communication'); ?>
            </div>
        </div>
  </div>
</section>

<section class="lane usp-lane" style="padding-top:26px">
    <div class="container-fluid">
        <?php view('usp_row'); ?>
    </div>
</section>

<section class="lane lane-service">
    <div class="container-fluid">

        <h2>We reinigen</h2>
        <p class="lane-service__para">We werken zowel voor particuliere als zakelijke klanten en maken elk soort object
            schoon. We garanderen
            iedere keer een uitstekende service van betrouwbare, hardwerkende schoonmakers. Zo ervaren klanten én
            medewerkers respect en tevredenheid.
        </p>

        <div class="f-main">
            <div class="f-01">
                <div class="service">
                    <ul class="service-items">
                        <?php foreach (all_services() as $item): ?>
                            <li class="service-item">
                                <a class="service-item__link" title="<?= h($item['title']) ?>" href="/reinigen/<?= h($item['slug']) ?>">
                                    <h3 class="service-item__title"><?= h($item['title']) ?></h3>
                                    <div class="service-item__image">
                                        <?php if (!empty($item['icon']) && file_exists(MEDIA_DIR . '/' . $item['icon'])): ?>
                                            <?= file_get_contents(MEDIA_DIR . '/' . $item['icon']) ?>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </div>

    </div>
</section>

<section class="lane lane-plus">
  <div class="container-fluid">
      <div class="f-main">

        <div class="f-01">
          <h2 class="plus-intro"><?= h($page['plus_title']) ?></h2>
            <div class="cont-html">
          <?= ktext($page['plus_list']) ?>
            </div>
        </div>
        <div class="f-03">
            <h2 class="plus-intro">Onze voorbeelden</h2>
            <p class="home-voorbeelden__sub">Sleep de knop over de foto's en zie zelf het verschil.</p>

            <div class="home-voorbeelden">
                <?php
                $voorbeelden = [
                    ['Bankstel', '/media/portfolio/ai1-voor.jpg', '/media/portfolio/ai1-na.jpg', 'Bankstel voor de reiniging', 'Bankstel na de reiniging'],
                    ['Tapijt',   '/media/reinigen/tapijtreiniging/tapijtreiniging-voor-reiniging.jpg', '/media/reinigen/tapijtreiniging/tapijtreiniging-na-reiniging.jpg', 'Tapijt voor de reiniging', 'Tapijt na de reiniging'],
                    ['Matras',   '/media/reinigen/matrasreiniging/matrasreiniging-voor-reiniging.jpg', '/media/reinigen/matrasreiniging/matrasreiniging-na-reiniging.jpg', 'Matras voor de reiniging', 'Matras na de reiniging'],
                ];
                foreach ($voorbeelden as $vb):
                    if (!file_exists(str_replace('/media/', MEDIA_DIR . '/', $vb[1]))) continue; ?>
                    <div class="home-voorbeelden__item">
                        <?php view('ba_slider', [
                            'before' => $vb[1],
                            'after'  => $vb[2],
                            'altBefore' => $vb[3],
                            'altAfter'  => $vb[4],
                        ]); ?>
                        <span class="home-voorbeelden__cap"><?= h($vb[0]) ?> — voor/na</span>
                    </div>
                <?php endforeach; ?>
            </div>

<div class="home-portfolio-cta">
                <a class="home-portfolio-cta__link" href="/portfolio">📸 Bekijk meer voor- en nafoto's in ons portfolio</a>
            </div>
        </div>
      </div>

    </div>
  </div>

</section>

<section class="lane snel-offerte">
    <div class="container-fluid">
        <div class="snel-offerte__box">
            <div class="snel-offerte__txt">
                <h2>Gratis offerte in 30 seconden</h2>
                <p>Vul uw naam en telefoonnummer in — wij bellen u terug met een scherpe prijs. Liever zelf appen? Stuur een foto via WhatsApp.</p>
            </div>
            <form method="post" action="/snel-offerte" class="snel-offerte__form">
                <?= csrf_field() ?>
                <input type="text" name="website" class="review-form__hp" tabindex="-1" autocomplete="off" aria-hidden="true">
                <input type="text" name="name" placeholder="Uw naam *" required autocomplete="name">
                <input type="tel" name="phone" placeholder="Telefoonnummer *" required autocomplete="tel">
                <select name="service">
                    <option value="">Wat mogen wij reinigen?</option>
                    <?php foreach (all_services() as $s): ?>
                        <option value="<?= h($s['title']) ?>"><?= h($s['title']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">📞 Bel mij terug met een prijs</button>
                <p class="snel-offerte__trust">⭐ <?= h(setting('review_badge_nr', '9,6')) ?> uit <?= (int)preg_replace('/\D/', '', setting('review_badge_sub', '43')) ?> reviews · ⚡ Reactie binnen 2 uur · ✅ Gratis &amp; vrijblijvend</p>
            </form>
        </div>
    </div>
</section>

<section class="lane lane-prices-home">
    <div class="container-fluid">
        <h2 class="title">Dit zijn onze tarieven</h2>
        <p class="desc">Hieronder vindt u een overzicht van onze tarieven. Wij geven hier een vanaf-prijsindicatie, inclusief btw en exclusief voorrijkosten. Wilt u een prijsopgave voor het reinigen van uw meubels! Neem dan contact met ons op
        </p>

        <?php view('prices_block', ['groups' => price_groups_with_items()]); ?>

    </div>
</section>

<?php
$reviews = all_reviews();
$len = count($reviews);
$half = intdiv($len, 2);
$firstTwo = array_slice($reviews, 0, 2);
$secondTwo = array_slice($reviews, $half, 2);
?>
<?php if ($reviews): ?>
  <section class="lane  lane-reviews   ">
    <div class="container-fluid">
      <h2 class="lane-reviews__title"><?= h($page['review_title']) ?></h2>
      <div class="review review--full">
          <?php view('reviews_block', ['reviews' => $firstTwo, 'showHeading' => false]); ?>
          <?php view('reviews_block', ['reviews' => $secondTwo, 'showHeading' => false]); ?>
      </div>
      <div class="review-cta">
          <a href="/reviews#review-form">⭐ Klant geweest? Laat ook een beoordeling achter</a>
      </div>
    </div>

  </section>
<?php endif; ?>

<?php view('faq_block'); ?>

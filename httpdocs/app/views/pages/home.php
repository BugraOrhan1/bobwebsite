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

            <?php if (file_exists(MEDIA_DIR . '/reinigen/bankreinigen-voor-reiniging.jpg') && file_exists(MEDIA_DIR . '/reinigen/bankreinigen-na-reiniging.jpg')): ?>
                <?php view('ba_slider', [
                    'before' => '/media/reinigen/bankreinigen-voor-reiniging.jpg',
                    'after' => '/media/reinigen/bankreinigen-na-reiniging.jpg',
                    'altBefore' => 'Bankstel voor de bankreiniging',
                    'altAfter' => 'Bankstel na de bankreiniging',
                ]); ?>
            <?php endif; ?>

            <?php
            $photos = [];
            foreach (preg_split('/\s*\n\s*/', trim((string)($page['plus_photos'] ?? ''))) as $line) {
                $line = trim(preg_replace('/^-\s*/', '', $line));
                if ($line !== '') $photos[] = $line;
            }
            ?>
            <?php if ($photos): ?>
            <div class="foto">
                <div class="foto__items">
                    <?php foreach ($photos as $ph): ?>
                        <?php if (!file_exists(MEDIA_DIR . '/home/' . $ph)) continue; ?>
                        <div class="foto__item">
                            <img class="foto__img" height="300" width="300" loading="lazy"
                                 src="/media/home/<?= h($ph) ?>" alt="<?= h(pathinfo($ph, PATHINFO_FILENAME)) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
      </div>

    </div>
  </div>

</section>

<section class="lane lane-prices-home">
    <div class="container-fluid">
        <h2 class="title">Dit zijn onze tarieven</h2>
        <p class="desc">Hieronder vindt u een overzicht van onze tarieven. Wij geven hier een vanaf prijsindicatie exclusief voorrijkosten. Wilt u een prijsopgave voor het reinigen van uw meubels! Neem dan contact met ons op
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
    </div>

  </section>
<?php endif; ?>

<?php view('faq_block'); ?>

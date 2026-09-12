<?php /** Zijbalk: diensten, meerwaarde, socials, partners. $showWhy: bool */ ?>
<div class="services">
    <h2 class="services_title">Wij bieden aan</h2>
    <ul class="services_items">
        <?php foreach (all_services() as $item): ?>
            <li class="services_item">
                <a class="services_href" title="<?= h($item['title']) ?>" href="/reinigen/<?= h($item['slug']) ?>">
                    <?= h($item['title']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php if (!empty($showWhy)): ?>
<div class="side__block ">
    <h3 class="side__title">Onze meerwaarde</h3>
    <ul>
        <li>Hoge kwaliteit meubelreiniging</li>
        <li>Reinigen op locatie, geen gesleep met meubels</li>
        <li>100% milieuvriendelijk</li>
        <li>Altijd eerlijk advies<br/></li>
        <li>Verwijdert huisstofmijt</li>
        <li>Helpt tegen hooikoorts en andere allergieën</li>
        <li>Vriendelijke service en scherpe tarieven</li>
    </ul>
</div>
<?php endif; ?>

<h2 class="services_title">Volg ons</h2>

<div class="locations">
    <div id="fb-root"></div>
    <div class="fb-page"
         data-href="<?= h(setting('facebook')) ?>"
         data-width="300"
         data-adapt-container-width="true"
         data-hide-cover="true"
         data-lazy="true"
         data-show-facepile="false"></div>
</div>

<div class="locations__volgons">
    <a href="<?= h(setting('facebook')) ?>" class="locations__volgons__button" role="button" target="_blank" rel="noopener" title="Volg ons via facebook <?= h(setting('site_title')) ?>">
        <span class="locations__volgons__wrapper">
            <span class="locations__volgons__icon"></span>
            <span class="locations__volgons__text">Volg ons op Facebook</span>
        </span>
    </a>

    <a href="<?= h(setting('instagram')) ?>" class="locations__volgons__button" role="button" target="_blank" rel="noopener" title="Volg ons via instagram <?= h(setting('site_title')) ?>">
        <span class="locations__volgons__wrapper">
            <span class="locations__volgons__icon-instagram"></span>
            <span class="locations__volgons__text">Volg ons op Instagram</span>
        </span>
    </a>
</div>
<br/>
<br/>
<div class="services">
    <h2 class="services_title">Reinigings service / Onderhoud service</h2>
    <ul class="services_items">
        <li class="services_item">
            <a target="_blank" rel="noopener" class="services_href" title="Montèl" href="https://www.montel.nl/collectie/banken/">Montèl banken </a>
        </li>
        <li class="services_item"><a target="_blank" rel="noopener" class="services_href" title="jysk banken" href="https://jysk.nl/woonkamer/banken">jysk banken</a></li>
        <li class="services_item"><a target="_blank" rel="noopener" class="services_href" title="Ikea banken" href="https://www.ikea.com/nl/nl/cat/alle-banken-39130/">Ikea banken</a></li>
        <li class="services_item"><a target="_blank" rel="noopener" class="services_href" title="vt wonen banken" href="https://www.vtwonen.nl/inspiratie/nieuw-vtwonen-banken-collectie/">vtwonen banken</a></li>
        <li class="services_item"><a target="_blank" rel="noopener" class="services_href" title="Carpetright tapijt reinigen" href="https://www.carpetright.nl/vloeren/tapijt">Carpetright tapijt</a></li>
    </ul>
</div>

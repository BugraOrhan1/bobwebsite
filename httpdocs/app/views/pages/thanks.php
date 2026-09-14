<?php /** Bedankt-pagina na contactformulier. $page */ ?>
<section class="article-02">
    <div class="container-fluid">
        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php view('breadcrumb', ['crumbs' => [
                    ['title' => 'Home', 'url' => '/'],
                    ['title' => 'Contact', 'url' => '/contact'],
                    ['title' => 'Bedankt', 'url' => '/contact/bedankt'],
                ]]); ?>
                <div class="article-02__content">
                    <div class="cont-html">
                        <h1 class="lane__title">Bedankt voor uw bericht!</h1>
                        <?= ktext($page['thank_you_message']) ?>
                        <p><strong>Liever direct antwoord?</strong> Stuur ons een WhatsApp-bericht met een foto van wat u gereinigd wilt hebben — dan kunnen we vaak binnen 2 uur een prijs doorgeven.</p>
                    </div>
                    <?php view('group_communication'); ?>
                </div>
            </div>

            <div class="article-02__col-2">
                <div class="article-02__box">
                    <?php view('sidebar', ['showWhy' => true]); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php // Conversie-meting voor Google Ads (wordt in app.js afgevuurd) ?>
<div id="ads-form-conversion" data-label="<?= h(setting('ads_conversion_form', '')) ?>"></div>

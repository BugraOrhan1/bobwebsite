<?php /** Portfolio met voor/na-foto's. $page, $crumbs */
$items = db()->query('SELECT * FROM portfolio_items WHERE active = 1 ORDER BY sort ASC, id ASC')->fetchAll();
?>
<section class="article-02 article-02--portfolio">
    <div class="container-fluid">

        <div class="portfolio-intro">
            <h1 class="lane__title"><?= h($page['intro_title']) ?></h1>
            <div class="cont-html"><?= ktext($page['intro_description']) ?></div>
        </div>

        <?php if ($items): ?>
        <div class="portfolio-grid">
            <?php foreach ($items as $it): ?>
                <figure class="portfolio-card">
                    <div class="portfolio-card__pair">
                        <div class="portfolio-card__img">
                            <span class="portfolio-card__label portfolio-card__label--voor">Voor</span>
                            <img src="<?= h($it['before_img']) ?>" alt="<?= h($it['title']) ?> — voor de reiniging" loading="lazy">
                        </div>
                        <div class="portfolio-card__img">
                            <span class="portfolio-card__label portfolio-card__label--na">Na</span>
                            <img src="<?= h($it['after_img']) ?>" alt="<?= h($it['title']) ?> — na de reiniging" loading="lazy">
                        </div>
                    </div>
                    <figcaption><?= h($it['title']) ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="portfolio-cta">
            <h2>Ook zo'n schoon resultaat?</h2>
            <p>Stuur ons een foto van uw meubel via WhatsApp en ontvang binnen 2 uur een scherpe prijs.</p>
            <?php view('group_communication'); ?>
        </div>

    </div>
</section>

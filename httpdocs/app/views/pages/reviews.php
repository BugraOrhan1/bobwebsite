<?php /** Reviewspagina. $page, $crumbs */ ?>
<section class="article-02 article-02--review">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php view('breadcrumb', ['crumbs' => $crumbs]); ?>

                <div class="article-02__content">
                    <div class="cont-html">
                        <h1 class="lane__title"><?= h($page['intro_title']) ?></h1>
                        <?= ktext($page['intro_description'] ?? '') ?>
                    </div>

                    <div class="review-form" id="review-form">
                        <?php if (isset($_GET['bedankt'])): ?>
                            <div class="review-form__thanks">🎉 Bedankt! Uw beoordeling is ontvangen en wordt na een korte controle gepubliceerd.</div>
                        <?php endif; ?>
                        <h2>Laat uw beoordeling achter</h2>
                        <p>Tevreden over het resultaat? Laat het anderen weten — het kost één minuut.</p>
                        <form method="post" action="/reviews" class="form-01">
                            <?= csrf_field() ?>
                            <input type="text" name="website" class="review-form__hp" tabindex="-1" autocomplete="off" aria-hidden="true">
                            <div class="review-form__row">
                                <div>
                                    <label for="rv-name">Uw naam *</label>
                                    <input id="rv-name" type="text" name="name" required autocomplete="name">
                                </div>
                                <div>
                                    <label for="rv-rating">Score</label>
                                    <select id="rv-rating" name="rating">
                                        <option value="5" selected>★★★★★ — uitstekend</option>
                                        <option value="4">★★★★ — goed</option>
                                        <option value="3">★★★ — gemiddeld</option>
                                        <option value="2">★★ — matig</option>
                                        <option value="1">★ — slecht</option>
                                    </select>
                                </div>
                            </div>
                            <div class="review-form__row">
                                <div>
                                    <label for="rv-service">Welke reiniging?</label>
                                    <select id="rv-service" name="service">
                                        <option value="">— kies optie —</option>
                                        <?php foreach (all_services() as $s): ?>
                                            <option value="<?= h($s['title']) ?>"><?= h($s['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="rv-title">Korte titel</label>
                                    <input id="rv-title" type="text" name="title" placeholder="bijv. Bank weer als nieuw">
                                </div>
                            </div>
                            <label for="rv-content">Uw ervaring *</label>
                            <textarea id="rv-content" name="content" rows="4" required placeholder="Vertel kort hoe u de reiniging ervaren heeft…"></textarea>
                            <button class="btn btn--primary review-form__btn" type="submit">⭐ Beoordeling insturen</button>
                            <p class="review-form__note">Uw beoordeling wordt na een korte controle gepubliceerd.</p>
                        </form>
                    </div>

                    <?php
                    $reviews = all_reviews();
                    usort($reviews, fn($a, $b) => strcmp($a['service'], $b['service']));
                    ?>
                    <?php if ($reviews): ?>
                    <div class="review review--full-show-3">
                        <?php view('reviews_block', ['reviews' => $reviews, 'showHeading' => true]); ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</section>

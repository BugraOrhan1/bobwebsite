<?php
/**
 * $reviews: lijst reviews
 * $showHeading: bool — kopjes per dienst
 * $amountColumn: 2|3
 */
$showHeading = $showHeading ?? false;
$lastService = '';
$started = false;
?>
<?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $_review): ?>

        <?php if ($showHeading && $lastService !== $_review['service']): ?>
            <?php $lastService = $_review['service']; ?>
            <?php if ($started): ?></ul><?php endif; ?>
            <?php $started = false; ?>
            <div class="review__item-title ">
                <h2 class="title"><?= h($lastService) ?></h2>
            </div>
        <?php endif; ?>

        <?php if (!$started): ?>
            <?php $started = true; ?>
            <ul class="review__items">
        <?php endif; ?>

            <li class="review__item">
                <blockquote class="review__block">
                    <p class="review__stars" aria-label="Beoordeling: 5 sterren"></p>
                    <div class="review__service"><p class="review__categorie"><?= h($_review['service']) ?></p></div>
                    <p class="review__name">
                        <?= h($_review['name']) ?> <span class="review__<?= h($_review['country'] ?: 'nl') ?>"></span>
                    </p>
                    <?php if (!empty($_review['title'])): ?>
                    <h3 class="review__title"><?= h($_review['title']) ?></h3>
                    <?php endif; ?>
                    <div class="review__content">
                        <?= ktext($_review['content']) ?>
                    </div>
                </blockquote>
            </li>
    <?php endforeach; ?>
    <?php if ($started): ?></ul><?php endif; ?>
<?php endif; ?>

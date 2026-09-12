<?php
/**
 * Werkgebied-blok met stadlinks.
 * $service: huidige dienst (array), $limit: aantal direct zichtbare links
 */
$cities = all_cities();
$limit = $limit ?? 60;
$first = array_slice($cities, 0, $limit);
$rest = array_slice($cities, $limit);
?>
<div class="locations">
    <h2 class="locations__title">Werkgebied</h2>
    <p class="locations__desc">De Reinigingsdokter doet werkzaamheden door heel Nederland en België.</p>
    <ul class="locations__items">
        <?php foreach ($first as $c): ?>
            <li class="locations__item">
                <a class="locations__href" href="/reinigen/<?= h($service['slug']) ?>/<?= h($c['slug']) ?>">
                    <?= h($c['name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if ($rest): ?>
    <details class="locations-more">
        <summary class="locations-more__summary">Toon alle <?= count($cities) ?> plaatsen</summary>
        <ul class="locations__items">
            <?php foreach ($rest as $c): ?>
                <li class="locations__item">
                    <a class="locations__href" href="/reinigen/<?= h($service['slug']) ?>/<?= h($c['slug']) ?>">
                        <?= h($c['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </details>
    <?php endif; ?>
</div>

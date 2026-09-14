<?php
/**
 * Interactieve voor/na-slider.
 * $before, $after: URL's van de afbeeldingen; $altBefore, $altAfter: teksten
 */
if (empty($before) || empty($after)) return;
?>
<figure class="ba-slider" role="group" aria-label="Voor en na vergelijking">
    <img src="<?= h($before) ?>" alt="<?= h($altBefore ?? 'Voor de reiniging') ?>">
    <img class="ba-slider__after" src="<?= h($after) ?>" alt="<?= h($altAfter ?? 'Na de reiniging') ?>">
    <span class="ba-slider__label ba-slider__label--before">Voor</span>
    <span class="ba-slider__label ba-slider__label--after">Na</span>
    <span class="ba-slider__divider"></span>
    <span class="ba-slider__handle"></span>
    <input class="ba-slider__range" type="range" min="0" max="100" value="50" aria-label="Sleep om voor en na te vergelijken">
</figure>
<p class="ba-hint">← sleep om het verschil te zien →</p>

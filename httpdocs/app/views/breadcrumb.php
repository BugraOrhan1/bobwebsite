<?php /** $crumbs: array van ['title'=>..., 'url'=>...] */ ?>
<ul class="breadcrumb">
    <?php foreach ($crumbs as $i => $crumb): ?>
        <li>
            <a class="breadcrumb__link" href="<?= h($crumb['url']) ?>" <?= $i === count($crumbs) - 1 ? 'aria-current="page"' : '' ?>><?= h($crumb['title']) ?></a>
        </li>
    <?php endforeach; ?>
</ul>

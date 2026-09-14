<?php
    //$page
?>
<ul class="breadcrumb">
    <?php foreach($site->breadcrumb() as $crumb): ?>
        <li>
            <a class="breadcrumb__link" href="<?= $crumb->url() ?>" <?= e($crumb->isActive(), 'aria-current="page"') ?>> <?=  $crumb->title()->text() ?></a>
        </li>
    <?php endforeach ?>
</ul>
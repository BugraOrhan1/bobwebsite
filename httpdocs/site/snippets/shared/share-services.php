<?php
$pageReiniging = $site->page('reinigen');
$template = $pageReiniging->template();
?>
<?php if($pageReiniging->isNotEmpty() && $template == 'services' ): ?>
<div class="services">
    <h2 class="services_title">Wij bieden aan<?= $site->page('reinigen')->uiid() ?></h2>
    <ul class="services_items">
        <?php foreach($pageReiniging->children() as $item): ?>
            <li class="services_item">
                <a class="services_href" title="<?= $item->title()->text()?>" href="<?= $item->url() ?>">
                    <?= $item->title()->text()?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>
<?php endif ?>
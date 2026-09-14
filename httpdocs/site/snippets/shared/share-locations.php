<?php
//$url = $site->page('reinigen')->url();
$template = $pageReiniging->template();
?>
<?php if(isset($pageReiniging) && $template != 'services' ): ?>
    <?php
    //$url = $site->page('reinigen')->url();
    $children = $pageReiniging->children();
    ?>
    <div class="locations">
        <h2 class="locations__title">Werkgebied</h2>
        <p class="locations__desc">De Reinigingsdokter doet werkzaamheden door heel Nederland en Belgie.</p>
        <ul class="locations__items">
            <?php foreach($children as $subpage): ?>
                <li class="locations__item">
                    <a class="locations__href" href="<?= $subpage->url() ?>">
                        <?= html($subpage->title()) ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<?php else: ?>
    <?php
        $firstPage =  $page->children()->first()->children();
    ?>
    <h2 class="locations__title">Werkgebied <?= $page->children()->first()->title()->lower() ?></h2>
    <p class="locations__desc">De Reinigingsdokter doet werkzaamheden door heel Nederland en Belgie.</p>
    <ul class="locations__items">
        <?php foreach($firstPage as $item): ?>
            <li class="locations__item">
                <a class="locations__href" href="<?= $item->url() ?>">
                    <?= $item->title()->html()?>
                </a>
            </li>

        <?php endforeach ?>
    </ul>

<?php endif ?>
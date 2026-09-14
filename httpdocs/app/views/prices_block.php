<?php
/** $groups: price groups; toont het prijzenoverzicht */
?>
<div class="component-prices">
    <div class="prices">
        <?php foreach ($groups as $g): ?>
            <div class="prices__col">
                <div class="prices-item__title"><?= h($g['title']) ?></div>
                <div class="prices-items">
                    <?php foreach ($g['items'] as $it): ?>
                        <div class="prices-item">
                            <div class="prices-item__type"><span class="prices-item__type-desc"><?= h($it['name']) ?></span></div>
                            <div class="prices-item_price"><?= preg_match('/€|\d/', $it['price']) ? '<span class="prices-item__va">v.a.</span> ' : '' ?><?= h($it['price']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="prices__btw">Alle tarieven zijn inclusief btw, exclusief voorrijkosten.</div>
</div>

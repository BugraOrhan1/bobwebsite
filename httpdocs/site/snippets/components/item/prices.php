<div class="component-prices">
    <div class="prices">
        <?php
         if (isset($showParent) && $showParent  == 'yes') {
             $page = $page->parent();
         }
        $showpricesAll = isset($prices) ? $prices == 'all' : false;
        $showpriceID = $page->content_showpriceID()->split(",");
        ?>
        <?php if(in_array("1", $showpriceID) || $showpricesAll): ?>
            <div class="prices__col">
                <?php snippet('shared/prices/bankreiniging'); ?>
            </div>
        <?php endif ?>
        <?php if(in_array("2", $showpriceID) || $showpricesAll): ?>
            <div class="prices__col">
                <?php snippet('shared/prices/stoelreiniging'); ?>
            </div>
        <?php endif ?>
        <?php if(in_array("3", $showpriceID) || $showpricesAll): ?>
            <div class="prices__col">
                <?php snippet('shared/prices/matrasreiniging'); ?>
            </div>
        <?php endif ?>

        <?php if(in_array("4", $showpriceID) || $showpricesAll): ?>
            <div class="prices__col">
                <?php snippet('shared/prices/auto-interieurreiniging'); ?>
            </div>
        <?php endif ?>

        <?php if(in_array("5", $showpriceID) || $showpricesAll): ?>
            <div class="prices__col">
                <?php snippet('shared/prices/tapijtreiniging'); ?>
            </div>
        <?php endif ?>

        <?php if(in_array("6", $showpriceID) || $showpricesAll): ?>
            <div class="prices__col">
                <?php snippet('shared/prices/gevelreiniging'); ?>
            </div>
        <?php endif ?>
        <?php if(in_array("7", $showpriceID) || $showpricesAll): ?>
            <div class="prices__col">
                <?php snippet('shared/prices/zonnepanelenreinigen'); ?>
            </div>
        <?php endif ?>
        <?php if(in_array("8", $showpriceID) || $showpricesAll): ?>
            <div class="prices__col">
                <?php snippet('shared/prices/kantoorpanden'); ?>
            </div>
        <?php endif ?>
        


    </div>
    <div class="prices__btw">Alle tarieven zijn inclusief btw, exclusief voorrijkosten.</div>
</div>
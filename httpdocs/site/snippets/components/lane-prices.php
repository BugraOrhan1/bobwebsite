<?php
// SETTINGS

?>
<section class="lane lane-prices">
    <div class="container-fluid">
        <div class="f-main ">
            <div class="f-01 ">
                <?php
                snippet('shared/breadcrumb');
                ?>

                <h1 class="lane__title"><?= $page->title()->html()?></h1>
                <p class="desc">De prijzen zijn gebaseerd op inclusief kussens en is een vanaf prijs</p>
                <div class="component-prices">
                    <div class="prices">

                        <div class="prices__col">
                            <?php snippet('shared/prices/bankreiniging'); ?>
                        </div>

                        <div class="prices__col">
                            <?php snippet('shared/prices/stoelreiniging'); ?>
                        </div>

                        <div class="prices__col">
                            <?php snippet('shared/prices/matrasreiniging'); ?>
                        </div>
                        <div class="prices__col">
                            <?php snippet('shared/prices/auto-interieurreiniging'); ?>
                        </div>
                        <div class="prices__col">
                            <?php snippet('shared/prices/tapijtreiniging'); ?>
                        </div>
                        <div class="prices__col">
                            <?php snippet('shared/prices/zonnepanelenreinigen'); ?>
                        </div>


                    </div>
                </div>
            </div>

            <div class="f-02">
                <?php snippet('shared/block-why') ?>
                <?php snippet('shared/group-communication') ?>
            </div>
        </div>

    </div>

</section>
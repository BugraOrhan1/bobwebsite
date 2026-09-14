<?php
// SETTINGS

// Object plus
// plus-reverse [left of right]
// plus-intro
// plus-items
// plus-item
// plus-exception

// multi
// plus-img
// plus-alt
?>
<section class="lane lane-service">
    <div class="container-fluid">

        <h2>We reinigen</h2>
        <p class="lane-service__para">We werken zowel voor particuliere als zakelijke klanten en maken elk soort object
            schoon. We garanderen
            iedere keer een uitstekende service van betrouwbare, hardwerkende schoonmakers. Zo ervaren klanten én
            medewerkers respect en tevredenheid.
        </p>

        <div class="f-main">
            <div class="f-01">
                <div class="service">

                    <?php
                    $pageReiniging = $site->page('reinigen');
                    $template = $pageReiniging->template();
                    ?>
                    <?php if($pageReiniging->isNotEmpty() && $template == 'services' ): ?>
                    <ul class="service-items">
                        <?php foreach($pageReiniging->children() as $item): ?>
                            <li class="service-item">
                                <a class="service-item__link" title="<?= $item->title()->text()?>" href="<?= $item->url() ?>">
                                    <h3 class="service-item__title"><?= $item->title()->text()?></h3>
                                    <div class="service-item__image">
                                        <?php if ($image = image($item->uri() . '/' . $item->icon())):?>
                                            <?php echo file_get_contents( $image ); ?>
                                        <?php endif ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                    <?php endif ?>
                </div>
            </div>

        </div>

    </div>
</section>
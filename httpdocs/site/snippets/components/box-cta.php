<?php
// SETTINGS

// Object box-cta
// cta-title
// cta-href
// cta-btn-text

if (true):
    ?>
    <section class="lane box-cta">
        <div class="container-fluid">
            <div class="box-cta__quote">
                <h2 class="box-cta__title">Wil je meer weten?</h2>
                <div class="box-cta__content">
                    <p class="box-cta__para"><?= $site->globel_slogan() ?></p>
                </div>

                <?php snippet('shared/group-communication') ?>

            </div>
        </div>
    </section>
<?php endif ?>
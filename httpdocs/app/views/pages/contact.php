<?php /** Contactpagina. $page, $crumbs, $errors (array), $old (array) */ ?>
<section class="article-02">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php view('breadcrumb', ['crumbs' => $crumbs]); ?>
                <div class="article-02__content">
                    <div class=" cont-html">
                        <h1 class="lane__title"><?= h($page['intro_title']) ?></h1>
                        <?= ktext($page['intro_description']) ?>
                    </div>

                    <div class="side-center form-01">
                        <style>
                            form .honeypot { position: absolute; overflow: hidden; width: 0; height: 0; pointer-events: none; }
                        </style>
                        <form id="contact-form"
                              action="/contact"
                              method="POST" enctype="multipart/form-data"
                              class="form-01__post"
                              novalidate>
                            <?= csrf_field() ?>
                            <input type="hidden" name="gclid" id="gclid-field" value="">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?= ktext($page['form_message']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <label for="js-name">Naam</label>
                                    <input class="form-01__control<?= isset($errors['fullName']) ? ' error' : '' ?>"
                                           id="js-name" type="text" autocomplete="name"
                                           value="<?= h($old['fullName'] ?? '') ?>"
                                           name="fullName" required>
                                    <?php if (isset($errors['fullName'])): ?><p><span style="color: red;"><?= h($errors['fullName']) ?></span></p><?php endif; ?>
                                </div>

                                <div class="col-xs-12 col-sm-6">
                                    <label for="js-phone">Telefoonnummer</label>
                                    <input class="form-01__control<?= isset($errors['phone']) ? ' error' : '' ?>"
                                           id="js-phone" type="tel" autocomplete="tel" name="phone" placeholder="06-"
                                           value="<?= h($old['phone'] ?? '') ?>">
                                    <?php if (isset($errors['phone'])): ?><p><span style="color: red;"><?= h($errors['phone']) ?></span></p><?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <label for="js-email">E-mail</label>
                                    <input class="form-01__control<?= isset($errors['email']) ? ' error' : '' ?>"
                                           id="js-email" name="email" type="email" autocomplete="email"
                                           value="<?= h($old['email'] ?? '') ?>" required>
                                    <?php if (isset($errors['email'])): ?><p><span style="color: red;"><?= h($errors['email']) ?></span></p><?php endif; ?>
                                </div>

                                <div class="col-xs-12 col-sm-6">
                                    <label for="js-woonplaats">Woonplaats</label>
                                    <input class="form-01__control" name="woonplaats" type="text" autocomplete="address-level2"
                                           value="<?= h($old['woonplaats'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="js-message">Bericht</label>
                                    <textarea class="message<?= isset($errors['message']) ? ' error' : '' ?>"
                                              id="js-message" name="message" required><?= h($old['message'] ?? '') ?></textarea>
                                    <?php if (isset($errors['message'])): ?><p><span style="color: red;"><?= h($errors['message']) ?></span></p><?php endif; ?>
                                    <p class="form-hint">Tip: stuur anders even een foto via WhatsApp <?= h(phone_display()) ?> — dan kunnen we direct een prijs geven.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="js-filefield">Bijlage (foto van wat u gereinigd wilt hebben)</label>
                                    <input class="form-01__control" id="js-filefield" type="file" name="filefield"
                                           accept="image/*,.pdf"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <label for="lead">Hoe heeft u ons gevonden?</label>
                                    <select class="form-01__control" name="lead" id="lead">
                                        <option value="--">- Hoe heeft u ons gevonden? -</option>
                                        <option value="Google" <?= ($old['lead'] ?? '') === 'Google' ? 'selected' : '' ?>>Google</option>
                                        <option value="Facebook" <?= ($old['lead'] ?? '') === 'Facebook' ? 'selected' : '' ?>>Facebook</option>
                                                                                <option value="KennissenOfFamilie" <?= ($old['lead'] ?? '') === 'KennissenOfFamilie' ? 'selected' : '' ?>>Via Kennissen of familie</option>
                                        <option value="Anders" <?= ($old['lead'] ?? '') === 'Anders' ? 'selected' : '' ?>>Anders/etc</option>
                                    </select>
                                </div>
                            </div>

                            <div class="honeypot" aria-hidden="true">
                                <label>Vul dit veld NIET in: <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <button id="js-send-message" type="submit" name="contactme"
                                            class="_btn button-02" value="Send">Versturen
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>


            <div class="article-02__col-2">
                <div class="article-02__box">
                    <?php view('sidebar', ['showWhy' => true]); ?>
                    <div class="cont-html side-address">
                        <?= ktext($page['side_address'] ?? '') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

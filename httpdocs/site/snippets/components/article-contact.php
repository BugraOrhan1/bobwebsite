<?php
// page bedankt
$urlThanks = false;
if(strpos($page->url(), 'bedankt') !== false) {
    $urlThanks = true;
}

$hasSucces = a::get($alert, 'succes');
$cleanPost = a::get($alert, 'cleanPost');

?>
    <section class="article-02">
        <div class="container-fluid">

            <div class="article-02__main">
                <div class="article-02__col-1 ">
                    <?php
                    snippet('shared/breadcrumb');
                    ?>
                    <div class="article-02__content">
                        <div class=" cont-html">
                            <h1 class="lane__title"><?= $page->intro_title()->text()?></h1>
                            <?= $page->intro_description()->kirbytext() ?>

                            <?php if($urlThanks === true): ?>

                            <?php endif; ?>
                        </div>
                        <?php if($urlThanks === false): ?>
                            <div class="side-center form-01">
                                <style>
                                    form .honeypot {
                                        position: absolute;
                                        overflow: hidden;
                                        width: 0;
                                        height: 0;
                                        pointer-events: none;
                                    }
                                </style>
                                <form id="contact-form"
                                      v-on:submit="onSubmit"
                                      action="<?= $page->url() ?>"
                                      method="POST" enctype="multipart/form-data"
                                      class="form-01__post"
                                      novalidate>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <?= $page->form_message()->kirbytext() ?>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label for="js-name"><?= l::get('contact_name') ?></label>
                                            <input
                                                <?php if(isset($errorForm['fullName']) ): ?>
                                                    class="form-01__control error"
                                                <?php else: ?>
                                                    class="form-01__control"
                                                <?php endif; ?>
                                                    id="js-name"
                                                    type="text"
                                                    value="<?= $data['fullName'] ?>"
                                                    name="fullName"
                                                    v-model="formData.fullName"
                                                    v-validate="'required'">
                                            <div class="validation-flag has-arrow-top"
                                                 v-show="fields.fullName
                                                  && fields.fullName.invalid
                                                  && fields.fullName.validated">
                                                {{ errors.first('fullName') }}
                                            </div>
                                            <?php if(isset($errorForm['fullName']) ): ?>
                                                <p class="validation-flag has-arrow-top"><span style="color: red;"><?= $errorForm['fullName'] ?></span></p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <label for="js-phone"><?= l::get('contact_phone') ?></label>
                                            <input
                                                <?php if(isset($errorForm['phone']) ): ?>
                                                    class="form-01__control error"
                                                <?php else: ?>
                                                    class="form-01__control"
                                                <?php endif; ?>
                                                    id="js-phone"
                                                    type="text"
                                                    name="phone"
                                                    placeholder="06-"
                                                    v-model="formData.phone"
                                            >
                                            <?php if(isset($errorForm['phone']) ): ?>
                                                <p><span style="color: red;"><?= $errorForm['phone'] ?></span></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label for="js-email"><?= l::get('contact_email') ?></label>
                                            <input
                                                <?php if(isset($errorForm['email']) ): ?>
                                                    class="form-01__control error"
                                                <?php else: ?>
                                                    class="form-01__control"
                                                <?php endif; ?>
                                                    id="js-email"
                                                    name="email"
                                                    type="email"
                                                    v-model="formData.email"
                                                    v-validate="'required|email'"
                                            >
                                            <div class="validation-flag has-arrow-top"
                                                 v-show="fields.email
                                              && fields.email.invalid
                                              && fields.email.validated">
                                                {{ errors.first('email') }}
                                            </div>
                                            <?php if(isset($errorForm['email']) ): ?>
                                                <p><span style="color: red;"><?= $errorForm['email'] ?></span></p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <label for="js-email">Woonplaats</label>
                                            <input
                                                <?php if(isset($errorForm['woonplaats']) ): ?>
                                                    class="form-01__control error"
                                                <?php else: ?>
                                                    class="form-01__control"
                                                <?php endif; ?>
                                                    name="woonplaats"
                                                    type="text"
                                                    v-model="formData.woonplaats"
                                            >
                                            <div class="validation-flag has-arrow-top"
                                                 v-show="fields.email
                                              && fields.email.invalid
                                              && fields.email.validated">
                                                {{ errors.first('email') }}
                                            </div>
                                            <?php if(isset($errorForm['email']) ): ?>
                                                <p><span style="color: red;"><?= $errorForm['email'] ?></span></p>
                                            <?php endif; ?>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label for="js-message"><?= l::get('contact_message') ?></label>
                                            <textarea
                                                <?php if(isset($errorForm['message']) ): ?>
                                                    class="message error"
                                                <?php else: ?>
                                                    class="message"
                                                <?php endif; ?>
                                                    id="js-message"
                                                    class="message"
                                                    name="message"
                                                    v-model="formData.message"
                                                    v-validate="'required'"><?= $data['message'] ?></textarea>
                                            <?php if(isset($errorForm['message']) ): ?>
                                                <p><span style="color: red;"><?= $errorForm['message'] ?></span></p>
                                            <?php endif; ?>
                                            <div class="validation-flag has-arrow-top"
                                                 v-show="fields.message
                                              && fields.message.invalid
                                              && fields.message.validated">
                                                {{ errors.first('message') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label for="js-filefield">Bijlage</label>
                                            <input
                                                <?php if(isset($errorForm['filefield']) ): ?>
                                                    class="form-01__control error"
                                                <?php else: ?>
                                                    class="form-01__control"
                                                <?php endif; ?>
                                                   id="js-filefield"
                                                   type="file"
                                                   name="filefield"
                                                   />
                                            <?php if(isset($errorForm['filefield']) ): ?>
                                                <p><span style="color: red;"><?= $errorForm['filefield'] ?></span></p>
                                            <?php endif; ?>
                                            <div class="validation-flag has-arrow-top"
                                                 v-show="fields.filefield
                                              && fields.filefield.invalid
                                              && fields.filefield.validated">
                                                {{ errors.first('message') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label for="js-lead">Hoe heeft u ons gevonden?</label>
                                            <select class="form-01__control" name="lead" id="lead">
                                                <option value="--">- Hoe heeft u ons gevonden? -</option>
                                                <option value="Google">Google</option>
                                                <option value="Facebook">Facebook</option>
                                                <option value="Instagram">Instagram</option>
                                                <option value="KennissenOfFamilie">Via Kennissen of familie</option>
                                                <option value="Anders">Anders/etc</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button id="js-send-message"
                                                    type="submit"
                                                    name="contactme"
                                                    class="_btn button-02"
                                                    v-on:click="onValidate"
                                                    value="Send">Versturen
                                            </button>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 text-right" style="position: relative;">
                                            <div id='recaptcha'
                                                 class="g-recaptcha"
                                                 data-sitekey="6Lct9wUaAAAAAPShnJz_-dHX9rnAGf0qQnqYbPOQ"
                                                 data-badge="inline"
                                                 data-callback="onSubmit"
                                                 data-size="invisible"
                                                 style="position: relative; float:right"
                                            ></div>


                                        </div>
                                    </div>
                                </form>

                            </div>
                        <?php else: ?>
                            <div class="side-center contact_html">
                                <?= $page->thank_you_message()->kirbytext() ?>
                            </div>
                        <?php endif; ?>



                    </div>
                </div>


                <div class="article-02__col-2">
                    <div class="article-02__box">
                        <?php snippet('shared/share-sidebar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script   src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    <script   src="https://cdn.jsdelivr.net/npm/vee-validate@2.1.0-beta.9/dist/vee-validate.min.js"></script>
    <script   src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1/dist/vue-resource.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php if($hasSucces === false): ?>
    <script>


        var config = {
            errorBagName: 'errors',
            fieldsBagName: 'fields',
            delay: 0,
            dictionary: null,
            strict: true,
            classes: false,
            classNames: {
                touched: 'touched',
                untouched: 'untouched',
                valid: 'valid',
                invalid: 'invalid',
                pristine: 'pristine',
                dirty: 'dirty'
            },
            events: 'submit|blur',
            inject: true,
            validity: true,
            aria: false
        };
        Vue.use(VeeValidate, config);

        new Vue({
            el: '#contact-form',
            data: {
                formData: {
                    fullName: '<?= $data["fullName"] ?>',
                    phone: '<?= $data["phone"] ?>',
                    woonplaats: '<?= $data["woonplaats"] ?>',
                    lead: '<?= $data["lead"] ?>',
                    message: '<?= $data["message"] ?>',
                    filefield: '',
                    email: '<?= $data["email"] ?>'
                }

            },
            methods: {
                onSubmit: function (event) {
                    //console.log(" onSubmit ");
                },
                onValidate: function (event) {
                    app = this;

                    //console.log(" onValidate ");
                    app.$validator.validateAll().then(function (response) {
                        if(response) {
                            grecaptcha.execute();

                        } else {
                            event.preventDefault();
                            console.log('Errors: correct them!');
                        }
                    });

                }
            }
        });
    </script>
<?php endif; ?>
<?php
  $messages = array(
      'fullName' => '',
      'phone' => '',
      'email' => '',
      'reaction' => ''
  );

  $hasSucces = a::get($alert, 'succes');

?>
<section class="lane lane-contact">
      <div class="container-fluid">

          <div class="f-main">
              <div class="f-01  ">

                  <?php if ($hasSucces === false): ?>
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
                          <form id="contact-form" v-on:submit="onSubmit" action="<?= $page->url() ?>" method="POST"
                                class="form-01__post" novalidate>
                              <div class="row">
                                  <div class="col-xs-12">
                                      <h2 class="content__sub">  <?= $page->intro_title()->text() ?></h2>
                                      <?= $page->intro_desc()->kirbytext() ?>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-xs-12 col-sm-6">
                                      <label for="js-name"><?= l::get('contact_name') ?></label>
                                      <input id="js-name"
                                             type="text"
                                             class="form-01__control"
                                             name="fullName"
                                             v-model="formData.fullName"
                                             v-validate="'required'">
                                      <div class="validation-flag has-arrow-top"
                                           v-show="fields.fullName
                                                  && fields.fullName.invalid
                                                  && fields.fullName.validated">
                                          {{ errors.first('fullName') }}
                                      </div>
                                  </div>

                                  <div class="col-xs-12 col-sm-6">
                                      <label for="js-phone"><?= l::get('contact_phone') ?></label>
                                      <input id="js-phone"
                                             class="form-01__control"
                                             type="text"
                                             name="phone"
                                             placeholder="06-"
                                             v-model="formData.phone"
                                      >
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-xs-12 col-sm-6">
                                      <label for="js-email"><?= l::get('contact_email') ?></label>
                                      <input id="js-email"
                                             class="form-01__control"
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
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-xs-12">
                                      <label for="js-message"><?= l::get('contact_message') ?></label>
                                      <textarea id="js-message"
                                                class="message"
                                                name="message"
                                                v-model="formData.message"
                                                v-validate="'required'"></textarea>
                                      <div class="validation-flag has-arrow-top"
                                           v-show="fields.message
                                              && fields.message.invalid
                                              && fields.message.validated">
                                          {{ errors.first('message') }}
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-xs-12" style="position: relative;">

                                      <div id='recaptcha'
                                           class="g-recaptcha"
                                           data-sitekey="6Lc9wHwUAAAAAB9d0OG7XRShJt9TucIYFQpCLo4q"
                                           data-callback="onSubmit"
                                           data-size="invisible"
                                           style="position: relative;"
                                      ></div>


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
                          </form>

                      </div>
                  <?php else: ?>
                      <div class="side-center contact_html">
                          <?= $page->thank_you_message()->kirbytext() ?>
                      </div>
                  <?php endif; ?>


              </div>
              <div class="f-02">
                  <h2 class="side__title">Adres</h2>
                  <address class="">
                      <p>De Reinigingsdokter<br>
                          Laan der verenigde naties 40<br>
                          3314DA Dordrecht<br>
                          E:Info@reinigingsdokter.nl</p>
                  </address>

                  <?php snippet('shared/block-why') ?>

              </div>
          </div>

      </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vee-validate@2.1.0-beta.9/dist/vee-validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1/dist/vue-resource.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                fullName: '',
                phone: '',
                message: '',
                email: ''
            }

        },
        methods: {
            onSubmit: function (event) {
              console.log(" onSubmit ");
            },
            onValidate: function (event) {
                app = this;

                console.log(" onValidate ");
                app.$validator.validateAll().then(function (response) {
                    if (response) {
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
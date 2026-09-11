<div class="js-bind-bg header-bg"></div>
<header class="header js-toggle-menu">
    <div class="header-row">
        <div class="header-col">
            <div class="header-brand">
                <div class="header-brand__name">
                    <a href="<?= $site->language()->url() ?>" class="header-brand__logo" style="display: inline-block; vertical-align: middle;">
                        <img src="<?= url('assets/logo/Gemini_Generated_Image_e5gvwve5gvwve5gv-removebg-preview.png') ?>" 
                             alt="<?= $site->title()->html() ?>" 
                             class="header-logo" 
                             style="max-height: 120px; width: auto; max-width: 100%; display: block; mix-blend-mode: multiply;">
                    </a>
                </div>
            </div>
            
            <a class="header-col__phone" href="tel:06-47249157" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                <svg class="svg__call" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 58 58" width="24" style="fill: currentColor;">
                    <g class="g__call" fill-rule="nonzero">
                        <path d="M24.017 33.983c-5.536-5.536-6.786-11.072-7.068-13.29a1.988 1.988 0 01.571-1.664L22 14.551a2 2 0 00.282-2.475L15.149 1a2 2 0 00-2.591-.729L1.107 5.664a1.989 1.989 0 00-1.1 1.987c.6 5.7 3.085 19.712 16.855 33.483s27.78 16.255 33.483 16.855a1.989 1.989 0 001.987-1.1l5.393-11.451A2 2 0 0057 42.851L45.924 35.72a2 2 0 00-2.475.28l-4.478 4.48c-.436.439-1.05.65-1.664.571-2.218-.282-7.754-1.532-13.29-7.068z"/>
                        <path d="M46 31a2 2 0 01-2-2c-.01-8.28-6.72-14.99-15-15a2 2 0 110-4c10.489.012 18.988 8.511 19 19a2 2 0 01-2 2z"/>
                        <path d="M56 31a2 2 0 01-2-2C53.985 15.2 42.8 4.015 29 4a2 2 0 110-4c16.009.018 28.982 12.991 29 29a2 2 0 01-2 2z"/>
                    </g>
                </svg>
                <span>06-47249157</span>
            </a>
        </div>
    </div>
    
    <div class="header-row">
        <div class="header-col">
            <button class="button-menu js-bind-toggle">
                <span class="button-menu-label is-menu"><?= $site->globel_menu()->text() ?></span>
                <span class="button-menu-label is-close "><?= $site->globel_close()->text() ?></span>

                <span class="menu__hamburger">
                  <span class="menu__hamburger-item menu__hamburger-item--hamburger-top"></span>
                  <span class="menu__hamburger-item menu__hamburger-item--cross-top"></span>
                  <span class="menu__hamburger-item menu__hamburger-item--cross-bottom"></span>
                  <span class="menu__hamburger-item menu__hamburger-item--hamburger-bottom"></span>
                </span>
            </button>
            <a class="header-col__phone_2" href="tel:06-47249157" target="_blank">bel: 06-47249157</a>
            <?php snippet('base/nav') ?>
        </div>
    </div>
</header>
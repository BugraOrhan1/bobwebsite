<?php

/* test server or live server changes */
c::set('debug', true);
c::set('ssl', false);
c::set('google-analytics', '');
c::set('plugin.html.minifier.active', false);
c::set('plugin.html.minifier.options', []);
c::set('plugin.html.minifier.blacklist', ['sitemap.xml', 'sitemap']);

c::set('languages', array(
    array(
        'default' => true,
        'code'    => 'nl',
        'name'    => 'Nederlands',
        'locale'  => 'nl_NL',
        'url'     => '/'
    )
));
c::set('language.detect', false);

c::set('timezone', 'Europe/Amsterdam');
c::set('setlocale', 'nl_NL.UTF8');
c::set('config-name', 'config ');
c::set('panel.favicon', 'assets/img/favicon-panel-favicon.ico');

c::set('roles', [
    [
        'id'      => 'admin',
        'name'    => 'Admin',
        'default' => true,
        'panel'   => true
    ],
    [
        'id'          => 'editor',
        'name'        => 'Editor',
        'panel'       => true,
        'permissions' => [
            '*'                    => true,
            'panel.widget.site'    => false,
            'panel.widget.account' => false,
            'panel.user.update'    => false,
            'panel.user.delete'    => false,
            'panel.page.url'       => false,
            'panel.access.users'   => false,
            'panel.access.options' => false,
        ],
    ]
]);

c::set('email.test-name', 'Ronald Wesselink');
c::set('email.test-email', 'ronaldeind@gmail.com');
c::set('email.to-name', 'RONALD');
c::set('email.to-email', 'ronaldeind@gmail.com');
c::set('email.subject', 'Message from: ');
c::set('uniform.language', 'en');
c::set('cache.ignore', array(
    'contact'
));

c::set('panel.install', true);

c::set('markdown.extra', true);
c::set('simplemde.excludeModules', false);
c::set('simplemde.kirbytagHighlighting', false);
c::set('simplemde.replaceTextarea', true);
c::set('simplemde.buttons', array(
    "h2",
    "h3",
    "unordered-list",
    "ordered-list",
    "pagelink",
    "email",
    "link",
    "bold",
    "link",
    "email",
    "quote",
    "code",
    "horizontal-rule",
));

c::set('thumbs.presets', [
    'default'    => ['width' => 300, 'quality' => 80],
    'small-menu' => ['width' => 300, 'height' => 180, 'quality' => 100, 'crop' => true],
]);

c::set('plugin.installer.username', 'Wesselink');
c::set('plugin.installer.panel.uri', 'panel');

c::set('focus.field.key', 'betterfocuskey');
c::set('focus.field.fullwidth', true);

/* =========================================================================
   SMTP INSTELLINGEN VOOR E-MAIL (PAS HIER JE GEGEVENS AAN)
   ========================================================================= */
c::set('email.service', 'smtp');
c::set('email.service.host', 'info@reinigingsdokter.nl'); // Je SMTP server (bijv. mail.reinigingsdokter.nl of smtp.mijnhosting.nl)
c::set('email.service.port', 25);                        // Gebruik 587 (TLS) of 465 (SSL)
c::set('email.service.security', false);                   // Geen SSL/TLS encryptie gebruiken
c::set('email.service.auth', true);
c::set('email.service.username', 'info@reinigingsdokter.nl');
c::set('email.service.password', 'Havikstraat124!'); // Het e-mailwachtwoord
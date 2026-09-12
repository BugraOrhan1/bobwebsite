<?php
/**
 * Mini view-engine.
 */

function view(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    include APP_DIR . '/views/' . $name . '.php';
}

/**
 * Render een pagina binnen de basis-layout.
 * $ctx bevat: pageView, vars, meta_title, meta_description, canonical, bodyClass, scripts
 */
function render_page(array $ctx): void
{
    view('layout', ['ctx' => $ctx]);
}

/** Bouw standaard meta-context voor een pagina */
function make_ctx(string $pageView, array $vars, ?string $metaTitle, ?string $metaDesc, string $canonical, string $bodyClass = 'body__page', array $scripts = []): array
{
    return [
        'pageView' => $pageView,
        'vars' => $vars,
        'meta_title' => $metaTitle !== null && $metaTitle !== '' ? $metaTitle : setting('site_title', 'De Reinigingsdokter'),
        'meta_description' => $metaDesc !== null && $metaDesc !== '' ? $metaDesc : setting('site_description', ''),
        'canonical' => $canonical,
        'bodyClass' => $bodyClass,
        'scripts' => $scripts,
    ];
}

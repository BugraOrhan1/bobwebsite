<?php /** @var array $ctx */ ?>
<script>
window.__RDS_ADS_ID__ = <?= json_encode(setting('ads_id', '')) ?>;
window.__RDS_ADS_WA_LABEL__ = <?= json_encode(setting('ads_conversion_whatsapp', '')) ?>;
</script>
<script src="/assets/_prod/min-base-all.js?v=<?= APP_VERSION ?>"></script>
<script src="/assets/js/app.js?v=<?= APP_VERSION ?>" defer></script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v9.0&appId=784779474897380&autoLogAppEvents=1"></script>

<?php
// Breadcrumbs voor structured data
$bc = $ctx['breadcrumb_schema'] ?? null;
$title = $ctx['meta_title'];
$canonical = $ctx['canonical'];
$reviews = all_reviews();
$ratingCount = count($reviews);
?>
<script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "LocalBusiness",
"name": "<?= h(setting('site_title')) ?>",
"url": "<?= h(base_url()) ?>",
"image": "<?= h(base_url() . '/assets/logo/Gemini_Generated_Image_e5gvwve5gvwve5gv-removebg-preview.png') ?>",
"telephone": "<?= h(phone_display()) ?>",
"priceRange": "€€",
"contactPoint": {
    "@type": "ContactPoint",
    "telephone": "<?= h(phone_display()) ?>",
    "contactType": "customer service",
    "areaServed": ["NL", "BE"],
    "availableLanguage": "nl"
},
"address": {
  "@type": "PostalAddress",
  "streetAddress": "<?= h(setting('address_street')) ?>",
  "postalCode": "<?= h(setting('address_zip')) ?>",
  "addressLocality": "<?= h(setting('address_city')) ?>",
  "addressRegion": "<?= h(setting('address_region')) ?>",
  "addressCountry": "NL"
},
"sameAs": [
    "<?= h(setting('facebook')) ?>",
    "<?= h(setting('instagram')) ?>"
],
"aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "9.6",
    "bestRating": "10",
    "reviewCount": "<?= $ratingCount ?>"
},
"@graph": [
    {
        "@type": "WebSite",
        "@id": "<?= h(base_url()) ?>/#website",
        "url": "<?= h(base_url()) ?>/",
        "name": "<?= h(setting('site_title')) ?>",
        "description": "<?= h(setting('site_description')) ?>",
        "inLanguage": "nl",
        "sameAs": [
            "<?= h(setting('facebook')) ?>"
        ]
    },
    {
      "@type": "WebPage",
      "@id": "<?= h($canonical) ?>#webpage",
      "url": "<?= h($canonical) ?>",
      "name": "<?= h($title) ?>",
      "description": "<?= h($ctx['meta_description']) ?>",
      "isPartOf": { "@id": "<?= h(base_url()) ?>/#website" },
      "inLanguage": "nl",
      "potentialAction": [ { "@type": "ReadAction", "target": [ "<?= h($canonical) ?>" ] } ]
    }<?php if ($bc && count($bc) > 1): ?>,
    {
    "@type": "BreadcrumbList",
    "@id": "<?= h($canonical) ?>#breadcrumb",
    "itemListElement": [
        <?php foreach ($bc as $i => $crumb): ?>
        {
        "@type": "ListItem",
        "position": <?= $i + 1 ?>,
        "item": {
            "@type": "WebPage",
            "url": "<?= h($crumb['url']) ?>",
            "name": "<?= h($crumb['title']) ?>"
            }
        }<?= $i < count($bc) - 1 ? ',' : '' ?>
        <?php endforeach; ?>
    ]
    }
    <?php endif; ?>
    <?php
    $schemaFaqs = db()->query('SELECT question, answer FROM faqs WHERE active = 1 ORDER BY sort ASC, id ASC')->fetchAll();
    ?>
    <?php if ($schemaFaqs && in_array($ctx['pageView'], ['home', 'service', 'city'], true)): ?>,
    {
    "@type": "FAQPage",
    "@id": "<?= h($canonical) ?>#faq",
    "mainEntity": [
        <?php foreach ($schemaFaqs as $i => $sf): ?>
        {
            "@type": "Question",
            "name": "<?= h($sf['question']) ?>",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "<?= h(strip_tags($sf['answer'])) ?>"
            }
        }<?= $i < count($schemaFaqs) - 1 ? ',' : '' ?>
        <?php endforeach; ?>
    ]
    }
    <?php endif; ?>
]
}
</script>

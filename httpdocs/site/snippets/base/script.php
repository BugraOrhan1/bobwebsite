<?php
$version = site()->version();
$env = c::get('env');
?>
<?php if($env== "prod"): ?>
    <?= js('/assets/_prod/min-base-all.js?v=' . $version) ?>
<?php elseif($env == "test" ): ?>
    <?= js('/assets/_dev/min-base-all.js?v=' . $version) ?>
<?php else: ?>
    <script async defer crossorigin="anonymous" src="/assets/_con/base-all.js?v=<?= $version?> " nonce="cCPnSo12"></script>
<?php endif ?>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v9.0&appId=784779474897380&autoLogAppEvents=1" nonce="cCPnSo12"></script>

<?php
$title = '';
if(isset($isMeta) && $isMeta  == 'override') {
    $title = $page->parent()->title() . ' in ' . $page->title()->text() . ' en omgeving - ' . $site->name();
} else {
    $title =  $page->meta_title()->isNotEmpty()? $page->meta_title() :$site->title();
    $title =  $title . ' - ' . $site->name();
}

$meta_description = $page->meta_description()->isNotEmpty() ? $page->meta_description() : $site->description();
$description = isset($isMeta) && $isMeta  == 'override'
    ? $page->parent()->title() . ' in ' . $page->title()->text() . ' en omgeving - ' . $site->name() . $meta_description
    : $meta_description;

$published_date = $page->published();
$modified_date = date( "Y-m-d" , (int)$page->modified() )  ;
?>
<script type="application/ld+json" class="schema-graph">
{
"@context": "https://schema.org",
"@type": "Organization",
"name": "<?= $site->name() ?>",
"url": "<?= $site->url() ?>",
"contactPoint": {
    "@type": "ContactPoint",
    "telephone": "06-47249157",
    "contactType": "customer service"
},
"address" : {
  "addressLocality" : "Laan der verenigde naties 40",
  "streetAddress" : "Laan der verenigde naties 40, 3314DA Dordrecht, Nederland",
  "addressCountry" : "Nederland",
  "@type" : "PostalAddress",
  "postalCode" : "3314DA",
  "addressRegion" : "Zuid-Holland"
},
"@graph": [
    {
        "@type": "WebSite",
        "@id": "<?= $site->url() ?>/#website",
        "url": "<?= $site->url() ?>/",
        "name": "<?= $site->name() ?>",
        "description": "<?= $site->description() ?>",
        "inLanguage": "nl",
        "sameAs": [
            "https://www.facebook.com/Dereinigingsdokter"
        ]
    },
    <?php if($page->isHomePage() ): ?>

    {
    "@type": "ImageObject",
    "@id": "https://www.reinigingsdokter.nl/stoffen-bank-reinigen/#primaryimage",
    "inLanguage": "nl",
    "url" : "<?= url('/assets/img/voorbeeld/De-Reinigingsdokter-schoon-gevoel-web.jpg') ?>"
    },
    <?php endif ?>
    {
      "@type": "WebPage",
      "@id": "<?= $page->url()?>/#webpage",
      "url": "<?= $page->url()?>/",
      "name": "<?= $title ?>",
      "datePublished": "<?= $published_date ?>",
      "dateModified": "<?= $modified_date ?>",
      "description": "<?= $description ?>",

      <?php if(!$page->isHomePage() ): ?>
      "breadcrumb": {
        "@id": "<?= $page->url()?>/#breadcrumb"
      },
      <?php endif ?>
      "inLanguage": "nl",
      "potentialAction": [ { "@type": "ReadAction", "target": [ "<?= $page->url()?>/" ] } ]
    }
    <?php if(!$page->isHomePage() ): ?>
    ,
    <?php if(is_a( $site->breadcrumb(), 'Children' ) ): ?>
    {
    "@type": "BreadcrumbList",
    "@id": "<?= $page->url()?>/#breadcrumb",
    "itemListElement": [
        <?php foreach($site->breadcrumb() as $crumb): ?>
        <?php
        $size = size($site->breadcrumb());
        $index = $site->breadcrumb()->indexOf($crumb) + 1;
        ?>
        {
        "@type": "ListItem",
        "position": <?= $index ?>,
        "item": {
            "@type": "WebPage",
            "@id": "<?= $crumb->url() ?>",
            "url": "<?= $crumb->url() ?>",
            "name": "<?= html($crumb->title()) ?>"
            }
        }
        <?php if($index != $size ): ?>
        ,
        <?php endif ?>
        <?php endforeach ?>
    ]
    }
    <?php endif ?>
    <?php endif ?>
]
}
</script>



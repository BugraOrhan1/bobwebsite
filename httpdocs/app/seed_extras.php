<?php
/**
 * Idempotente uitbreidingen (v2-modernisering):
 * - FAQ's (als tabel leeg is)
 * - Privacy- en cookiepagina's (als ze niet bestaan)
 * - KvK-instelling
 * Apart aanroepbaar:  php app/seed_extras.php
 */

if (!defined('DATA_DIR')) {
    if (PHP_SAPI !== 'cli') return; // via web: alleen als expliciet vereist
    require __DIR__ . '/config.php';
    require __DIR__ . '/helpers.php';
    require __DIR__ . '/db.php';
    require __DIR__ . '/content.php';
}

$pdo = db();

/* ---------- FAQ's ---------- */
$count = (int)$pdo->query('SELECT COUNT(*) FROM faqs')->fetchColumn();
if ($count === 0) {
    $faqs = [
        ['Hoe lang moet mijn bank drogen na het reinigen?',
            "Gemiddeld 8 tot 12 uur, afhankelijk van de stofsoort, temperatuur en luchtvochtigheid. Wij reinigen met zo weinig mogelijk vocht en geven tips om het drogen te versnellen, zoals goed ventileren."],
        ['Is de reiniging veilig voor kinderen en huisdieren?',
            "Ja. Wij werken 100% milieuvriendelijk en zonder agressieve chemicaliën. Zodra uw meubel droog is, kunnen kinderen en huisdieren er gewoon weer op."],
        ['Gaan alle vlekken eruit?',
            "Wij geven vooraf eerlijk advies over wat er wel en niet uit kan. De meeste vlekken en geurtjes verwijderen wij volledig; bij sommige oude of verkleurde vlekken blijft een lichte waas zichtbaar."],
        ['Wat kost het reinigen van mijn bank?',
            "Een tweezitsbank reinigen wij vanaf € 39 en een driezitsbank vanaf € 49. Stuur een foto via WhatsApp of het contactformulier, dan ontvangt u binnen 2 uur een exacte prijs."],
        ['Moet ik mijn meubels ergens heen brengen?',
            "Nee, juist niet! Wij reinigen op locatie: bij u thuis of op kantoor. Geen gesleep met meubels en u kunt direct zien hoe schoon het resultaat is."],
        ['Hoelang duurt een reiniging?',
            "Een gemiddelde bank is in ongeveer 1 tot 1,5 uur gereinigd. Grotere combinaties of meerdere meubels kunnen iets langer duren."],
        ['Werken jullie ook in het weekend of in de avonduren?',
            "Afspraken zijn mogelijk van maandag tot en met zaterdag. Stuur een WhatsApp-bericht, dan plannen wij samen een moment dat u thuis bent."],
        ['Verwijderen jullie ook nare geurtjes zoals huisdier-urine?',
            "Ja, wij zijn gespecialiseerd in geurverwijdering. Door dieptereiniging verdwijnen bacteriën die de geur veroorzaken — meestal volledig."],
    ];
    $st = $pdo->prepare('INSERT INTO faqs (question, answer, active, sort) VALUES (?,?,1,?)');
    $i = 0;
    foreach ($faqs as $f) $st->execute([$f[0], $f[1], $i++]);
    echo "FAQ's geplaatst: " . count($faqs) . "\n";
}

/* ---------- Privacy- en cookiepagina ---------- */
function ensure_page(string $slug, string $template, string $title, array $fields): void
{
    $st = db()->prepare('SELECT id FROM pages WHERE slug = ?');
    $st->execute([$slug]);
    if ($st->fetch()) return;

    db()->prepare('INSERT INTO pages (slug, template, title, in_menu, sort, active, updated_at) VALUES (?,?,?,?,0,1,datetime("now"))')
        ->execute([$slug, $template, $title, 90]);
    $id = (int)db()->lastInsertId();
    foreach ($fields as $k => $v) page_save_field($id, $k, $v);
}

$privacyHtml = <<<'HTML'
<p><strong>De Reinigingsdokter</strong> vindt uw privacy belangrijk. In deze verklaring leest u welke gegevens wij verwerken en waarom.</p>
<h2>Welke gegevens verzamelen wij?</h2>
<ul>
<li><strong>Contactgegevens</strong> — naam, telefoonnummer, e-mailadres en woonplaats wanneer u het contactformulier invult of ons belt/app. Deze gebruiken wij uitsluitend om uw aanvraag te behandelen en een offerte te geven.</li>
<li><strong>Bijlagen</strong> — foto's die u meestuurt om een prijs te kunnen maken.</li>
<li><strong>Bezoekgegevens</strong> — anonieme statistieken (zoals aantal bezoekers en bezochte pagina's) via Google Analytics, alleen nadat u hiervoor toestemming hebt gegeven via de cookie-melding.</li>
</ul>
<h2>Waarom verwerken wij deze gegevens?</h2>
<p>Wij verwerken uw gegevens om uw aanvraag te beantwoorden, een prijsopgave te maken, afspraken in te plannen en onze dienst te leveren (uitvoering van een overeenkomst). Bezoekstatistieken gebruiken wij om onze website en advertenties te verbeteren (gerechtvaardigd belang / toestemming).</p>
<h2>Bewaartermijn</h2>
<p>Contactgegevens bewaren wij niet langer dan nodig is voor onze administratie, maximaal conform de wettelijke bewaarplicht (7 jaar voor factuurgegevens).</p>
<h2>Delen wij gegevens met anderen?</h2>
<p>Nee, wij verkopen uw gegevens nooit. Wij delen gegevens alleen met partijen die nodig zijn voor onze dienstverlening (bijv. onze boekhouding) of wanneer de wet dat verplicht.</p>
<h2>Cookies</h2>
<p>Onze website gebruikt alleen functionele cookies en — met uw toestemming — cookies voor statistieken en advertenties (Google Analytics / Google Ads). U kunt uw keuze altijd aanpassen door de cookies van deze website te wissen.</p>
<h2>Uw rechten</h2>
<p>U heeft recht op inzage, verbetering en verwijdering van uw gegevens. Mail hiervoor naar {EMAIL}. U kunt ook een klacht indienen bij de Autoriteit Persoonsgegevens.</p>
<p><em>Bedrijfsgegevens: {NAAM} — {ADRES}, {POSTCODE} {PLAATS}{KVK}</em></p>
HTML;

$cookieHtml = <<<'HTML'
<p>Deze website maakt gebruik van cookies. Een cookie is een klein tekstbestand dat bij uw bezoek aan deze website wordt opgeslagen en waardoor de website goed of gebruiksvriendelijker werkt.</p>
<h2>Functionele cookies</h2>
<p>Deze zijn noodzakelijk voor het werken van de website (bijv. het onthouden van uw keuze in deze melding en het beveiligen van het beheerpaneel). Hiervoor vragen wij geen toestemming.</p>
<h2>Statistiek- en advertentiecookies</h2>
<p>Met uw toestemming plaatsen wij cookies van Google Analytics en Google Ads. Hiermee meten wij hoe de website wordt gebruikt en welke advertenties tot aanvragen leiden. Zonder toestemming plaatsen wij deze cookies niet.</p>
<h2>Google</h2>
<p>Wij hebben een verwerkersovereenkomst met Google. Google kan gegevens combineren met andere Google-diensten; daarop is het privacybeleid van Google van toepassing.</p>
<h2>Toestemming intrekken</h2>
<p>U kunt cookies altijd verwijderen via de instellingen van uw browser. Verwijdert u de cookies van deze website, dan vragen wij bij een volgend bezoek opnieuw om toestemming.</p>
HTML;

$kvk = setting('kvk_number', '');
$kvkLine = $kvk !== '' ? ' — KvK: ' . $kvk : '';
$privacyHtml = str_replace(
    ['{EMAIL}', '{NAAM}', '{ADRES}', '{POSTCODE}', '{PLAATS}', '{KVK}'],
    [setting('contact_email', 'info@reinigingsdokter.nl'), setting('site_title', 'De Reinigingsdokter'),
     setting('address_street', ''), setting('address_zip', ''), setting('address_city', ''), $kvkLine],
    $privacyHtml);

ensure_page('privacy', 'legal', 'Privacyverklaring', [
    'meta_title' => 'Privacyverklaring | ' . setting('site_title'),
    'meta_description' => 'Privacy- en cookieverklaring van ' . setting('site_title'),
    'intro_title' => 'Privacyverklaring',
    'content_html' => $privacyHtml,
]);
ensure_page('cookies', 'legal', 'Cookiebeleid', [
    'meta_title' => 'Cookiebeleid | ' . setting('site_title'),
    'meta_description' => 'Welke cookies ' . setting('site_title') . ' gebruikt en waarom.',
    'intro_title' => 'Cookiebeleid',
    'content_html' => $cookieHtml,
]);
echo "Privacy- en cookiepagina aanwezig\n";

/* ---------- KvK-instelling ---------- */
$st = $pdo->prepare('SELECT COUNT(*) FROM settings WHERE key = ?');
$st->execute(['kvk_number']);
if ((int)$st->fetchColumn() === 0) setting_save('kvk_number', '');

echo "Extras klaar\n";

<?php
/**
 * Tekstgeneratie voor stadspagina's: gevarieerde, unieke inleidingen per
 * dienst × plaats zodat elke pagina eigen content heeft (belangrijk voor SEO/Ads).
 */

function city_intro_text(array $service, array $city): string
{
    $svc = $service['title'];
    $svcLower = lcfirst($service['title']);
    $plaats = $city['name'];
    $prov = $city['province'];
    $phone = phone_display();
    $variant = crc32($service['slug'] . '|' . $city['slug']) % 4;

    $teksten = [
        "<p><strong>{$svc} in {$plaats}</strong> nodig? De Reinigingsdokter komt gewoon bij u langs. Wij reinigen {$svcLower} op locatie in {$plaats} en omgeving — u hoeft zelf niets te slepen of te vervoeren. Onze specialisten werken 100% milieuvriendelijk en zorgen dat alles er weer schoon en fris uitziet.</p><p>Benieuwd wat het kost? Stuur een foto via WhatsApp of het contactformulier en u ontvangt snel een scherpe prijs. Bel <a href=\"" . phone_href() . "\">{$phone}</a> of WhatsApp ons direct.</p>",

        "<p>Woont u in {$plaats}" . ($prov && $prov !== $plaats ? " (provincie {$prov})" : '') . " en zoekt u professionele {$svcLower}? De Reinigingsdokter is actief in heel Nederland en België en komt ook graag naar {$plaats}. Geen gedoe met het meenemen van uw spullen: wij reinigen alles bij u op locatie.</p><p>Wij verwijderen vlekken, geurtjes, huisstofmijt en bacteriën. Vraag vandaag nog een vrijblijvende prijsopgave aan via WhatsApp of het contactformulier — u krijgt binnen 2 uur reactie.</p>",

        "<p>Voor {$svc} in {$plaats} bent u bij De Reinigingsdokter aan het juiste adres. Van een enkele eetkamerstoel tot een complete bankcombinatie: wij maken het weer schoon en fris, gewoon bij u thuis in {$plaats}. Onze werkwijze is milieuvriendelijk en geschikt voor zowel particuliere als zakelijke klanten.</p><p>Stuur ons een foto van wat u gereinigd wilt hebben en wij maken een duidelijke all-in prijs. Bel <a href=\"" . phone_href() . "\">{$phone}</a> of gebruik de WhatsApp-knop.</p>",

        "<p>De Reinigingsdokter verzorgt {$svc} door heel Nederland — dus ook in {$plaats}. Met onze professionele apparatuur verwijderen wij hardnekkige vlekken, nare geurtjes en onzichtbaar vuil zoals huisstofmijt en bacteriën. Dat zorgt voor een schoon gevoel, en dat is onze zorg!</p><p>Wilt u weten wat {$svcLower} in {$plaats} kost? Vul het contactformulier in of app ons een foto: u ontvangt binnen 2 uur een reactie met een scherpe prijs.</p>",
    ];

    $nearby = nearby_cities_links($service, $city, 3);
    $buurt = '';
    if (count($nearby) > 0) {
        $namen = array();
        foreach ($nearby as $n) $namen[] = $n['name'];
        $buurt = "<p>Wij zijn vanuit {$plaats} ook regelmatig actief in o.a. " . implode(', ', $namen) . ". Waar u ook woont: vraag gerust naar de mogelijkheden voor uw adres — wij plannen simpelweg een moment dat u thuis bent.</p>";
    }

    return $teksten[$variant] . $buurt;
}

/** Dichtstbijzijnde plaatsen in dezelfde provincie (voor interne links) */
function nearby_cities_links(array $service, array $city, int $max = 10): array
{
    if (empty($city['province'])) return [];
    return cities_by_province($city['province'], (int)$city['id'], $max);
}

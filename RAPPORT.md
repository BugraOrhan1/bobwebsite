# 📋 Rapport — De Reinigingsdokter: Kirby weg, nieuwe website + beheerpaneel

**Datum:** 12 september 2026 · **Branch:** `arena/01a092d7-bobwebsite`

---

## 1. Wat was de situatie?

De website `www.reinigingsdokter.nl` draaide op **Kirby v2** (een heel oud CMS uit ~2015) met:
- een ouderwets Kirby-panel, losse tekstbestanden als database,
- 8 diensten met per dienst ±130 stadspagina's,
- veel handmatig onderhoud en een traag bewerkbaar systeem.

## 2. Wat is er gedaan?

### ✅ Kirby is 100% verwijderd
De mappen `kirby/`, `kirby_12/`, `panel/`, `site/`, `content/` en `thumbs/` zijn weg.
De nieuwe site is **los PHP + SQLite**: geen framework, geen Composer, geen installatie.
Het werkt op elke standaard PHP-hosting (PHP 7.4 of nieuwer) — dus ook op **mijndomein.nl**.

### ✅ Het design is exact hetzelfde gebleven
De volledige vormgeving (CSS, lettertypes, kleuren, menu, blokken, icoontjes, logo)
is 1-op-1 overgenomen. Alle pagina's zien er hetzelfde uit:
home, diensten, dienstpagina's, stadspagina's, tarieven, reviews, contact, bedankt, portfolio en de 404-pagina.

### ✅ Controlepaneel: `/admin` (alleen admin kan inloggen)
Een compleet nieuw, gebruiksvriendelijk beheerpaneel in het Nederlands:

| Onderdeel | Wat kun je er doen? |
|---|---|
| 🏠 Dashboard | Overzicht van leads, statistieken, snelkoppelingen |
| 📥 **Leads** | Alle ingevulde formulieren inzien, inclusief bijlage, bron én **gclid** (Google Ads-koppeling) |
| 📄 Pagina's | Alle teksten, titels en SEO-teksten van vaste pagina's bewerken |
| 🧽 Diensten | Teksten, SEO en prijstabellen per dienst bewerken |
| 📍 Stadspagina's | 1.231 plaatsen aan/uit zetten, zoeken per provincie, eigen inleidingstekst per plaats |
| 💶 Prijzen | Tarieven toevoegen, wijzigen en verwijderen |
| ⭐ Reviews | Reviews toevoegen, verbergen, verwijderen, per dienst |
| 🖼️ Media | Afbeeldingen uploaden |
| ⚙️ Instellingen | Telefoonnummer, **WhatsApp-nummer + automatisch bericht**, e-mail, adres, socials, Google Analytics/Ads, voettekst |
| 🔑 Account | Wachtwoord wijzigen |

**Inloggegevens (eerste keer):**
- Gebruikersnaam: `admin`
- Wachtwoord: `Reiniging@2026!`
- ⚠️ Verander dit direct na de eerste login (er staat een waarschuwing in het dashboard).

Beveiliging: wachtwoordhashing, CSRF-bescherming op elk formulier, login-beperking
(max. 8 pogingen per 15 minuten), admin-map niet indexeerbaar, database-map afgeschermd.

### ✅ Zwevende WhatsApp-knop (nieuw)
- Groen WhatsApp-icoontje rechts in beeld dat **meescrollt** naar boven en beneden.
- Met pulserende animatie zodat het opvalt.
- Bij klik opent WhatsApp met een **automatisch vooringesteld bericht** richting jouw nummer
  (instelbaar in het admin-paneel: nummer + berichttekst).
- *Let op:* WhatsApp staat technisch niet toe dat een bericht volautomatisch verstuurd
  wordt zonder dat de klant op "verzenden" tikt — maar het bericht staat wél al volledig
  klaar. Dit is de maximaal mogelijke automatisering.
- Uit te zetten via Instellingen.

### ✅ Stadspagina's voor élke stad in Nederland (flink uitgebreid)
- **1.231 plaatsen** (alle gemeenten + bekende plaatsen, inclusief Antwerpen) × **8 diensten**
  = **9.848 unieke stadspagina's**. De oude site had er ±1.040.
- Elke pagina heeft een **eigen, unieke inleidingstekst** (4 afwisselende varianten per
  dienst/plaats-combinatie) — belangrijk voor Google.
- Nieuw: blokje "in de buurt van …" met links naar naburige plaatsen (betere interne
  linkstructuur = beter voor SEO).
- Alle pagina's staan automatisch in de sitemap.

### ✅ Klaargemaakt voor Google Ads → zoveel mogelijk leads
1. **Lead-registratie:** elk contactformulier wordt opgeslagen in het beheerpaneel
   (naam, telefoon, e-mail, woonplaats, bericht, bijlage, bron) én gemaild naar jouw adres.
2. **gclid-tracking:** de Google Ads-klik-ID wordt automatisch bij elke lead opgeslagen,
   zodat je in Google Ads precies ziet welke campagne/advertentie leads oplevert.
3. **Conversie-meting:** vul in het admin-paneel je Google Ads conversie-ID en labels in;
   de site vuurt dan automatisch een conversie af bij het contactformulier én bij
   WhatsApp-kliks.
4. **Mobiele actiebalk:** op telefoons verschijnt onderin een vaste balk met
   *Bel direct* · *WhatsApp* · *Offerte* — de drie snelste manieren om een lead te worden.
5. **Vertrouwensbadge** in de hero: "9,6 Voortreffelijk — 43 beoordelingen".
6. **Meerdere contactmomenten per pagina** (WhatsApp-knoppen bovenaan, halverwege en onderaan).
7. **Snelheid:** de site is lichter dan de Kirby-variant (minder bestanden, geen CMS-ballast,
   cache-headers, compressie) → betere laadtijd = hogere kwaliteitsscore in Google Ads.
8. **SEO-basis op orde:** unieke titels/omschrijvingen per pagina, canonical URLs,
   JSON-LD structured data (LocalBusiness + beoordelingen + kruimelpad), dynamische
   sitemap.xml met alle 9.800+ pagina's, robots.txt.
9. **Spam-bescherming** op het formulier (honeypot) zodat je geen nep-leads krijgt.
10. **WhatsApp-nummer gecorrigeerd:** de oude site gebruikte `310647249157` (dat is een
    ongeldig internationaal nummer); nu staat overal het correcte `31647249157`.

### ✅ Eigen toevoegingen
- 404-pagina in de huisstijl.
- Klant krijgt automatisch een bevestigingsmail na het invullen van het formulier.
- Bijlagen (foto's van de bank e.d.) tot 8 MB mogelijk op het formulier — de klant kan dus
  direct een foto meesturen voor een snelle prijsopgave.
- Foutlogbestand (`data/php-error.log`) voor probleemopsporing, niet openbaar.

---

## 3. Hoe werkt het technisch?

| Onderdeel | Oplossing |
|---|---|
| Taal | Puur PHP (7.4+), geen dependencies |
| Database | SQLite (`data/site.sqlite`) — geen MySQL-configuratie nodig |
| Router | Eén `index.php` + `.htaccess` |
| Content | Alles in de database, bewerkbaar via `/admin` |
| Oude URL's | **Blijven exact hetzelfde** (`/reinigen/bank-reinigen/amsterdam`) → geen SEO-verlies |

### Bestandenstructuur
```
httpdocs/
├── index.php          ← frontcontroller (alle pagina's)
├── .htaccess          ← routing + beveiliging + caching
├── admin/             ← ingang beheerpaneel (/admin)
├── app/               ← kern van de site (afgeschermd)
│   ├── views/         ← alle templates
│   ├── seed.php       ← migratiescript (al gedraaid)
│   └── citydata.php   ← de 1.231 plaatsen
├── assets/            ← css/js/afbeeldingen/logo (deels origineel design)
├── media/             ← alle foto's/video's van de content
└── data/              ← SQLite-database + uploads (afgeschermd)
```

## 4. Live zetten op mijndomein.nl

1. Log in op het controlepaneel van mijndomein.nl en ga naar je hostingpakket
   (of gebruik FTP met bijv. FileZilla).
2. Ga naar de map **`httpdocs`** (of `public_html`).
3. Verwijder daar de oude Kirby-bestanden (of hernoem de map eerst als back-up).
4. Upload de **nieuwe `httpdocs`-map** uit deze repository (alles: `index.php`,
   `.htaccess`, `admin/`, `app/`, `assets/`, `media/`, `data/`).
5. Klaar! Bezoek `https://mijndomein.nl` en `https://mijndomein.nl/admin`.
6. Ga naar **Instellingen** in het admin-paneel en:
   - zet je e-mailadres goed (waar de leads naartoe moeten),
   - vul eventueel `base_url` in met `https://mijndomein.nl`,
   - vul je Google Ads/Analytics-gegevens in.
7. Controleer of e-mail werkt: vul zelf één keer het contactformulier in.
   *(Werkt de mail niet? Maak dan bij mijndomein.nl een e-mailadres aan dat
   overeenkomt met het domein, of vraag hun support om SMTP-gegevens.)*

> Vereisten: PHP 7.4 of hoger met `pdo_sqlite` (standaard aanwezig op vrijwel alle
> Nederlandse hostingpakketten, ook mijndomein.nl).

## 5. Nog te doen / advies

- [ ] Wachtwoord van `admin` veranderen na de eerste login.
- [ ] E-mailadres bij Instellingen controleren (liefst `info@mijndomein.nl`).
- [ ] In Google Ads: conversies aanmaken en de labels invullen in het admin-paneel.
- [ ] Google Search Console: dien de sitemap in (`https://mijndomein.nl/sitemap.xml`).
- [ ] Oude domein `reinigingsdokter.nl` → laat die doorsturen (301) naar het nieuwe domein
      als je dat domein houdt, zodat je bestaande Google-posities meeverhuizen.
- [ ] Oude SMTP-wachtwoorden die in de Kirby-config stonden zijn **niet** overgenomen en
      horen niet in code — draai voor de zekerheid dat e-mailwachtwoord om.

---

## 6. UPDATE v2 — Modernisering (na overleg)

De structuur en herkenbaarheid zijn hetzelfde gebleven, maar het uiterlijk is opgepoetst
en er ontbrak belangrijke (deels wettelijk verplichte) informatie. Wat er is toegevoegd:

### Design
- **Modern lettertype (Inter)** in plaats van kale Helvetica, met strakkere koppen.
- **Hero met echte foto** + donkerblauwe overlay en witte tekst — de site oogt nu direct professioneel.
- **Interactieve voor/na-slider** (sleep om het verschil te zien) op de home en op alle
  dienst- en stadspagina's — hét verkoopargument van een reinigingsbedrijf.
- **Review-sterren (★★★★★)** bij elke beoordeling voor directe vertrouwensweergave.
- **USP-rij met iconen** onder de hero (aan huis, milieuvriendelijk, reactie binnen 2 uur, eerlijk advies).
- **Modernere knoppen** met ronde hoeken, schaduw en hover-effect.

### Ontbrekende informatie toegevoegd
- **Privacyverklaring** (`/privacy`) — wettelijk verplicht (AVG) bij formulier + analytics.
- **Cookiebeleid** (`/cookies`) + **cookie-toestemmingsbalk**: Google Analytics/Ads wordt
  alléén geladen nadat de bezoeker akkoord gaat (AVG-proof).
- **KvK-nummer** instelbaar via Instellingen → verschijnt in footer én privacyverklaring.
- **FAQ-sectie** op de home (8 standaardvragen, bewerkbaar via **❓ FAQ's** in het admin-paneel),
  inclusief **FAQPage-schema** voor Google rich results (uitklapbare vragen in zoekresultaten).

### Beheer
- Nieuw admin-onderdeel **❓ FAQ's**: vragen toevoegen, bewerken, verbergen, verwijderen.
- Instellingen: veld **KvK-nummer** toegevoegd.

*Testen: zie TESTEN.md. In de preview zie je onderaan de cookie-melding; na "Accepteren"
wordt Google Analytics pas actief.*

## 7. UPDATE v3 — Portfolio, foutfixes en extra leadfuncties

### Portfolio-pagina (`/portfolio`)
- Nieuwe pagina **"Portfolio van onze werkzaamheden"** met uw eigen introductietekst
  (exact overgenomen zoals aangeleverd) en een modern raster van **voor/na-paren**.
- Gestart met **8 paren**: 5 door AI gegenereerd (hoekbank, fauteuil, eetkamerstoelen,
  leren bank, matras — steeds exact dezelfde scène, vóór en ná de reiniging) en 3 echte
  foto's uit de oude site (bankstel, fauteuil, tapijt).
- Onderaan een conversieblok: *"Ook zo'n schoon resultaat?"* met bel- en
  WhatsApp-knop — de portfolio werkt dus direct als verkoopargument.
- De pagina staat **in het hoofdmenu** en in de sitemap, en op de home staat onder
  "Onze voorbeelden" een nieuwe knop: *"📸 Bekijk meer voor- en nafoto's in ons portfolio"*.

### Beheer → 📸 Portfolio
- Nieuw admin-onderdeel om voor/na-paren te **toevoegen, bewerken, verbergen,
  verwijderen en van volgorde te wisselen** (piltjes ↑/↓).
- Foto's kiest u uit een lijst met voorbeelden per map; live-voorbeeld van de gekozen
  foto. Nieuwe foto's uploaden kan via **🖼️ Media** (map "portfolio").
- Tip: zodra uw eigen voor/na-foto's beschikbaar zijn, gewoon via Media uploaden en in
  deze sectie aan een paar koppelen — de AI-foto's kunt u dan verbergen of verwijderen.

### Foutfixes
- **Zwevende WhatsApp-knop** goed gezet: pictogram strak rechtsonder, puls-ring exact om
  het pictogram, tekstballon alléén bij muis-aanraking als tooltip links ervan. Op mobiel
  zit de knop nú boven de mobiele bel/WhatsApp-balk (niet er overheen).
- Databasefout opgelost die ontstaan was bij het voorbereiden van de portfolio-tabel
  (site bleef hierdoor even 500-fouten geven; nu verholpen en getest).

### Extra leadgeneratie
- **Contextueel vooringevuld WhatsApp-bericht**: op een dienstpagina staat nu bijv.
  *"Hallo, ik wil graag Bankreiniging aanvragen…"*, en op stadspagina's
  *"Hallo, ik wil graag Bankreiniging in Amsterdam aanvragen…"* — de bezoeker hoeft
  alleen nog op verzenden te drukken. Dit geldt voor de zwevende knop, de mobiele balk
  én de groene WhatsApp-knoppen. Zo ontvangt u direct de juiste dienst + plaats.

### Getest (controle-ronde zoals een bezoeker)
- Alle menupagina's, 8 dienstpagina's, steekproef stadspagina's, portfolio, tarieven,
  contact, privacy en cookies: **geen PHP-meldingen, geen dode links/afbeeldingen**.
- Alle 16 portfolio-foto's laden (HTTP 200); sitemap bevat /portfolio; admin-getest
  (login, overzicht, bewerk-scherm met fotolijst).

## 8. UPDATE v4 — Fotovernieuwing en design-polish ("maak alles mooier")

Op verzoek: álle oude foto's (2017) vervangen door moderne, professionele beelden
en de zichtbare vormfouten opgelost. U heeft hiervoor volledig vrije hand gegeven.

### Nieuwe foto's overal
- **Hero home**: nieuwe professionele foto (reiniger in navy polo met extractiemachine
  bij een licht bankstel in een zonnige woonkamer).
- **Alle dienst- en stadspagina's**: nieuwe voor/na-sliders voor bank, meubels, matras,
  auto-interieur, tapijt, gevel, zonnepanelen en kantoorpanden — steeds dezelfde scène
  vóór en ná, dus een eerlijk en mooi "wow"-effect.
- **Home "Onze voorbeelden"**: nieuwe slider + drie moderne voorbeeldfoto's.
- Originele 2017-foto's blijven bewaard in de git-historie; de site toont overal de nieuwe.

### Vormfouten opgelost
- **WhatsApp-knop**: nu waterdicht gepositioneerd (bol strak rechts, puls-ring exact om
  de bol, tooltip links). Oorzaak van de vorige fout: de browser cachede oude CSS —
  de versie is verhoogd naar 3.0.0 zodat iedereen de nieuwe stijl direct ziet.
  Horizontale scrollbalk (die door de oude puls ontstond) is opgeheven.
- **Reviews**: kaartjes modern afgewerkt (ronde hoeken, zachte schaduw, dienst-label als
  nette "chip" bovenop de kaart in plaats van afgesneden balk); rustigere achtergrondkleur.
- **Footer**: vreemde letterlijke "<br>© 2026 - 2026" uit de tekst gehaald; nette
  ©-regel toegevoegd naast Privacy/Cookies/KvK.

### Getest
- Home, portfolio, reviews, tarieven, contact en alle 8 dienstpagina's + stadspagina's:
  geen PHP-meldingen; alle sliders tonen voor/na; alle nieuwe foto's laden (HTTP 200).

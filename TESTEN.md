# 🧪 Testen zonder live domein

Je hebt 3 opties, van snelst naar meest realistisch:

---

## Optie 1 — De preview hier (snelst, nu al mogelijk)

De site draait al als **live preview** in dit project (rechts in beeld / het preview-paneel).
Test deze URL's:

| Wat | URL (achter de preview-link) |
|---|---|
| Home | `/` |
| Bankreiniging Amsterdam | `/reinigen/bank-reinigen/amsterdam` |
| Alle diensten | `/reinigen` |
| Tarieven | `/tarieven` |
| Contact + formulier | `/contact` |
| Beheerpaneel | `/admin` (inloggen: `admin` / `Reiniging@2026!`) |

> Let op: in deze preview werken e-mails niet echt (geen mailserver), maar leads
> worden wél gewoon opgeslagen — je ziet ze terug in het admin-paneel onder **Leads**.

---

## Optie 2 — Op je eigen computer (Windows of Mac)

### Windows
1. Download de code: ga op GitHub naar de repository → groene knop **Code** → **Download ZIP** → pak uit.
2. Installeer **XAMPP** (gratis): https://www.apachefriends.org/ — dit levert PHP voor Windows.
3. Open de **Opdrachtprompt** (cmd) in de map `httpdocs` van de uitgepakte code:
   - open de map in Verkenner, klik op de adresbalk, typ `cmd` en druk op Enter.
4. Start de testsite:
   ```
   C:\xampp\php\php -S localhost:8080 router-dev.php
   ```
5. Open in je browser: **http://localhost:8080**
   - Admin-paneel: http://localhost:8080/admin
6. Stoppen: druk in het cmd-venster op `Ctrl + C`.

### Mac
1. Download de ZIP van GitHub en pak uit.
2. Open **Terminal** en ga naar de map:
   ```
   cd ~/Downloads/bobwebsite-arena/httpdocs
   ```
   (pas het pad aan naar waar je het hebt uitgepakt)
3. Start de testsite:
   ```
   php -S localhost:8080 router-dev.php
   ```
4. Open in je browser: **http://localhost:8080**

> Het maakt niet uit dat de map `data/site.sqlite` al bestaat — daarin zitten alle
> teksten, prijzen, reviews en de 1.231 plaatsen al kant-en-klaar.

---

## Optie 3 — Testen op je hosting zonder je echte domein

Zodra je het pakket bij mijndomein.nl hebt, kun je vaak een **tijdelijk/test-adres**
gebruiken zonder dat je domein er al op staat:

- Veel pakketten hebben een "interne URL" of test-subdomein (bijv. `jouwpakket.mijndomein.nl`
  of een tijdelijk adres dat je in het controlepaneel van mijndomein vindt).
- Of maak later een subdomein aan zoals `test.mijndomein.nl` en zet de site dáár eerst op.

Daarna pas, als alles naar wens is, koppel je het echte domein.

---

## Wat moet je testen?

Checklist:

- [ ] Home ziet er hetzelfde uit als nu (design, menu, foto's)
- [ ] Menu werkt (ook op je telefoon: hamburger-menu)
- [ ] Diensten → klik door naar een dienst → klopt de tekst?
- [ ] Stadspagina: bijv. `/reinigen/bank-reinigen/rotterdam`
- [ ] WhatsApp-knop rechts: opent WhatsApp met jouw bericht klaar
- [ ] Mobiel: balk onderin met Bel / WhatsApp / Offerte
- [ ] Contactformulier invullen → bedankt-pagina → lead zichtbaar in `/admin` → **Leads**
- [ ] Admin: wijzig een prijs of tekst → zie het direct terug op de site
- [ ] Tarieven, reviews en contactpagina

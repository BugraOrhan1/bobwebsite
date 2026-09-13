<?php view('admin/_header'); ?>

<h1 class="admin-h1">Instellingen</h1>
<p class="admin-sub">Alles wat over de hele site terugkomt: contactgegevens, WhatsApp, e-mail en Google Ads/Analytics.</p>

<form method="post" class="admin-form">
    <?= csrf_field() ?>

    <div class="admin-panel">
        <h2>🏢 Bedrijfsgegevens</h2>
        <label>Naam van de website</label>
        <input type="text" name="site_title" value="<?= h($settings['site_title'] ?? '') ?>">
        <label>Omschrijving (standaard voor Google)</label>
        <textarea name="site_description" rows="3"><?= h($settings['site_description'] ?? '') ?></textarea>
        <label>Slogan</label>
        <input type="text" name="slogan" value="<?= h($settings['slogan'] ?? '') ?>">
        <label>Adres</label>
        <input type="text" name="address_street" value="<?= h($settings['address_street'] ?? '') ?>">
        <label>KvK-nummer <small>(verplicht te vermelden op een zakelijke website; verschijnt in de footer + privacyverklaring)</small></label>
        <input type="text" name="kvk_number" value="<?= h($settings['kvk_number'] ?? '') ?>" placeholder="bijv. 12345678">
        <div class="admin-row">
            <div><label>Postcode</label><input type="text" name="address_zip" value="<?= h($settings['address_zip'] ?? '') ?>"></div>
            <div><label>Plaats</label><input type="text" name="address_city" value="<?= h($settings['address_city'] ?? '') ?>"></div>
        </div>
    </div>

    <div class="admin-panel">
        <h2>📞 Contact & WhatsApp</h2>
        <label>Telefoonnummer (zoals getoond)</label>
        <input type="text" name="phone_display" value="<?= h($settings['phone_display'] ?? '') ?>">
        <label>WhatsApp-nummer <small>(internationaal, zonder + of spaties, bijv. 31612345678)</small></label>
        <input type="text" name="whatsapp_number" value="<?= h($settings['whatsapp_number'] ?? '') ?>">
        <label>Automatisch WhatsApp-bericht <small>(dit bericht staat al klaar als de klant op WhatsApp klikt)</small></label>
        <textarea name="whatsapp_message" rows="3"><?= h($settings['whatsapp_message'] ?? '') ?></textarea>
        <label>Zwevende WhatsApp-knop</label>
        <select name="whatsapp_float">
            <option value="1" <?= ($settings['whatsapp_float'] ?? '1') === '1' ? 'selected' : '' ?>>Aan (aanbevolen)</option>
            <option value="0" <?= ($settings['whatsapp_float'] ?? '1') === '0' ? 'selected' : '' ?>>Uit</option>
        </select>

        <label>Testmodus (zoekmachines)</label>
        <select name="test_noindex">
            <option value="1" <?= ($settings['test_noindex'] ?? '0') === '1' ? 'selected' : '' ?>>Testfase: site (nog) niet indexeren (aanbevolen voor test-domein)</option>
            <option value="0" <?= ($settings['test_noindex'] ?? '0') === '0' ? 'selected' : '' ?>>Live: wél indexeren door Google</option>
        </select>
        <p class="admin-muted">Zet dit op "Live" zodra de site op het echte domein staat. Crawlers kunnen de site altijd bezoeken; met testmodus aan komt hij alleen niet in de zoekresultaten (zo blijft het echte domein de enige in Google).</p>
        <label>E-mailadres (contact + notificaties van leads)</label>
        <input type="email" name="notify_email" value="<?= h($settings['notify_email'] ?? '') ?>">
        <label>Afzender e-mail</label>
        <input type="email" name="contact_email" value="<?= h($settings['contact_email'] ?? '') ?>">
        <p class="admin-muted">💡 Zorg dat dit e-mailadres bestaat bij je hostingprovider (mijndomein.nl), anders komen lead-mails niet aan.</p>
    </div>

    <div class="admin-panel">
        <h2>📊 Google Ads & Analytics (leads meten)</h2>
        <label>Google Analytics 4 ID <small>(bijv. G-XXXXXXX)</small></label>
        <input type="text" name="analytics_id" value="<?= h($settings['analytics_id'] ?? '') ?>">
        <label>Google Ads conversie-ID <small>(bijv. AW-123456789)</small></label>
        <input type="text" name="ads_id" value="<?= h($settings['ads_id'] ?? '') ?>">
        <label>Conversie-label: contactformulier <small>(wordt gemeten op de bedankt-pagina)</small></label>
        <input type="text" name="ads_conversion_form" value="<?= h($settings['ads_conversion_form'] ?? '') ?>">
        <label>Conversie-label: WhatsApp-kliks</label>
        <input type="text" name="ads_conversion_whatsapp" value="<?= h($settings['ads_conversion_whatsapp'] ?? '') ?>">
        <p class="admin-muted">💡 Maak in Google Ads een conversie aan, kopieer het ID (AW-…) en het label hierheen. Zo zie je precies welke advertenties leads opleveren. De <code>gclid</code> wordt automatisch bij elke lead opgeslagen.</p>
    </div>

    <div class="admin-panel">
        <h2>🔗 Social media</h2>
        <label>Facebook-URL</label>
        <input type="text" name="facebook" value="<?= h($settings['facebook'] ?? '') ?>">
        <label>Instagram-URL</label>
        <input type="text" name="instagram" value="<?= h($settings['instagram'] ?? '') ?>">
    </div>

    <div class="admin-panel">
        <h2>🦶 Voettekst</h2>
        <label>Titel linker voetblok</label>
        <input type="text" name="footer_sitemap_title" value="<?= h($settings['footer_sitemap_title'] ?? '') ?>">
        <label>Tekst linker voetblok <small>(elke regel start automatisch als alinea; * voor lijstjes)</small></label>
        <textarea name="footer_sitemap_desc" rows="3"><?= h($settings['footer_sitemap_desc'] ?? '') ?></textarea>
        <label>Vaste website-URL <small>(leeg laten = automatisch je huidige domein; vul in bijv. https://mijndomein.nl zodra de site live staat)</small></label>
        <input type="text" name="base_url" value="<?= h($settings['base_url'] ?? '') ?>" placeholder="https://mijndomein.nl">
    </div>

    <div class="admin-actions">
        <button class="btn btn--primary" type="submit">💾 Instellingen opslaan</button>
    </div>
</form>

<?php view('admin/_footer'); ?>

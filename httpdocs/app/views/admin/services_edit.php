<?php view('admin/_header'); ?>

<p class="admin-crumb"><a href="/admin/diensten">← Terug naar diensten</a></p>
<h1 class="admin-h1">Dienst bewerken: <?= h($service['title']) ?></h1>

<form method="post" class="admin-form">
    <?= csrf_field() ?>

    <div class="admin-panel">
        <h2>Basis</h2>
        <label>Naam van de dienst</label>
        <input type="text" name="title" value="<?= h($service['title']) ?>">
        <label>Label <small>(wordt gebruikt om reviews te koppelen)</small></label>
        <input type="text" name="label" value="<?= h($service['label'] ?? $service['title']) ?>">
        <label class="admin-check">
            <input type="checkbox" name="enable_contact" <?= ($p['enable_contact'] ?? '0') === '1' ? 'checked' : '' ?>>
            WhatsApp/contact-knoppen tonen op deze pagina (aanbevolen voor meer leads)
        </label>
    </div>

    <div class="admin-panel">
        <h2>Google (SEO)</h2>
        <label>SEO-titel</label>
        <input type="text" name="meta_title" value="<?= h($p['meta_title'] ?? '') ?>">
        <label>SEO-omschrijving</label>
        <textarea name="meta_description" rows="3"><?= h($p['meta_description'] ?? '') ?></textarea>
    </div>

    <div class="admin-panel">
        <h2>Teksten</h2>
        <label>Kop (H1)</label>
        <input type="text" name="intro_title" value="<?= h($p['intro_title'] ?? '') ?>">
        <label>Introductietekst</label>
        <textarea class="richtext" name="intro_description" rows="8"><?= h($p['intro_description'] ?? '') ?></textarea>
        <label>Midden-tekst (bijv. voor/na kopje)</label>
        <textarea class="richtext" name="content_description" rows="5"><?= h($p['content_description'] ?? '') ?></textarea>
        <label>Tekst vóór de prijzen</label>
        <textarea class="richtext" name="content_intro_price" rows="6"><?= h($p['content_intro_price'] ?? '') ?></textarea>
        <label>Prijzen-kopje</label>
        <textarea class="richtext" name="content_price" rows="4"><?= h($p['content_price'] ?? '') ?></textarea>
        <label>Welke prijstabellen tonen? <small>(nummers 1-8: 1=Bank, 2=Stoel, 3=Matras, 4=Auto, 5=Tapijt, 6=Gevel, 7=Zonnepanelen, 8=Kantoor — komma-gescheiden)</small></label>
        <input type="text" name="content_showpriceid" value="<?= h($p['content_showpriceid'] ?? '') ?>" placeholder="bijv. 1, 2">
        <label>Video-omschrijving <small>(optioneel)</small></label>
        <textarea name="content_video_description" rows="3"><?= h($p['content_video_description'] ?? '') ?></textarea>
    </div>

    <div class="admin-actions">
        <button class="btn btn--primary" type="submit">💾 Opslaan</button>
        <a class="btn" href="/reinigen/<?= h($service['slug']) ?>" target="_blank" rel="noopener">👁 Bekijk pagina</a>
    </div>
</form>

<?php view('admin/_footer'); ?>

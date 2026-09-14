<?php view('admin/_header'); ?>

<p class="admin-crumb"><a href="/admin/paginas">← Terug naar pagina's</a></p>
<h1 class="admin-h1">Pagina bewerken: <?= h($p['title']) ?></h1>

<form method="post" class="admin-form">
    <?= csrf_field() ?>

    <div class="admin-panel">
        <h2>Basis</h2>
        <label>Titel (in menu)</label>
        <input type="text" name="title" value="<?= h($p['title']) ?>">
        <label class="admin-check">
            <input type="checkbox" name="in_menu" <?= $p['in_menu'] ? 'checked' : '' ?>> Zichtbaar in het menu
        </label>
    </div>

    <div class="admin-panel">
        <h2>Google (SEO)</h2>
        <label>SEO-titel <small>(blauwe link in Google)</small></label>
        <input type="text" name="meta_title" value="<?= h($p['meta_title'] ?? '') ?>">
        <label>SEO-omschrijving <small>(tekst onder de link in Google)</small></label>
        <textarea name="meta_description" rows="3"><?= h($p['meta_description'] ?? '') ?></textarea>
    </div>

    <?php if (array_key_exists('hero_title', $p)): ?>
    <div class="admin-panel">
        <h2>Hero (grote titel bovenaan)</h2>
        <label>Titel</label>
        <input type="text" name="hero_title" value="<?= h($p['hero_title'] ?? '') ?>">
        <label>Subtitel</label>
        <textarea name="hero_subtitle" rows="2"><?= h($p['hero_subtitle'] ?? '') ?></textarea>
    </div>
    <?php endif; ?>

    <div class="admin-panel">
        <h2>Content</h2>
        <?php if (array_key_exists('intro_title', $p)): ?>
            <label>Kop (H1)</label>
            <input type="text" name="intro_title" value="<?= h($p['intro_title'] ?? '') ?>">
        <?php endif; ?>
        <?php if (array_key_exists('intro_description', $p)): ?>
            <label>Introductietekst</label>
            <textarea class="richtext" name="intro_description" rows="8"><?= h($p['intro_description'] ?? '') ?></textarea>
        <?php endif; ?>
        <?php if (array_key_exists('content_description', $p)): ?>
            <label>Vervolgtekst</label>
            <textarea class="richtext" name="content_description" rows="8"><?= h($p['content_description'] ?? '') ?></textarea>
        <?php endif; ?>
        <?php if (array_key_exists('plus_title', $p)): ?>
            <label>“Waarom”-titel</label>
            <input type="text" name="plus_title" value="<?= h($p['plus_title'] ?? '') ?>">
            <label>“Waarom”-lijst <small>(elke regel starten met * )</small></label>
            <textarea name="plus_list" rows="8"><?= h($p['plus_list'] ?? '') ?></textarea>
        <?php endif; ?>
        <?php if (array_key_exists('form_message', $p)): ?>
            <label>Tekst boven formulier</label>
            <textarea name="form_message" rows="3"><?= h($p['form_message'] ?? '') ?></textarea>
            <label>Bedankt-tekst</label>
            <textarea name="thank_you_message" rows="3"><?= h($p['thank_you_message'] ?? '') ?></textarea>
        <?php endif; ?>
        <?php if (array_key_exists('side_address', $p)): ?>
            <label>Zijbalk-tekst (contactinfo)</label>
            <textarea name="side_address" rows="5"><?= h($p['side_address'] ?? '') ?></textarea>
        <?php endif; ?>
    </div>

    <div class="admin-actions">
        <button class="btn btn--primary" type="submit">💾 Opslaan</button>
        <a class="btn" href="/<?= h($p['slug']) ?>" target="_blank" rel="noopener">👁 Bekijk pagina</a>
    </div>
</form>

<?php view('admin/_footer'); ?>

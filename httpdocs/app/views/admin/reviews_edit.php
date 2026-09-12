<?php view('admin/_header'); ?>

<p class="admin-crumb"><a href="/admin/reviews">← Terug naar reviews</a></p>
<h1 class="admin-h1"><?= $review['id'] ? 'Review bewerken' : 'Nieuwe review' ?></h1>

<form method="post" class="admin-form">
    <?= csrf_field() ?>

    <div class="admin-panel">
        <label>Klant (naam + plaats)</label>
        <input type="text" name="name" value="<?= h($review['name']) ?>" placeholder="bijv. Ilona S te Rotterdam">

        <label>Dienst</label>
        <select name="service">
            <option value="">— kies dienst —</option>
            <?php foreach ($serviceLabels as $lbl): ?>
                <option value="<?= h($lbl) ?>" <?= $review['service'] === $lbl ? 'selected' : '' ?>><?= h($lbl) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Kop / titel van de review</label>
        <input type="text" name="title" value="<?= h($review['title']) ?>">

        <label>Recensie</label>
        <textarea name="content" rows="6"><?= h($review['content']) ?></textarea>

        <label class="admin-check">
            <input type="checkbox" name="active" <?= $review['active'] ? 'checked' : '' ?>> Zichtbaar op de website
        </label>
    </div>

    <div class="admin-actions">
        <button class="btn btn--primary" type="submit">💾 Opslaan</button>
    </div>
</form>

<?php view('admin/_footer'); ?>

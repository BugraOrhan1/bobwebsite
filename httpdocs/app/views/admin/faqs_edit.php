<?php view('admin/_header'); ?>

<p class="admin-crumb"><a href="/admin/faq">← Terug naar FAQ's</a></p>
<h1 class="admin-h1"><?= $faq['id'] ? 'Vraag bewerken' : 'Nieuwe veelgestelde vraag' ?></h1>

<form method="post" class="admin-form" style="max-width:720px">
    <?= csrf_field() ?>

    <div class="admin-panel">
        <label>Vraag</label>
        <input type="text" name="question" value="<?= h($faq['question']) ?>" placeholder="bijv. Hoe lang duurt het drogen?">

        <label>Antwoord</label>
        <textarea name="answer" rows="5"><?= h($faq['answer']) ?></textarea>

        <label class="admin-check">
            <input type="checkbox" name="active" <?= $faq['active'] ? 'checked' : '' ?>> Zichtbaar op de website
        </label>
    </div>

    <div class="admin-actions">
        <button class="btn btn--primary" type="submit">💾 Opslaan</button>
    </div>
</form>

<?php view('admin/_footer'); ?>

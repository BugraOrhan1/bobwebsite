<?php view('admin/_header'); ?>

<h1 class="admin-h1">Media</h1>
<p class="admin-sub">Upload afbeeldingen (bijv. nieuwe voor/na-foto's). De link kun je daarna in teksten gebruiken.</p>

<form method="post" enctype="multipart/form-data" class="admin-form" style="max-width:520px">
    <?= csrf_field() ?>
    <div class="admin-panel">
        <label>Kies een afbeelding (jpg, png, webp, gif of svg — max 10 MB)</label>
        <input type="file" name="file" accept="image/*" required>
        <div class="admin-actions"><button class="btn btn--primary" type="submit">⬆️ Uploaden</button></div>
    </div>
</form>

<div class="admin-panel">
    <h2>Beschikbare afbeeldingen</h2>
    <table class="admin-table">
        <thead><tr><th>Voorbeeld</th><th>Link</th></tr></thead>
        <tbody>
        <?php foreach ($files as $f): ?>
            <tr>
                <td><img src="<?= h($f) ?>" alt="" style="max-width:90px;max-height:60px;object-fit:cover;border-radius:6px" loading="lazy"></td>
                <td><code onclick="navigator.clipboard?.writeText(this.innerText)"><?= h($f) ?></code></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php view('admin/_footer'); ?>

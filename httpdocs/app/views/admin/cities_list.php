<?php view('admin/_header'); ?>

<h1 class="admin-h1">Stadspagina's <span class="admin-badge"><?= (int)$counts['enabled'] ?> / <?= (int)$counts['total'] ?> aan</span></h1>
<p class="admin-sub">
    Elke actieve plaats krijgt automatisch een eigen pagina per dienst (<?= (int)$counts['enabled'] ?> plaatsen × 8 diensten = <?= number_format((int)$counts['enabled'] * 8, 0, ',', '.') ?> pagina's voor Google).
    Zet plaatsen aan/uit of geef een plaats een eigen inleidingstekst.
</p>

<form method="get" class="admin-toolbar admin-toolbar--filters">
    <input type="text" name="q" value="<?= h($q) ?>" placeholder="Zoek een plaats…">
    <select name="prov">
        <option value="">Alle provincies</option>
        <?php foreach ($provinces as $pr): ?>
            <option value="<?= h($pr) ?>" <?= $prov === $pr ? 'selected' : '' ?>><?= h($pr) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="btn" type="submit">Zoeken</button>
    <?php if ($q !== '' || $prov !== ''): ?><a class="btn" href="/admin/steden">✕ Reset</a><?php endif; ?>
</form>

<form method="post" id="bulk-form" class="admin-toolbar">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="bulk">
    <input type="hidden" name="q" value="<?= h($q) ?>">
    <input type="hidden" name="prov" value="<?= h($prov) ?>">
    <label class="admin-check"><input type="checkbox" id="check-all"> Alles selecteren</label>
    <button class="btn btn--small" type="submit" name="enable" value="1">✅ Geselecteerde aanzetten</button>
    <button class="btn btn--small" type="submit">⛔ Geselecteerde uitzetten</button>
</form>

<table class="admin-table">
    <thead><tr><th></th><th>Plaats</th><th>Provincie</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($cities as $c): ?>
        <tr class="<?= $c['enabled'] ? '' : 'is-muted' ?>">
            <td><input type="checkbox" name="ids[]" value="<?= (int)$c['id'] ?>" form="bulk-form"></td>
            <td><strong><?= h($c['name']) ?></strong><?php if ($c['intro']): ?> <span title="Eigen tekst ingesteld">✍️</span><?php endif; ?></td>
            <td><?= h($c['province']) ?></td>
            <td><?= $c['enabled'] ? '🟢 online' : '⚪ offline' ?></td>
            <td class="nowrap">
                <a class="btn btn--small" href="/admin/steden/edit?id=<?= (int)$c['id'] ?>">✏️ Tekst</a>
                <form method="post" class="inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                    <input type="hidden" name="q" value="<?= h($q) ?>">
                    <input type="hidden" name="prov" value="<?= h($prov) ?>">
                    <button class="btn btn--small" type="submit"><?= $c['enabled'] ? 'Uitzetten' : 'Aanzetten' ?></button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (count($cities) === 200): ?>
    <p class="admin-muted">Er zijn meer resultaten — verfijn je zoekopdracht.</p>
<?php endif; ?>

<script>
document.getElementById('check-all')?.addEventListener('change', function () {
    document.querySelectorAll('input[name="ids[]"]').forEach(cb => cb.checked = this.checked);
});
</script>

<?php view('admin/_footer'); ?>

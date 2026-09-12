<?php view('admin/_header'); ?>

<h1 class="admin-h1">Portfolio (voor/na-foto's) <span class="admin-badge"><?= count($items) ?></span></h1>
<p class="admin-sub">Deze voor/na-paren verschijnen op de pagina <a href="/portfolio" target="_blank" rel="noopener">Portfolio</a>. Zet de mooiste resultaten bovenaan.</p>

<div class="admin-toolbar">
    <a class="btn btn--primary" href="/admin/portfolio/edit?id=0">➕ Nieuw voor/na-paar toevoegen</a>
    <a class="btn" href="/admin/media">🖼️ Foto's uploaden</a>
</div>

<table class="admin-table">
    <thead><tr><th></th><th>Voor</th><th>Na</th><th>Titel</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($items as $i => $it): ?>
        <tr class="<?= $it['active'] ? '' : 'is-muted' ?>">
            <td class="nowrap">
                <form method="post" class="inline"><?= csrf_field() ?><input type="hidden" name="action" value="up"><input type="hidden" name="id" value="<?= (int)$it['id'] ?>"><button class="btn btn--small" type="submit" title="Omhoog" <?= $i === 0 ? 'disabled' : '' ?>>↑</button></form>
                <form method="post" class="inline"><?= csrf_field() ?><input type="hidden" name="action" value="down"><input type="hidden" name="id" value="<?= (int)$it['id'] ?>"><button class="btn btn--small" type="submit" title="Omlaag" <?= $i === count($items) - 1 ? 'disabled' : '' ?>>↓</button></form>
            </td>
            <td><img src="<?= h($it['before_img']) ?>" alt="" class="admin-thumb"></td>
            <td><img src="<?= h($it['after_img']) ?>" alt="" class="admin-thumb"></td>
            <td><strong><?= h($it['title']) ?></strong></td>
            <td><?= $it['active'] ? '🟢' : '⚪ verborgen' ?></td>
            <td class="nowrap">
                <a class="btn btn--small" href="/admin/portfolio/edit?id=<?= (int)$it['id'] ?>">✏️</a>
                <form method="post" class="inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
                    <button class="btn btn--small" type="submit"><?= $it['active'] ? 'Verbergen' : 'Tonen' ?></button>
                </form>
                <form method="post" class="inline" onsubmit="return confirm('Dit voor/na-paar verwijderen?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
                    <button class="btn btn--small btn--danger" type="submit">✕</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php view('admin/_footer'); ?>

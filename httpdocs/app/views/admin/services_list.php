<?php view('admin/_header'); ?>

<h1 class="admin-h1">Diensten</h1>
<p class="admin-sub">Je 8 diensten. Elke dienst heeft automatisch een eigen pagina + stadspagina's door heel Nederland. Klik op <strong>bewerken</strong> om de teksten aan te passen.</p>

<table class="admin-table">
    <thead><tr><th></th><th>Dienst</th><th>URL</th><th>Pagina's</th><th></th></tr></thead>
    <tbody>
    <?php $cityCount = (int)db()->query('SELECT COUNT(*) FROM cities WHERE enabled = 1')->fetchColumn(); ?>
    <?php foreach ($services as $s): ?>
        <tr class="<?= $s['active'] ? '' : 'is-muted' ?>">
            <td><?= $s['active'] ? '🟢' : '⚪' ?></td>
            <td>
                <strong><?= h($s['title']) ?></strong>
                <form method="post" class="admin-inline-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
                    <?php if ($s['active']): ?><input type="hidden" name="active" value="0"><?php endif; ?>
                    <input type="hidden" name="title" value="<?= h($s['title']) ?>">
                    <button class="linklike" type="submit"><?= $s['active'] ? 'uitschakelen' : 'inschakelen' ?></button>
                </form>
            </td>
            <td class="admin-muted">/reinigen/<?= h($s['slug']) ?></td>
            <td class="admin-muted">1 + <?= $cityCount ?> steden</td>
            <td><a class="btn btn--small btn--primary" href="/admin/diensten/edit?slug=<?= h($s['slug']) ?>">✏️ Bewerken</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php view('admin/_footer'); ?>

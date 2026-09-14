<?php view('admin/_header'); ?>

<h1 class="admin-h1">Veelgestelde vragen (FAQ) <span class="admin-badge"><?= count($faqs) ?></span></h1>
<p class="admin-sub">Deze vragen verschijnen op de homepagina en verbeteren je zichtbaarheid in Google (rich results).</p>

<div class="admin-toolbar">
    <a class="btn btn--primary" href="/admin/faq/edit?id=0">➕ Nieuwe vraag toevoegen</a>
</div>

<table class="admin-table">
    <thead><tr><th>Vraag</th><th>Antwoord</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($faqs as $f): ?>
        <tr class="<?= $f['active'] ? '' : 'is-muted' ?>">
            <td><strong><?= h($f['question']) ?></strong></td>
            <td><?= h(mb_strimwidth(strip_tags($f['answer']), 0, 80, '…')) ?></td>
            <td><?= $f['active'] ? '🟢' : '⚪ verborgen' ?></td>
            <td class="nowrap">
                <a class="btn btn--small" href="/admin/faq/edit?id=<?= (int)$f['id'] ?>">✏️</a>
                <form method="post" class="inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
                    <button class="btn btn--small" type="submit"><?= $f['active'] ? 'Verbergen' : 'Tonen' ?></button>
                </form>
                <form method="post" class="inline" onsubmit="return confirm('Vraag verwijderen?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
                    <button class="btn btn--small btn--danger" type="submit">✕</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php view('admin/_footer'); ?>

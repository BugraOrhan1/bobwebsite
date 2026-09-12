<?php view('admin/_header'); ?>

<h1 class="admin-h1">Reviews <span class="admin-badge"><?= count($reviews) ?></span></h1>
<p class="admin-sub">Klantbeoordelingen. Reviews verschijnen op de homepagina (4 stuks), de reviewspagina en bij de bijbehorende dienst.</p>

<div class="admin-toolbar">
    <a class="btn btn--primary" href="/admin/reviews/edit?id=0">➕ Nieuwe review toevoegen</a>
</div>

<?php usort($reviews, fn($a, $b) => (int)($b['pending'] ?? 0) <=> (int)($a['pending'] ?? 0)); ?>
<?php $pendingCount = count(array_filter($reviews, fn($r) => !empty($r['pending']))); ?>
<?php if ($pendingCount): ?>
    <p class="admin-flash">⏳ <?= $pendingCount ?> nieuwe beoordeling(en) wachten op goedkeuring.</p>
<?php endif; ?>

<table class="admin-table">
    <thead><tr><th>Dienst</th><th>Klant</th><th>Titel</th><th>Recensie</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($reviews as $r): ?>
        <tr class="<?= $r['active'] ? '' : 'is-muted' ?>">
            <td><?= h($r['service']) ?></td>
            <td class="nowrap"><?= h($r['name']) ?></td>
            <td><?= h(mb_strimwidth($r['title'] ?: '—', 0, 40, '…')) ?></td>
            <td><?= h(mb_strimwidth(strip_tags($r['content']), 0, 60, '…')) ?></td>
            <td><?= $r['active'] ? '🟢' : (!empty($r['pending']) ? '⏳ nieuw' : '⚪ verborgen') ?></td>
            <td class="nowrap">
                <?php if (!empty($r['pending'])): ?>
                <form method="post" class="inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="approve">
                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                    <button class="btn btn--small btn--primary" type="submit">✅ Publiceren</button>
                </form>
                <?php endif; ?>
                <a class="btn btn--small" href="/admin/reviews/edit?id=<?= (int)$r['id'] ?>">✏️</a>
                <form method="post" class="inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                    <button class="btn btn--small" type="submit"><?= $r['active'] ? 'Verbergen' : 'Tonen' ?></button>
                </form>
                <form method="post" class="inline" onsubmit="return confirm('Review verwijderen?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                    <button class="btn btn--small btn--danger" type="submit">✕</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php view('admin/_footer'); ?>

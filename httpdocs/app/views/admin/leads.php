<?php view('admin/_header'); ?>

<h1 class="admin-h1">Leads <span class="admin-badge"><?= (int)$total ?></span></h1>
<p class="admin-sub">Alle ingevulde contactformulieren. Leads met een <strong>vetgedrukte</strong> regel zijn nog niet gelezen. De gclid-kolom koppelt de lead aan je Google Ads-klik.</p>

<?php if (!$leads): ?>
    <div class="admin-panel"><p class="admin-muted">Nog geen leads. Zodra iemand het contactformulier invult, verschijnt die hier (en je krijgt een e-mail).</p></div>
<?php else: ?>

<div class="admin-toolbar">
    <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="mark_all">
        <button class="btn" type="submit">Alles als gelezen markeren</button>
    </form>
</div>

<table class="admin-table admin-table--leads">
    <thead>
        <tr>
            <th>Datum</th><th>Naam</th><th>Contact</th><th>Plaats</th><th>Bron</th><th>GCLID</th><th>Bericht</th><th>Acties</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($leads as $l): ?>
        <tr class="<?= $l['is_read'] ? '' : 'is-unread' ?>">
            <td class="nowrap"><?= h(date('d-m-Y H:i', strtotime($l['created_at']))) ?></td>
            <td><?= h($l['name']) ?></td>
            <td>
                <?php if ($l['phone']): ?><a href="tel:<?= h($l['phone']) ?>"><?= h($l['phone']) ?></a><br><?php endif; ?>
                <?php if ($l['email']): ?><a href="mailto:<?= h($l['email']) ?>"><?= h($l['email']) ?></a><?php endif; ?>
            </td>
            <td><?= h($l['city']) ?></td>
            <td><?= h($l['source']) ?></td>
            <td class="admin-muted"><?= h($l['gclid'] ? mb_substr($l['gclid'], 0, 12) . '…' : '—') ?></td>
            <td>
                <details><summary><?= h(mb_strimwidth(strip_tags($l['message']), 0, 60, '…')) ?></summary>
                    <div class="admin-lead-msg"><?= nl2br(h($l['message'])) ?></div>
                    <?php if ($l['attachment']): ?>
                        <a target="_blank" rel="noopener" href="/admin/bijlage?id=<?= (int)$l['id'] ?>">📎 Bijlage openen</a>
                    <?php endif; ?>
                </details>
            </td>
            <td class="nowrap">
                <?php if (!$l['is_read']): ?>
                <form method="post" class="inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="read">
                    <input type="hidden" name="id" value="<?= (int)$l['id'] ?>">
                    <button class="btn btn--small" type="submit">✓ gelezen</button>
                </form>
                <?php endif; ?>
                <form method="post" class="inline" onsubmit="return confirm('Lead definitief verwijderen?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$l['id'] ?>">
                    <button class="btn btn--small btn--danger" type="submit">✕</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php
$pages = max(1, (int)ceil($total / $perPage));
if ($pages > 1): ?>
<div class="admin-pager">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
        <?php if ($i === $page): ?><span class="admin-pager__cur"><?= $i ?></span>
        <?php else: ?><a href="/admin/leads?p=<?= $i ?>"><?= $i ?></a><?php endif; ?>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php endif; ?>

<?php view('admin/_footer'); ?>

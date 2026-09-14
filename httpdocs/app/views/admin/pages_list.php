<?php view('admin/_header'); ?>

<h1 class="admin-h1">Pagina's</h1>
<p class="admin-sub">Bewerk hier alle vaste pagina's van de website: teksten, titels en SEO (vindbaarheid in Google).</p>

<table class="admin-table">
    <thead><tr><th>Pagina</th><th>URL</th><th>In menu</th><th>Laatst gewijzigd</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($pages as $p): ?>
        <tr>
            <td><strong><?= h($p['title']) ?></strong></td>
            <td class="admin-muted">/<?= h($p['slug']) ?></td>
            <td><?= $p['in_menu'] ? '✔' : '—' ?></td>
            <td class="admin-muted"><?= h($p['updated_at'] ?: '—') ?></td>
            <td><a class="btn btn--small btn--primary" href="/admin/paginas/edit?id=<?= (int)$p['id'] ?>">✏️ Bewerken</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p class="admin-muted" style="margin-top:16px">💡 Diensten bewerk je onder <a href="/admin/diensten">Diensten</a> en stadspagina's onder <a href="/admin/steden">Stadspagina's</a>.</p>

<?php view('admin/_footer'); ?>

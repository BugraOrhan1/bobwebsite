<?php view('admin/_header'); ?>

<p class="admin-crumb"><a href="/admin/steden">← Terug naar stadspagina's</a></p>
<h1 class="admin-h1">Stadspagina: <?= h($city['name']) ?></h1>

<div class="admin-panel admin-panel--info">
    <p>Deze plaats heeft <strong>8 automatische pagina's</strong> (één per dienst), bijvoorbeeld:</p>
    <ul>
        <li><a target="_blank" rel="noopener" href="/reinigen/bank-reinigen/<?= h($city['slug']) ?>">Bankreiniging in <?= h($city['name']) ?></a></li>
        <li><a target="_blank" rel="noopener" href="/reinigen/meubelreiniging/<?= h($city['slug']) ?>">Meubelreiniging in <?= h($city['name']) ?></a></li>
    </ul>
    <p>Laat de inleiding leeg en de site schrijft automatisch een unieke tekst per dienst. Vul je eigen tekst in om die over te nemen op <em>alle</em> 8 de pagina's van deze plaats.</p>
</div>

<form method="post" class="admin-form">
    <?= csrf_field() ?>

    <div class="admin-panel">
        <label>Naam van de plaats</label>
        <input type="text" name="name" value="<?= h($city['name']) ?>">

        <label>Provincie</label>
        <input type="text" name="province" value="<?= h($city['province']) ?>">

        <label class="admin-check">
            <input type="checkbox" name="enabled" <?= $city['enabled'] ? 'checked' : '' ?>>
            Pagina's van deze plaats online zetten
        </label>

        <label>Eigen inleidingstekst <small>(optioneel — leeg = automatisch gegenereerde tekst)</small></label>
        <textarea class="richtext" name="intro" rows="8"><?= h($city['intro'] ?? '') ?></textarea>
    </div>

    <div class="admin-actions">
        <button class="btn btn--primary" type="submit">💾 Opslaan</button>
        <a class="btn" href="/reinigen/bank-reinigen/<?= h($city['slug']) ?>" target="_blank" rel="noopener">👁 Bekijk voorbeeld</a>
    </div>
</form>

<?php view('admin/_footer'); ?>

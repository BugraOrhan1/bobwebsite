<?php view('admin/_header'); ?>

<h1 class="admin-h1">Prijzen</h1>
<p class="admin-sub">Beheer hier je tarieven. Deze verschijnen op de homepagina, de tarievenpagina en de dienstenpagina's. Wijzig een prijs, verwijder een regel met ✕, of voeg onderaan iets toe — en druk daarna op opslaan.</p>

<form method="post" class="admin-form">
    <?= csrf_field() ?>

    <?php foreach ($groups as $g): ?>
        <div class="admin-panel">
            <div class="admin-panel__head">
                <input type="text" name="group[<?= (int)$g['id'] ?>][title]" value="<?= h($g['title']) ?>" class="admin-pricegroup-title">
                <label class="admin-check admin-check--danger">
                    <input type="checkbox" name="delete_group[<?= (int)$g['id'] ?>]" value="1"> hele groep verwijderen
                </label>
            </div>
            <table class="admin-table admin-table--prices">
                <thead><tr><th>Omschrijving</th><th style="width:160px">Prijs</th><th style="width:70px"></th></tr></thead>
                <tbody data-items>
                <?php foreach ($g['items'] as $it): ?>
                    <tr>
                        <td><input type="text" name="item[<?= (int)$it['id'] ?>][name]" value="<?= h($it['name']) ?>"></td>
                        <td><input type="text" name="item[<?= (int)$it['id'] ?>][price]" value="<?= h($it['price']) ?>" placeholder="€ 49 / op aanvraag"></td>
                        <td class="admin-muted">
                            <label class="admin-check" title="verwijderen">
                                <input type="checkbox" name="delete_item[<?= (int)$it['id'] ?>]" value="1"> ✕
                            </label>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="admin-newrow">
                        <td><input type="text" name="new_item[<?= (int)$g['id'] ?>][name]" placeholder="+ Nieuwe regel (bijv. Zeszitsbank)"></td>
                        <td><input type="text" name="new_item[<?= (int)$g['id'] ?>][price]" placeholder="€ …"></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="new_item[<?= (int)$g['id'] ?>][group]" value="<?= (int)$g['id'] ?>">
        </div>
    <?php endforeach; ?>

    <div class="admin-panel">
        <h2>Nieuwe prijsgroep</h2>
        <input type="text" name="new_group_title" placeholder="Naam van nieuwe groep (bijv. Vloerreiniging)">
    </div>

    <div class="admin-actions">
        <button class="btn btn--primary" type="submit">💾 Alles opslaan</button>
    </div>
</form>

<?php view('admin/_footer'); ?>

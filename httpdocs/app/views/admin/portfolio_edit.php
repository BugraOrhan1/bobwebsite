<?php view('admin/_header'); ?>

<p class="admin-crumb"><a href="/admin/portfolio">← Terug naar portfolio</a></p>
<h1 class="admin-h1"><?= $item['id'] ? 'Voor/na-paar bewerken' : 'Nieuw voor/na-paar' ?></h1>

<form method="post" class="admin-form" style="max-width:860px">
    <?= csrf_field() ?>

    <div class="admin-panel">
        <label>Titel</label>
        <input type="text" name="title" required value="<?= h($item['title']) ?>"
               placeholder="bijv. Hoekbank (stof) — vlekken verwijderd">

        <div class="admin-cols">
            <div>
                <label>Foto VÓÓR de reiniging</label>
                <select name="before_img" required onchange="document.getElementById('pv-before').src=this.value">
                    <?php if ($item['before_img'] && !in_array($item['before_img'], array_merge([], ...array_values($media)), true)): ?>
                        <option value="<?= h($item['before_img']) ?>" selected><?= h($item['before_img']) ?> (huidig)</option>
                    <?php endif; ?>
                    <?php foreach ($media as $folder => $files): ?>
                        <optgroup label="📁 <?= h($folder) ?>">
                            <?php foreach ($files as $f): ?>
                                <option value="<?= h($f) ?>" <?= $f === $item['before_img'] ? 'selected' : '' ?>><?= h(basename($f)) ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
                <img id="pv-before" src="<?= h($item['before_img']) ?>" alt="Voorbeeld voor-foto" class="admin-preview" <?= $item['before_img'] ? '' : 'style="display:none"' ?>>
            </div>
            <div>
                <label>Foto NÁ de reiniging</label>
                <select name="after_img" required onchange="document.getElementById('pv-after').src=this.value">
                    <?php if ($item['after_img'] && !in_array($item['after_img'], array_merge([], ...array_values($media)), true)): ?>
                        <option value="<?= h($item['after_img']) ?>" selected><?= h($item['after_img']) ?> (huidig)</option>
                    <?php endif; ?>
                    <?php foreach ($media as $folder => $files): ?>
                        <optgroup label="📁 <?= h($folder) ?>">
                            <?php foreach ($files as $f): ?>
                                <option value="<?= h($f) ?>" <?= $f === $item['after_img'] ? 'selected' : '' ?>><?= h(basename($f)) ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
                <img id="pv-after" src="<?= h($item['after_img']) ?>" alt="Voorbeeld na-foto" class="admin-preview" <?= $item['after_img'] ? '' : 'style="display:none"' ?>>
            </div>
        </div>
        <p class="admin-muted">Staat je foto er niet tussen? Upload hem eerst via <a href="/admin/media">Media</a> (map "portfolio").</p>

        <label class="admin-check">
            <input type="checkbox" name="active" <?= $item['active'] ? 'checked' : '' ?>> Zichtbaar op de website
        </label>
    </div>

    <div class="admin-actions">
        <button class="btn btn--primary" type="submit">💾 Opslaan</button>
        <a class="btn" href="/admin/portfolio">Annuleren</a>
    </div>
</form>

<?php view('admin/_footer'); ?>

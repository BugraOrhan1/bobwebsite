<?php view('admin/_header'); ?>

<h1 class="admin-h1">Mijn account</h1>
<p class="admin-sub">Ingelogd als <strong><?= h($_SESSION['admin_user'] ?? '') ?></strong>. Wijzig hier je wachtwoord zodat alleen jij toegang hebt.</p>

<form method="post" class="admin-form" style="max-width:480px">
    <?= csrf_field() ?>

    <div class="admin-panel">
        <label>Huidig wachtwoord</label>
        <input type="password" name="current" required autocomplete="current-password">

        <label>Nieuw wachtwoord <small>(minimaal 8 tekens)</small></label>
        <input type="password" name="password" required minlength="8" autocomplete="new-password">

        <label>Herhaal nieuw wachtwoord</label>
        <input type="password" name="password2" required minlength="8" autocomplete="new-password">
    </div>

    <div class="admin-actions">
        <button class="btn btn--primary" type="submit">🔑 Wachtwoord wijzigen</button>
    </div>
</form>

<?php view('admin/_footer'); ?>

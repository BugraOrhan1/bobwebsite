<?php view('admin/_header'); ?>

<h1 class="admin-h1">Dashboard</h1>
<p class="admin-sub">Welkom, <?= h($_SESSION['admin_user'] ?? 'beheerder') ?> 👋 — hier is het overzicht van je website.</p>

<?php if ($mustChange): ?>
<div class="admin-flash admin-flash--warn">
    ⚠️ Je gebruikt nog het tijdelijke wachtwoord. <a href="/admin/account">Verander je wachtwoord</a> zodat alleen jij toegang hebt.
</div>
<?php endif; ?>

<div class="stat-grid">
    <a class="stat-card stat-card--accent" href="/admin/leads">
        <span class="stat-card__nr"><?= (int)$stats['leads_unread'] ?></span>
        <span class="stat-card__label">Nieuwe leads (ongelezen)</span>
    </a>
    <div class="stat-card">
        <span class="stat-card__nr"><?= (int)$stats['leads_week'] ?></span>
        <span class="stat-card__label">Leads deze week</span>
    </div>
    <div class="stat-card">
        <span class="stat-card__nr"><?= (int)$stats['leads_month'] ?></span>
        <span class="stat-card__label">Leads afgelopen 30 dagen</span>
    </div>
    <div class="stat-card">
        <span class="stat-card__nr"><?= number_format($stats['cities'], 0, ',', '.') ?></span>
        <span class="stat-card__label">Stadspagina's online</span>
    </div>
</div>

<div class="admin-cols">
    <div class="admin-panel">
        <h2>Meest recente leads</h2>
        <?php if (!$recentLeads): ?>
            <p class="admin-muted">Nog geen leads ontvangen. Zet je Google Ads-campagne aan en ze verschijnen hier!</p>
        <?php else: ?>
        <table class="admin-table">
            <thead><tr><th>Datum</th><th>Naam</th><th>Plaats</th><th>Bron</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($recentLeads as $l): ?>
                <tr class="<?= $l['is_read'] ? '' : 'is-unread' ?>">
                    <td><?= h(date('d-m H:i', strtotime($l['created_at']))) ?></td>
                    <td><?= h($l['name']) ?></td>
                    <td><?= h($l['city']) ?></td>
                    <td><?= h($l['source']) ?></td>
                    <td><a href="/admin/leads">bekijk →</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div class="admin-panel">
        <h2>Snel aan de slag</h2>
        <ul class="admin-tips">
            <li>📱 <a href="/admin/instellingen">Instellingen</a> — telefoonnummer, WhatsApp-bericht en e-mail aanpassen</li>
            <li>💶 <a href="/admin/prijzen">Prijzen</a> — tarieven toevoegen of wijzigen</li>
            <li>⭐ <a href="/admin/reviews">Reviews</a> — nieuwe klantbeoordelingen plaatsen</li>
            <li>📍 <a href="/admin/steden">Stadspagina's</a> — plaatsen aan/uit zetten of eigen tekst geven</li>
            <li>📊 Google Ads: vul bij <a href="/admin/instellingen">Instellingen</a> je conversie-ID's in zodat leads gemeten worden</li>
        </ul>
    </div>
</div>

<?php view('admin/_footer'); ?>

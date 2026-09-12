<?php
/** Cookie-toestemming: alleen tonen als er tracking is en nog geen keuze gemaakt */
if (($_COOKIE['rd_consent'] ?? null) !== null) return;
if (!setting('analytics_id') && !setting('ads_id')) return;
?>
<div id="cookie-bar" class="cookie-bar" style="display:none" role="dialog" aria-label="Cookie-toestemming">
    <span>🍪 Wij gebruiken cookies om onze site te verbeteren en advertenties te meten.
        <a href="/privacy">Privacyverklaring</a></span>
    <button class="btn cookie-bar__accept" type="button">Accepteren</button>
    <button class="btn cookie-bar__decline" type="button">Alleen noodzakelijk</button>
</div>

/**
 * De Reinigingsdokter — app.js
 * - Bewaart de Google Ads gclid-parameter in een cookie (lead-attributie)
 * - Vuurt conversie-events af (formulier + WhatsApp-kliks)
 */
(function () {
    'use strict';

    function setCookie(name, value, days) {
        var d = new Date();
        d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
        document.cookie = name + '=' + encodeURIComponent(value) +
            ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
    }

    // 1) gclid (en andere UTM's) vastleggen voor Google Ads-attributie
    try {
        var params = new URLSearchParams(window.location.search);
        var gclid = params.get('gclid');
        if (gclid) setCookie('rds_gclid', gclid, 90);
        var msclkid = params.get('msclkid');
        if (msclkid) setCookie('rds_msclkid', msclkid, 90);

        // gclid in het contactformulier stoppen
        var field = document.getElementById('gclid-field');
        if (field) {
            var cookieMatch = document.cookie.match(/(?:^|;\s*)rds_gclid=([^;]+)/);
            field.value = gclid || (cookieMatch ? decodeURIComponent(cookieMatch[1]) : '');
        }
    } catch (e) { /* stil falen */ }

    // 2) Conversie: contactformulier succespagina
    try {
        var convNode = document.getElementById('ads-form-conversion');
        if (convNode && convNode.getAttribute('data-label') && typeof gtag === 'function') {
            var adsId = window.__RDS_ADS_ID__;
            if (adsId) {
                gtag('event', 'conversion', {
                    'send_to': adsId + '/' + convNode.getAttribute('data-label')
                });
            }
        }
    } catch (e) { /* stil falen */ }

    // 3) Conversie: WhatsApp-kliks
    try {
        var waLinks = document.querySelectorAll('a[href*="whatsapp.com"], a[href*="wa.me"]');
        for (var i = 0; i < waLinks.length; i++) {
            waLinks[i].addEventListener('click', function () {
                if (typeof gtag === 'function' && window.__RDS_ADS_WA_LABEL__ && window.__RDS_ADS_ID__) {
                    gtag('event', 'conversion', {
                        'send_to': window.__RDS_ADS_ID__ + '/' + window.__RDS_ADS_WA_LABEL__
                    });
                }
                if (typeof dataLayer !== 'undefined') {
                    dataLayer.push({ 'event': 'whatsapp_click' });
                }
            });
        }
    } catch (e) { /* stil falen */ }
})();

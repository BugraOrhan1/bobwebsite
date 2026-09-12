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

/* ---- v2: voor/na-slider ---- */
(function () {
    'use strict';
    function setPos(slider, pct) {
        pct = Math.max(0, Math.min(100, pct));
        var after = slider.querySelector('.ba-slider__after');
        var divider = slider.querySelector('.ba-slider__divider');
        var handle = slider.querySelector('.ba-slider__handle');
        if (after) after.style.clipPath = 'inset(0 0 0 ' + pct + '%)';
        if (divider) divider.style.left = pct + '%';
        if (handle) handle.style.left = pct + '%';
    }
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.ba-slider').forEach(function (slider) {
            var range = slider.querySelector('.ba-slider__range');
            if (!range) return;
            range.addEventListener('input', function () { setPos(slider, +range.value); });
            setPos(slider, 50);
        });
    });
})();

/* ---- v2: cookie-toestemming ---- */
(function () {
    'use strict';
    function getCookie(name) {
        var m = document.cookie.match(new RegExp('(?:^|;\\s*)' + name + '=([^;]+)'));
        return m ? decodeURIComponent(m[1]) : null;
    }
    function setCookie(name, value, days) {
        var d = new Date();
        d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
        document.cookie = name + '=' + encodeURIComponent(value) +
            ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
    }
    document.addEventListener('DOMContentLoaded', function () {
        var bar = document.getElementById('cookie-bar');
        if (!bar) return;
        if (getCookie('rd_consent') !== null) { bar.remove(); return; }
        bar.style.display = 'flex';
        bar.querySelector('.cookie-bar__accept')?.addEventListener('click', function () {
            setCookie('rd_consent', 'yes', 180);
            window.location.reload();
        });
        bar.querySelector('.cookie-bar__decline')?.addEventListener('click', function () {
            setCookie('rd_consent', 'no', 30);
            bar.remove();
        });
    });
})();

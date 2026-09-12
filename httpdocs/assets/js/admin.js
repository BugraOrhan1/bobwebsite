/**
 * Admin-paneel JS:
 * - Mini rich-text editor voor textarea's met class "richtext"
 */
(function () {
    'use strict';

    function buildEditor(ta) {
        ta.style.display = 'none';

        var wrap = document.createElement('div');
        wrap.className = 'rte';

        var toolbar = document.createElement('div');
        toolbar.className = 'rte-toolbar';

        var buttons = [
            ['B', 'bold', 'Vet'],
            ['I', 'italic', 'Cursief'],
            ['H2', 'formatBlock', 'h2', 'Kop'],
            ['H3', 'formatBlock', 'h3', 'Subkop'],
            ['• lijst', 'insertUnorderedList', 'Lijst'],
            ['🔗', 'link', 'Link'],
            ['⌫ opmaak', 'removeFormat', 'Opmaak wissen']
        ];

        buttons.forEach(function (b) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = b[0];
            btn.title = b[2];
            btn.addEventListener('mousedown', function (e) { e.preventDefault(); });
            btn.addEventListener('click', function () {
                area.focus();
                if (b[1] === 'link') {
                    var url = prompt('URL van de link:', 'https://');
                    if (url) document.execCommand('createLink', false, url);
                } else if (b[1] === 'formatBlock') {
                    document.execCommand('formatBlock', false, b[2]);
                } else {
                    document.execCommand(b[1], false, null);
                }
                sync();
            });
            toolbar.appendChild(btn);
        });

        var area = document.createElement('div');
        area.className = 'rte-area';
        area.contentEditable = 'true';
        // Basis-HTML tonen: nieuwe regels -> <p>
        var raw = ta.value.trim();
        if (raw.indexOf('<') !== -1) {
            area.innerHTML = raw;
        } else {
            area.innerHTML = raw.split(/\n{2,}/).map(function (p) {
                var lines = p.split(/\n/).map(function (l) {
                    if (/^[-*]\s+/.test(l)) return l.replace(/^[-*]\s+/, '');
                    return l;
                });
                return '<p>' + lines.join('<br>') + '</p>';
            }).join('');
        }

        function sync() { ta.value = area.innerHTML; }
        area.addEventListener('input', sync);
        area.addEventListener('blur', sync);

        wrap.appendChild(toolbar);
        wrap.appendChild(area);
        ta.parentNode.insertBefore(wrap, ta);
    }

    document.querySelectorAll('textarea.richtext').forEach(buildEditor);
})();

(function () {
    'use strict';

    function renderTurnstiles() {
        if (!window.turnstile || !window.sedgemoreTurnstile || !sedgemoreTurnstile.sitekey) {
            window.setTimeout(renderTurnstiles, 100);
            return;
        }

        document.querySelectorAll('form').forEach(function (form) {
            // Search forms do not submit an enquiry and should not be challenged.
            if (form.matches('[role="search"], .search-form') || form.querySelector('.cf-turnstile')) {
                return;
            }

            var container = document.createElement('div');
            container.className = 'cf-turnstile';
            container.style.margin = '16px 0';
            form.appendChild(container);

            turnstile.render(container, {
                sitekey: sedgemoreTurnstile.sitekey,
                theme: 'auto',
                'error-callback': function () {
                    container.setAttribute('aria-label', 'Security verification could not load. Please refresh and try again.');
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderTurnstiles);
    } else {
        renderTurnstiles();
    }
}());

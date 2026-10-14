(function () {
    'use strict';

    var protectedActions = [
        'collective_enquiry_form',
        'event_contact_form',
        'home_form',
        'newsletter_subscribe',
        'private_villa_contact_form',
        'travel_contact_form',
        'yacht_contact_form'
    ];
    var apiPromise = null;
    var formObserver = null;
    var observedForms = new WeakSet();
    var widgetIds = new WeakMap();

    function isProtectedForm(form) {
        var action = form.querySelector('input[name="action"]');

        return form.id === 'contact-form' || (action && protectedActions.indexOf(action.value) !== -1);
    }

    function setUnavailable(container) {
        var response = container.closest('form').querySelector('input[name="cf-turnstile-response"]');

        if (response) {
            response.value = '';
        }

        container.setAttribute('aria-label', 'Security verification could not load. Please refresh and try again.');
    }

    function loadApi() {
        if (window.turnstile) {
            return Promise.resolve(window.turnstile);
        }

        if (apiPromise) {
            return apiPromise;
        }

        apiPromise = new Promise(function (resolve, reject) {
            var existing = document.querySelector('script[src*="challenges.cloudflare.com/turnstile/v0/api.js"]');
            var script = existing || document.createElement('script');
            var settled = false;

            function ready() {
                if (settled || !window.turnstile) {
                    return;
                }

                settled = true;
                resolve(window.turnstile);
            }

            function failed() {
                if (settled) {
                    return;
                }

                settled = true;
                reject(new Error('Cloudflare Turnstile failed to load.'));
            }

            script.addEventListener('load', ready, { once: true });
            script.addEventListener('error', failed, { once: true });

            if (!existing) {
                script.id = 'cloudflare-turnstile-api';
                script.src = sedgemoreTurnstile.apiUrl;
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
            }

            if (window.turnstile) {
                ready();
            }
        });

        return apiPromise;
    }

    function renderForm(form) {
        var container = form.querySelector('.cf-turnstile');

        if (!container || widgetIds.has(form) || container.dataset.turnstileLoading === 'true') {
            return;
        }

        container.dataset.turnstileLoading = 'true';

        loadApi().then(function () {
            var widgetId = window.turnstile.render(container, {
                sitekey: sedgemoreTurnstile.sitekey,
                theme: 'auto',
                'expired-callback': function () {
                    setUnavailable(container);
                    window.turnstile.reset(widgetId);
                },
                'error-callback': function () {
                    setUnavailable(container);
                },
                'timeout-callback': function () {
                    setUnavailable(container);
                    window.turnstile.reset(widgetId);
                }
            });

            widgetIds.set(form, widgetId);
            container.dataset.turnstileRendered = 'true';
            delete container.dataset.turnstileLoading;
        }).catch(function () {
            delete container.dataset.turnstileLoading;
            setUnavailable(container);
        });
    }

    function prepareForm(form) {
        var container;

        if (!isProtectedForm(form) || observedForms.has(form)) {
            return;
        }

        observedForms.add(form);
        container = form.querySelector('.cf-turnstile');

        if (!container) {
            container = document.createElement('div');
            container.className = 'cf-turnstile';
            container.setAttribute('role', 'group');
            container.setAttribute('aria-label', 'Security verification');
            container.style.margin = '16px 0';
            container.style.minHeight = '65px';
            form.appendChild(container);
        }

        if (formObserver) {
            formObserver.observe(container);
        } else {
            renderForm(form);
        }
    }

    function discoverForms(root) {
        if (root.nodeType !== 1 && root.nodeType !== 9) {
            return;
        }

        if (root.matches && root.matches('form')) {
            prepareForm(root);
        }

        root.querySelectorAll('form').forEach(prepareForm);
    }

    function initialize() {
        if (!window.sedgemoreTurnstile || !sedgemoreTurnstile.sitekey || !sedgemoreTurnstile.apiUrl) {
            return;
        }

        if ('IntersectionObserver' in window) {
            formObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    formObserver.unobserve(entry.target);
                    renderForm(entry.target.closest('form'));
                });
            }, {
                rootMargin: '600px 0px'
            });
        }

        discoverForms(document);

        if ('MutationObserver' in window) {
            new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    mutation.addedNodes.forEach(discoverForms);
                });
            }).observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }
}());

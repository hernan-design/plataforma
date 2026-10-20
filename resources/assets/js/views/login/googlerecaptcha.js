/**
 * Class GoogleRecaptchaView & Invisible reCAPTCHA Handler
 * @author TuProyecto
 */
(function (window, document) {
    'use strict';

    function initRecaptchaForForm(formSelector, widgetSelector) {
        var form = document.querySelector(formSelector);
        if (!form) return;

        var widgetEl = form.querySelector(widgetSelector);
        if (!widgetEl) return;

        var siteKey = widgetEl.getAttribute('data-key-recaptcha');
        if (!siteKey) return;

        var widgetId = null;
        var isVerifying = false;

        function renderWidget() {
            if (typeof window.grecaptcha !== 'undefined' && typeof window.grecaptcha.render === 'function') {
                if (widgetId !== null) return;
                try {
                    widgetId = window.grecaptcha.render(widgetEl, {
                        'sitekey': siteKey,
                        'size': 'invisible',
                        'callback': function (token) {
                            isVerifying = false;
                            console.log('reCAPTCHA invisible: token received successfully');

                            // Remove previous hidden recaptcha input if present
                            var oldInput = form.querySelector('input[name="g-recaptcha-response"]');
                            if (oldInput) {
                                oldInput.remove();
                            }

                            // Append token input
                            var input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'g-recaptcha-response';
                            input.value = token;
                            form.appendChild(input);

                            // Native form submit bypasses all JS listeners and submits directly
                            HTMLFormElement.prototype.submit.call(form);
                        },
                        'error-callback': function () {
                            isVerifying = false;
                            console.error('reCAPTCHA invisible: error callback fired');
                        }
                    });
                    console.log('reCAPTCHA invisible initialized on', formSelector, 'with widgetId:', widgetId);
                } catch (err) {
                    console.warn('reCAPTCHA render error:', err);
                }
            } else {
                setTimeout(renderWidget, 200);
            }
        }

        renderWidget();

        function handleIntercept(e) {
            // Check if we already have the token
            var tokenInput = form.querySelector('input[name="g-recaptcha-response"]');
            if (tokenInput && tokenInput.value && tokenInput.value.length > 0) {
                return true; // Let submit proceed
            }

            // Check if required inputs are filled before triggering reCAPTCHA
            var emailInput = form.querySelector('input[name="correo_electronico"]');
            var passInput = form.querySelector('input[name="password"]');

            if (emailInput && (!emailInput.value || !emailInput.value.trim())) {
                return; // Let standard validation show errors
            }
            if (passInput && (!passInput.value || !passInput.value.trim())) {
                return;
            }

            // Stop the native submission
            e.preventDefault();
            e.stopPropagation();
            if (e.stopImmediatePropagation) {
                e.stopImmediatePropagation();
            }

            if (isVerifying) return false;

            if (widgetId !== null && window.grecaptcha && typeof window.grecaptcha.execute === 'function') {
                isVerifying = true;
                console.log('Executing invisible reCAPTCHA for', formSelector);
                window.grecaptcha.execute(widgetId);
            } else {
                var retries = 0;
                var interval = setInterval(function () {
                    retries++;
                    if (widgetId !== null && window.grecaptcha && typeof window.grecaptcha.execute === 'function') {
                        clearInterval(interval);
                        isVerifying = true;
                        window.grecaptcha.execute(widgetId);
                    } else if (retries > 20) {
                        clearInterval(interval);
                        console.warn('reCAPTCHA not ready after timeout, submitting form directly');
                        HTMLFormElement.prototype.submit.call(form);
                    }
                }, 200);
            }

            return false;
        }

        // Intercept both submit event and submit button click in capture phase
        form.addEventListener('submit', handleIntercept, true);

        var submitBtn = form.querySelector('input[type="submit"], button[type="submit"]');
        if (submitBtn) {
            submitBtn.addEventListener('click', handleIntercept, true);
        }
    }

    function initAll() {
        initRecaptchaForForm('#form-login-email', '.widget-login-recaptcha-new');
        initRecaptchaForForm('#form-new-account', '.widget-login-recaptcha-new');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})(window, document);

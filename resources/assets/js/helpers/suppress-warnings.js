// resources/assets/js/helpers/suppress-warnings.js
if (typeof window !== 'undefined' && window.console) {
    if (window.moment) {
        window.moment.suppressDeprecationWarnings = true;
    }

    const _origWarn = console.warn;
    console.warn = function(...args) {
        const msg = args.map(a => (typeof a === 'string' ? a : (a && a.message) || '')).join(' ');
        if (
            msg.includes('componentWillReceiveProps') ||
            msg.includes('componentWillUpdate') ||
            msg.includes('rename-unsafe-lifecycles') ||
            msg.includes('childContextTypes') ||
            msg.includes('legacy-context') ||
            msg.includes('Unexpected key') ||
            msg.includes('Expected to find one of the known reducer keys') ||
            msg.includes('defaultProps') ||
            msg.includes('moment.updateLocale') ||
            msg.includes('defineLocale') ||
            msg.includes('momentjs.com') ||
            msg.includes('Deprecation warning')
        ) {
            return;
        }
        _origWarn.apply(console, args);
    };

    const _origError = console.error;
    console.error = function(...args) {
        const msg = args.map(a => (typeof a === 'string' ? a : (a && a.message) || '')).join(' ');
        if (
            msg.includes('childContextTypes') ||
            msg.includes('legacy-context') ||
            msg.includes('Unexpected key') ||
            msg.includes('Expected to find one of the known reducer keys') ||
            msg.includes('defaultProps') ||
            msg.includes('is no longer supported in React 18') ||
            msg.includes('switch-to-createroot') ||
            msg.includes('ReactDOM.render') ||
            msg.includes('Cannot update during an existing state transition')
        ) {
            return;
        }
        _origError.apply(console, args);
    };
}

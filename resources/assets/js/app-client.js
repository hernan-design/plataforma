import './helpers/suppress-warnings';
window.process = window.process || { env: { NODE_ENV: 'development' } };
import '../config';
import initApp from './init-app';
import React from 'react';
import { render } from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import { renderRoutes } from 'react-router-config';
import routes from './routers/reactroutes';
import { recipesToImmutable } from './helpers/redux-utils';

import { Provider } from 'react-redux';
import factoryStore from './stores/store';

import { camelizeKeys } from 'humps';

let preloadedState = window.__PRELOADED_STATE__ || {};

// Normalize preloaded categories and channels from backend if present
if (preloadedState.forum && Array.isArray(preloadedState.forum.categories)) {
    preloadedState.forum.categories = camelizeKeys(preloadedState.forum.categories);
}
if (preloadedState.channel) {
    if (Array.isArray(preloadedState.channel.categories)) {
        preloadedState.channel.categories = camelizeKeys(preloadedState.channel.categories);
    }
    if (Array.isArray(preloadedState.channel.channels)) {
        preloadedState.channel.channels = camelizeKeys(preloadedState.channel.channels);
    }
}

// rewrite pagination recipe reducers to set like immutable values
preloadedState = recipesToImmutable(preloadedState);

// set environment variables of preloaded state
if(preloadedState.session) {
    if(preloadedState.session.rootUrl) process.env.host = preloadedState.session.rootUrl;
    if(preloadedState.session.slugInstitution) process.env.SLUG_INSTITUTION = preloadedState.session.slugInstitution;
}
if (window.document && window.document.url) {
    process.env.host = window.document.url;
}

function logClientError(errData) {
    try {
        fetch('/api/debug-log', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(errData)
        }).catch(() => {});
    } catch(e) {}
}

window.onerror = function(msg, url, line, col, error) {
    logClientError({ type: 'window.onerror', msg, url, line, col, stack: error ? error.stack : null });
};
window.addEventListener('unhandledrejection', function(event) {
    logClientError({ type: 'unhandledrejection', reason: String(event.reason), stack: event.reason && event.reason.stack });
});

class ErrorBoundary extends React.Component {
    constructor(props) {
        super(props);
        this.state = { hasError: false, error: null };
    }
    static getDerivedStateFromError(error) {
        return { hasError: true, error };
    }
    componentDidCatch(error, errorInfo) {
        logClientError({
            type: 'ErrorBoundary',
            message: error.message,
            stack: error.stack,
            componentStack: errorInfo.componentStack
        });
    }
    render() {
        if (this.state.hasError) {
            return (
                <div style={{ padding: '20px', color: 'red', background: '#ffebee', border: '1px solid #ef5350', margin: '20px' }}>
                    <h3>Error de renderizado en React</h3>
                    <pre>{this.state.error && this.state.error.toString()}</pre>
                    <pre>{this.state.error && this.state.error.stack}</pre>
                </div>
            );
        }
        return this.props.children;
    }
}

import { dynamicRecipes as dynamicRecipeForums } from './stores/forum';

const store = factoryStore(preloadedState);
if (preloadedState.forum && Array.isArray(preloadedState.forum.categories) && preloadedState.forum.categories.length) {
    dynamicRecipeForums(preloadedState.forum.categories, { replace: true });
}

const AppClient = () => (
    <Provider store={store}>
        <Router basename={ process.env.NODE_ENV !== 'production' || process.env.TEST ? process.env.BASE_PATHNAME : '' }>
            <ErrorBoundary>
                {renderRoutes(routes)}
            </ErrorBoundary>
        </Router>
    </Provider>
);

window.onload = () => {
    const wrapComponents = document.getElementById('wrap-components');
    
    if (wrapComponents) {
        render(<AppClient />, wrapComponents, () => {
            // initialize app plugins
            initApp();

            // Allow the passed state to be garbage-collected
            delete window.__PRELOADED_STATE__;
        });
    } else {
        // initialize app plugins even if React isn't mounted
        initApp();
        delete window.__PRELOADED_STATE__;
    }
};

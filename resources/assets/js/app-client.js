// resources/assets/js/app-client.js
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

let preloadedState = window.__PRELOADED_STATE__;

// rewrite pagination recipe reducers to set like immutable values
preloadedState = recipesToImmutable(preloadedState);

// set environment variables of preloaded state
if(preloadedState.session) {
    if(preloadedState.session.rootUrl) process.env.host = preloadedState.session.rootUrl;
    if(preloadedState.session.slugInstitution) process.env.SLUG_INSTITUTION = preloadedState.session.slugInstitution;
}

const AppClient = () => (
    <Provider store={factoryStore(preloadedState)}>
        <Router basename={ process.env.NODE_ENV !== 'production' || process.env.TEST ? process.env.BASE_PATHNAME : '' }>
            {renderRoutes(routes)}
        </Router>
    </Provider>
);

window.onload = () => {
    render(<AppClient />, document.getElementById('wrap-components'), () => {
        // initialize app plugins
        initApp();

        // Allow the passed state to be garbage-collected
        delete window.__PRELOADED_STATE__;
    });
};

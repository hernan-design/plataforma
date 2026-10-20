// resources/assets/js/stores/store.js
import { combineReducers, applyMiddleware } from 'redux';
import { createStore } from 'redux-dynamic-reducer';
import { composeWithDevTools } from 'redux-devtools-extension/developmentOnly';
import thunkMiddleware from 'redux-thunk';
import apiMiddleware from '../middleware/api';
import { initializeStore, middleware as paginateMiddleware } from '@orange-marmalade/paginate-this';

//
// Variables
//
// compose
const composeEnhancers = composeWithDevTools({});

// define middlewares to pass when to create the store of redux
const middlewares = [thunkMiddleware, apiMiddleware];

import { setStore } from './store-registry';

// compose
const mainMiddleware = midds => applyMiddleware.apply(null, midds);

// Do not use paginateMiddleware.spill as it crashes with undefined.toJS() on dynamic sub-reducers
// if( process.env.NODE_ENV !== 'production' && typeof window !== 'undefined' ) {
//     middlewares.push(paginateMiddleware.spill);
// }

import * as reducers from './index';

//
// Reducers
//
export default function factoryStore(preloadedState) {
    const rootReducer = combineReducers(reducers);

    const store = createStore( rootReducer, preloadedState, composeEnhancers(
        mainMiddleware(middlewares)
    ));
    setStore(store);

    initializeStore(store);

    return store;
}

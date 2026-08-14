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
let useStore = null;
// compose
const composeEnhancers = composeWithDevTools({});

// define middlewares to pass when to create the store of redux
const middlewares = [thunkMiddleware, apiMiddleware];

//
// Functions
//
export function attachReducers(newReducers = {}) {
    useStore.attachReducers(newReducers);
}
const mainMiddleware = midds => applyMiddleware.apply(null, midds);

if( process.env.NODE_ENV !== 'production' && typeof window !== 'undefined' ) {
    middlewares.push(paginateMiddleware.spill);
}

//
// Reducers
//
export default function factoryStore(preloadedState) {
    const reducers = require('./');
    const rootReducer = combineReducers(reducers);

    const store = useStore = createStore( rootReducer, preloadedState, composeEnhancers(
        mainMiddleware(middlewares)
    ));

    initializeStore(store);

    return store;
}

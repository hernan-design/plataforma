// resources/js/stores/like.js
import { fetchCreator, storeCreator, deleteCreator } from '../middleware/api';
import createPaginator from './paginator';
import laroute from '../helpers/laroute.js';
import { formatMessage } from '../init-app';
import { TypedError, actionCreators as errorActions } from './error-message';
import { camelizeKeys } from 'humps';
import { get as getProp } from 'lodash';
import { Map } from 'immutable';
import {
    buildActionType as actionType,
    composeDynamicReducers,
    defaultLocator,
    namedContent
} from '../helpers/redux-utils';

// ----------------
// initial settings
// ----------------
const initialState = {
    recipes: {}
};
const stateMap = {};
const defaultSettings = {
    codigoLike: null,
    parentSrcparams: '',
    srcparams: '',
    valueTxt: formatMessage('like/ilike_text'),
    authLike: false,
    contadorLike: 0,
    givingIlike: false
};

// set constant to define the reducer id name
export const RECIPE_ID = 'recipeLike';
// set constant to define the list id name
export const LIST_ID = 'recipeLikes';

// ----------------
// function helpers
// ----------------
/**
 * build like recipe for every entry
 * @param { Array|Object } entries
 * @param { Object } options
 */
export const dynamicRecipes = composeDynamicReducers({
    location: 'like',
    nameReducer: (entry) => `${RECIPE_ID}_${entry.cod}`,
    createReducer: (entry, { dynamicName, location, updateCounter, ...restConfig }) => {
        if(
            entry.cod &&
            entry.srcparams
        ) {
            return createLike({
                recipeId: dynamicName,
                locator: state => {
                    const loc = getProp(state, location);
                    return (loc && loc[dynamicName]) || defaultSettings;
                },
                updaterCounter: updateCounter(entry),
                initialSettings: {
                    parentSrcparams: entry.srcparams,
                    contadorLike: entry.contadorLike
                },
                ...restConfig
            });
        }
        return false;
    }
});
/**
 * build likes recipe for every entry
 * @param { Array|Object } entries
 * @param { Object } options
 */
export const dynamicRecipeLikes = composeDynamicReducers({
    location: 'like.recipes',
    nameReducer: (entry) => `${LIST_ID}_${entry.cod}`,
    createReducer: (entry, { dynamicName, location, updateCounter, ...restConfig }) => {
        if(
            entry.cod &&
            entry.srcparams
        ) {
            return createRecipeLikes({
                listId: dynamicName,
                locator: state => {
                    const loc = getProp(state, location);
                    return (loc && loc[dynamicName]) || Map();
                },
                initialSettings: {
                    pageSize: 15,
                    filters: {
                        srcparams: entry.srcparams
                    }
                },
                ...restConfig
            });
        }
        return false;
    }
});

/**
 * @param {String} recipeId
 * @param {Any} state
 * @return current state
 */
export function getLike(recipeId, state) {
    const config = stateMap[recipeId] || {
        locator: defaultLocator(recipeId)
    };

    return config.locator(state) || defaultSettings;
};

// ------------
// action types
// ------------
export const actionTypes = {
    'LIKES_REQUEST': '@@like/LIKES_REQUEST',
    'LIKES_SUCCESS': '@@like/LIKES_SUCCESS',
    'LIKES_FAILURE': '@@like/LIKES_FAILURE',
    'LIKE_REQUEST': '@@like/LIKE_REQUEST',
    'LIKE_SUCCESS': '@@like/LIKE_SUCCESS',
    'LIKE_FAILURE': '@@like/LIKE_FAILURE',
    'CREATE_LIKE_REQUEST': '@@like/CREATE_LIKE_REQUEST',
    'CREATE_LIKE_SUCCESS': '@@like/CREATE_LIKE_SUCCESS',
    'CREATE_LIKE_FAILURE': '@@like/CREATE_LIKE_FAILURE',
    'DELETE_LIKE_REQUEST': '@@like/DELETE_LIKE_REQUEST',
    'DELETE_LIKE_SUCCESS': '@@like/DELETE_LIKE_SUCCESS',
    'DELETE_LIKE_FAILURE': '@@like/DELETE_LIKE_FAILURE',
    'FILL_LIKE_FEATURES': '@@like/FILL_LIKE_FEATURES',
    'RESET_LIKE': '@@like/RESET_LIKE',
    'GIVING_ILIKE': '@@like/GIVING_ILIKE'
};

// -----------------------------------
// functions to consume api resources
// -----------------------------------
let cancelFecth = null;

// ---------------
// action creators
// ---------------
function actionCreators(config) {
    const { recipeId, ...restConfig } = config;
    const resolve = t => actionType(t, recipeId);

    stateMap[recipeId] = {
        ...(stateMap[recipeId] || { locator: defaultLocator(recipeId) }),
        ...restConfig
    };

    const _actionCreators =  {
        fillFeatures: (data) => ({
            type: resolve(actionTypes.FILL_LIKE_FEATURES),
            data
        }),
        givingILike: () => ({
            type: resolve(actionTypes.GIVING_ILIKE)
        }),
        resetLike: (data) => ({
            type: resolve(actionTypes.RESET_LIKE),
            data
        }),

        // bound action creators
        // ---------------------
        fetchOneLike: (srcparams) => (dispatch, getState) => {
            const recipe = getLike(recipeId, getState());
            const parentSrcparams = srcparams || recipe.parentSrcparams;

            const fetchData = fetchCreator([
                resolve(actionTypes.LIKE_REQUEST),
                resolve(actionTypes.LIKE_SUCCESS),
                resolve(actionTypes.LIKE_FAILURE)
            ], laroute.route('like.show', { like: parentSrcparams }), cancelFecth);

            const promise = dispatch(fetchData());
            return promise.then(({ data }) => {
                if(typeof data.success !== 'undefined' && !data.success) {
                    // set error message
                    const error = new TypedError(data.errors, { type: 'alert' });
                    return error;
                }

                dispatch(_actionCreators.fillFeatures({ ...data, parentSrcparams }));

                return data;
            });
        },
        storeLike: (sendData = {}) => (dispatch, getState) => {
            const { session } = getState();
            const recipe = getLike(recipeId, getState());
            const parentSrcparams = sendData.srcparams || recipe.parentSrcparams;

            const newData = {
                auth_like: !recipe.authLike
            };

            const storeData = storeCreator([
                resolve(actionTypes.CREATE_LIKE_REQUEST),
                resolve(actionTypes.CREATE_LIKE_SUCCESS),
                resolve(actionTypes.CREATE_LIKE_FAILURE)
            ], laroute.route('like.store'));

            dispatch(_actionCreators.givingILike());
            dispatch(_actionCreators.fillFeatures(
                camelizeKeys({
                    contadorLike: recipe.contadorLike + 1,
                    parentSrcparams,
                    ...newData
                })
            ));

            const promise = dispatch(storeData({
                srcparams: recipe.parentSrcparams,
                _token: session.csrftoken,
                ...newData,
                ...sendData
            }));

            return promise.then(({ data }) => {
                if(typeof data.success !== 'undefined' && !data.success) {
                    dispatch(_actionCreators.resetLike(recipe));

                    // set error message
                    const error = new TypedError(data.errors, { type: 'alert' });
                    return error;
                }

                dispatch(_actionCreators.fillFeatures(data));

                return data;
            });
        },
        destroyLike: (sendData = {}) => (dispatch, getState) => {
            const { session } = getState();
            const recipe = getLike(recipeId, getState());

            const newData = {
                srcparams: sendData.srcparams || recipe.srcparams,
                auth_like: !recipe.authLike
            };

            const deleteData = deleteCreator([
                resolve(actionTypes.DELETE_LIKE_REQUEST),
                resolve(actionTypes.DELETE_LIKE_SUCCESS),
                resolve(actionTypes.DELETE_LIKE_FAILURE)
            ], params => laroute.route('like.destroy', params));

            dispatch(_actionCreators.givingILike());
            dispatch(_actionCreators.fillFeatures(
                camelizeKeys({
                    contadorLike: recipe.contadorLike - 1,
                    ...newData
                })
            ));

            const promise = dispatch(deleteData({
                like: sendData.codigoLike || recipe.codigoLike
            }, {
                _token: session.csrftoken,
                ...newData,
                ...sendData
            }));

            return promise.then(({ data }) => {
                if(typeof data.success !== 'undefined' && !data.success) {
                    dispatch(_actionCreators.resetLike(recipe));

                    // set error message
                    const error = new TypedError(data.errors, { type: 'alert' });
                    return error;
                }

                dispatch(_actionCreators.fillFeatures(data));

                return data;
            });
        }
    };

    return _actionCreators;
}
export function composables(config) {
    return actionCreators(config);
}

// --------
// reducers
// --------
// higher order reducer to build a likes recipe reducer
export function createRecipeLikes(pageConfig) {
    const listId = pageConfig.listId || LIST_ID;
    const resolve = t => actionType(t, listId);

    const defaultConfig = {
        listId,
        cache: false,
        initialSettings: {
            pageSize: 15
        },
        pageParams: {
            endpoint: params => laroute.route('like.index', params),
            loadTypes: [
                resolve(actionTypes.LIKES_REQUEST),
                resolve(actionTypes.LIKES_SUCCESS),
                resolve(actionTypes.LIKES_FAILURE)
            ],
            cancelFecth
        }
    };

    const config = {...defaultConfig, ...pageConfig};

    return createPaginator(config);
}
// higher order reducer to build a like reducer
export function createLike(config) {
    const recipeId = config.recipeId || RECIPE_ID;
    const resolve = t => actionType(t, recipeId);

    const likeActions = actionCreators(config);
    const initialSettings = { ...defaultSettings, ...(config.initialSettings || {}) };

    return (state = initialSettings, action) => {
        const { type, data } = action;

        if(type === resolve(actionTypes.FILL_LIKE_FEATURES)) {
            return { ...state, ...data };
        }
        if(type === resolve(actionTypes.GIVING_ILIKE)) {
            return { ...state, givingIlike: true };
        }
        if(type === resolve(actionTypes.RESET_LIKE)) {
            return data;
        }
        if(type === resolve(actionTypes.DELETE_LIKE_SUCCESS)) {
            return {
                ...state,
                authLike: false,
                givingIlike: false
            };
        }
        if(
            type === resolve(actionTypes.CREATE_LIKE_SUCCESS) ||
            type === resolve(actionTypes.CREATE_LIKE_FAILURE) ||
            type === resolve(actionTypes.DELETE_LIKE_FAILURE)
        ) {
            return { ...state, givingIlike: false };
        }

        return state;
    }
}
export default function reducer(state = initialState, action) {
    const { type, payload, error, data } = action;

    return state;
}

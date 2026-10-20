// resources/assets/js/stores/paginator.js
import Immutable, { List, Map } from 'immutable';
import {
    createPaginator as createPaginate,
    composables as composablesPaginate,
    configurePageParams,
    getPaginator
} from '@orange-marmalade/paginate-this';
import { listConfig } from '@orange-marmalade/paginate-this/dist/lib/stateManagement';
import { fetchCreator, storeCreator } from '../middleware/api';
import { TypedError, actionCreators as errorActions } from './error-message';

const stateMap = {};
const actionType = (t, id) => {
  return `${t}_${id}`;
}

// ------------
// action types
// ------------
export const actionTypes = {
    ATTACH_ENTRIES: '@@paginator/ATTACH_ENTRIES',
    ADDING_ITEM: '@@paginator/ADDING_ITEM',
    ADD_ITEM: '@@paginator/ADD_ITEM',
    ADD_FAILED: '@@paginator/ADD_FAILED',
    REMOVING_ITEM_ALT: '@@paginator/REMOVING_ITEM_ALT',
    REMOVE_ITEM_ALT: '@@paginator/REMOVE_ITEM_ALT'
};

// ---------------
// action creators
// ---------------
function actionCreators(config) {
    const { listId, ...restConfig } = config;
    const pageActions = composablesPaginate({ listId });
    stateMap[listId] = {
        ...(stateMap[listId] || {}),
        ...restConfig
    };

    const _actionCreators = {
        attachEntries: (attachItems = []) => ({
            type: actionType(actionTypes.ATTACH_ENTRIES, listId),
            attachResults: attachItems
        }),
        addItem: (itemData, directionTo) => ({
            type: actionType(actionTypes.ADD_ITEM, listId),
            directionTo: directionTo || 'end', // start or end(default)
            itemData
        }),
        addingItem: () => ({
            type: actionType(actionTypes.ADDING_ITEM, listId)
        }),
        addFailed: (itemData) => ({
            type: actionType(actionTypes.ADD_FAILED, listId),
            itemData
        }),
        removingItemAlt: (itemId) => ({
            type: actionType(actionTypes.REMOVING_ITEM_ALT, listId),
            itemId
        }),
        removeItemAlt: (itemId) => ({
            type: actionType(actionTypes.REMOVE_ITEM_ALT, listId),
            itemId
        }),

        // bound action creators
        // ---------------------
        loadByState: (state, value, time = 0) => (dispatch) => {
            dispatch(pageActions.resetResults([]));

            const update = () => {
                dispatch(pageActions.setFilter(state, value || undefined));
                return dispatch(pageActions.reload());
            };

            if(time) {
                return new Promise(resolve => {
                    setTimeout(() => (
                        resolve(update())
                    ), time)
                });
            }

            return update();
        },
        loadByStates: (states, time = 0) => (dispatch) => {
            dispatch(pageActions.resetResults([]));

            const update = () => {
                dispatch(pageActions.setFilters(states));
                return dispatch(pageActions.reload());
            };

            if(time) {
                return new Promise(resolve => {
                    setTimeout(() => {
                        resolve(update())
                    }, time);
                });
            }

            return update();
        },
        loadByResetStates: (states, time = 0) => (dispatch) => {
            dispatch(pageActions.resetResults([]));

            const update = () => {
                dispatch(pageActions.resetFilters(states));
                return dispatch(pageActions.reload());
            };

            if(time) {
                return new Promise(resolve => {
                    setTimeout(() => {
                        resolve(update())
                    }, time);
                });
            }

            return update();
        },
        infinityAsync: (fetchAction) => (dispatch, getState) => {
            const { params:{ totalCountProp, resultsProp } } = listConfig(listId);
            if(!fetchAction) { return Promise.resolve(null); }

            const recipe = getPaginator(listId, getState());
            const promise = dispatch(fetchAction);

            return promise.then(resp => {
                const attachedItems = recipe.get('page') > 1 ? recipe.get('prevResults').toJS().concat(resp.data[resultsProp]) : resp.data[resultsProp];

                // attach new entries to previous results
                dispatch(_actionCreators.attachEntries(resp.data[resultsProp]));

                return {
                    data: {
                        [resultsProp]: attachedItems,
                        [totalCountProp]: resp.data[totalCountProp]
                    }
                };
            });
        },
        addAsync: (storeAction, directionTo) => (dispatch) => {
            if(!storeAction) { return Promise.resolve(null); }

            const promise = dispatch(storeAction);

            dispatch(_actionCreators.addingItem());
            return promise.then(resp => {
                dispatch(_actionCreators.addItem(resp.data, directionTo));

                return resp.data;

            }).catch(err => {
                dispatch(_actionCreators.addFailed())

                throw err;
            });
        },
        removeAsync: (itemId, remove, expire = true) => (dispatch, getState) => {
            const { params:{ idProps } } = listConfig(listId);
            const item = getPaginator(listId, getState()).get('results')
                .find(r => r.get(idProps) === itemId) || Map();

            dispatch(_actionCreators.removingItemAlt(itemId));

            return remove.then(resp => {
                if (expire) {
                    dispatch(pageActions.expire());
                } else {
                    dispatch(pageActions.removeItem(itemId));
                    dispatch(_actionCreators.removeItemAlt(itemId));
                }

                return resp
            }).catch(err => {
                dispatch(pageActions.resetItem(itemId, item.toJS()))
                throw err
            });
        },
        // ----------------------------------------
        // dispatcher actions customize for the app
        // ----------------------------------------
        loadEntries: (pageInfo) => (dispatch, getState) => {
            const { params:{ endpoint, loadTypes } } = listConfig(listId);
            const pageParams = (stateMap[listId] && stateMap[listId].pageParams) || {};
            let cancelFetch = pageParams.cancelFetch;

            // if(typeof cancelFetch === 'function') cancelFetch('Operation canceled by the user.');
            const { page, pageSize, ...restQuery } = pageInfo.query;
            const { session } = getState();

            const fetchData = fetchCreator(loadTypes, endpoint, cancelFetch);

            return dispatch(_actionCreators.infinityAsync(fetchData(
                { 'csrftoken': session.csrftoken },
                {
                    offset: (page - 1) * pageSize,
                    limit: pageSize,
                    ...( JSON.parse(JSON.stringify(restQuery)) )
                }
            )));
        },
        storeEntry: (nameForm, data = {}, directionTo = 'end') => (dispatch, getState) => {
            const { params:{ storeTypes, endpointPost } } = listConfig(listId);
            const { form, session } = getState();

            const storeData = storeCreator(storeTypes, endpointPost);

            const promise = dispatch(_actionCreators.addAsync(storeData({
                'csrftoken': session.csrftoken,
                '_token': session.csrftoken,
                ...(form[nameForm] || {}),
                ...data
            }), directionTo));

            return promise.then(record => {

                if(typeof record.success !== 'undefined' && !record.success) {

                    dispatch(_actionCreators.addFailed(record));
                    // set error message
                    const error = new TypedError(record.errors, { type: 'alert' });
                    dispatch(errorActions.errorMessage(error));

                    return error;
                }

                // dispatch afterStore if, it comming
                stateMap[listId].afterStore && dispatch(stateMap[listId].afterStore(record));

                return record;
            });
        },
        showByState: (state, value, time = 0) => (dispatch) => {
            const pageParams = (stateMap[listId] && stateMap[listId].pageParams) || {};
            const { cancelFetch } = pageParams;
            if(typeof cancelFetch === 'function' && time) cancelFetch(`Operation canceled by the user in filtering: ${listId}.`);

            return dispatch(_actionCreators.loadByState(
                state,
                value,
                time
            ));
        },
        showByStates: (states, time = 0) => (dispatch) => {
            const pageParams = (stateMap[listId] && stateMap[listId].pageParams) || {};
            const { cancelFetch } = pageParams;
            if(typeof cancelFetch === 'function' && time) cancelFetch(`Operation canceled by the user in filtering: ${listId}.`);

            return dispatch(_actionCreators.loadByStates(states, time));
        },
        showByResetStates: (states, time = 0) => (dispatch) => {
            const pageParams = (stateMap[listId] && stateMap[listId].pageParams) || {};
            const { cancelFetch } = pageParams;
            if(typeof cancelFetch === 'function' && time) cancelFetch(`Operation canceled by the user in filtering: ${listId}.`);

            return dispatch(_actionCreators.loadByResetStates(states, time));
        }
    };

    return _actionCreators;
}
export function composables(config) {
    return {
        ...composablesPaginate(config),
        ...actionCreators(config)
    }
};

// Higher order for create a paginator reducer
// @param config Object
export default function createPaginator(config) {
    const resolve = t => actionType(t, config.listId);

    const identifier = (config.pageParams && config.pageParams.idProps) || 'cod';
    // Initial configuration for pagination config
    configurePageParams({
        id: identifier
    });

    // reference to actions customize for the app
    const pageActions = actionCreators(config);

    return createPaginate({
        listId: config.listId,
        fetch: config.fetch || pageActions.loadEntries,
        locator: config.locator || ( state => state[config.listId] ),
        initialSettings: {
            pageSize: 15,
            prevResults: [],
            isAdding: false,
            ...(config.initialSettings || {})
        },
        pageParams: {
            resultsProp: 'items',
            totalCountProp: 'totalEntries',
            ...(config.pageParams || {})
        },
        cache: typeof config.cache !== 'undefined' ? config.cache : true,
        augmentWith: {
            [resolve(actionTypes.ATTACH_ENTRIES)]: (state, action) => {
                let prevResults = List();

                if( state.get('page') > 1 ) {
                    prevResults = state.get('prevResults').toList();
                }

                return state.merge({
                    prevResults: prevResults.concat(Immutable.fromJS(action.attachResults))
                });
            },
            [resolve(actionTypes.ADDING_ITEM)]: (state, action) => {
                return state.set('isAdding', true);
            },
            [resolve(actionTypes.ADD_ITEM)]: (state, action) => {
                const directionTo = (action.directionTo && action.directionTo === 'start') ? 'unshift' : 'push';

                return state.merge({
                    totalCount: state.get('totalCount') + 1,
                    results: state.get('results').toList()[directionTo](Immutable.fromJS(action.itemData)),
                    prevResults: state.get('prevResults').toList()[directionTo](Immutable.fromJS(action.itemData)),
                    isAdding: false
                });
            },
            [resolve(actionTypes.ADD_FAILED)]: (state, action) => {
                const results = state.get('results').toList();
                const prevResults = state.get('prevResults').toList();
                const mapItem = Immutable.fromJS(action.itemData);
                let modified = {};

                if(
                    typeof action.itemData === 'object' &&
                    Object.keys(action.itemData).length
                ) {
                    Object.assign(modified, {
                        totalCount: state.get('totalCount') - 1,
                        results: results.filter( item => !Immutable.is(item, mapItem) ),
                        prevResults: prevResults.filter( item => !Immutable.is(item, mapItem) )
                    });
                }

                return state.merge({
                    isAdding: false,
                    ...modified
                });
            },
            [resolve(actionTypes.REMOVING_ITEM_ALT)]: (state, action) => {
                return state.set('removing', state.get('removing').toSet().add(action.itemId))
            },
            [resolve(actionTypes.REMOVE_ITEM_ALT)]: (state, action) => {
                return state.merge({
                    prevResults: state.get('prevResults').filter(
                        item => item.get(identifier) !== action.itemId
                    )
                });
            },
            ...(config.augmentWith || {})
        }
    });
}

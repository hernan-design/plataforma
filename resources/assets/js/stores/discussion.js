// resources/assets/js/stores/discussion.js
import laroute from '../helpers/laroute.js';
import { deleteCreator } from '../middleware/api';
import createPaginator, { composables } from './paginator';
import { dynamicRecipes as dynamicComments } from './discussion-comment';
import { dynamicRecipes as dynamicLikes, dynamicRecipeLikes } from './like';
import { getItem } from '@orange-marmalade/paginate-this';
import { get as getProp } from 'lodash';
import { getResource } from '../helpers/states';
import {
    buildActionType as actionType,
    composeDynamicReducers,
    namedContent
} from '../helpers/redux-utils';

const initialState = {
    like: {
        recipes: {}
    }
};
const stateMap = {};

// set constant to define the list id name
export const LIST_ID = 'recipeDiscussions';

// ----------------
// helper functions
// ----------------
const dynamicName = `_${namedContent(getResource('discusion.gestion'), true)}`

/**
 * build discussion recipes for every entry
 * @param { Array|Object } entries
 * @param { Object } options
 */
export const dynamicRecipes = composeDynamicReducers({
    location: 'discussion',
    nameReducer: (entry) => `${LIST_ID}_${entry.cod}`,
    createReducer: (entry, { dynamicName, location, updateCounter }) => {
        if(entry.cod) {
            return createDiscussion({
                listId: dynamicName,
                locator: state => getProp(state, location)[dynamicName],
                updaterDiscussionCounter: updateCounter(entry)
            });
        }
        return false;
    }
});

// ------------
// action types
// ------------
export const actionTypes = {
    DISCUSSIONS_REQUEST: '@@discussion/DISCUSSIONS_REQUEST',
    DISCUSSIONS_SUCCESS: '@@discussion/DISCUSSIONS_SUCCESS',
    DISCUSSIONS_FAILURE: '@@discussion/DISCUSSIONS_FAILURE',
    CREATE_DISCUSSION_REQUEST: '@@discussion/CREATE_DISCUSSION_REQUEST',
    CREATE_DISCUSSION_SUCCESS: '@@discussion/CREATE_DISCUSSION_SUCCESS',
    CREATE_DISCUSSION_FAILURE: '@@discussion/CREATE_DISCUSSION_FAILURE',
    REMOVE_DISCUSSION_REQUEST: '@@discusion/REMOVE_DISCUSSION_REQUEST',
    REMOVE_DISCUSSION_SUCCESS: '@@discusion/REMOVE_DISCUSSION_SUCCESS',
    REMOVE_DISCUSSION_FAILURE: '@@discusion/REMOVE_DISCUSSION_FAILURE',
    INCREMENT_DISCUSSION_COMMENT: '@@discussion/INCREMENT_DISCUSSION_COMMENT'
};

// -----------------------------------
// functions to consume api resources
// -----------------------------------
let cancelFetch = null;

// ---------------
// action creators
// ---------------
export function actionCreators(config) {
    const { listId, ...restConfig } = config;
    stateMap[listId] = {
        ...(stateMap[listId] || {}),
        ...restConfig
    };
    // get the pagination's bound action creators
    const pageActions = composables({ listId });

    const _actionCreators = {
        loadDiscussions: (pageInfo) => (dispatch) => {
            const promise = dispatch(pageActions.loadEntries(pageInfo));

            return promise.then(resp => {
                // create the discussion comments recipes reducer
                dynamicComments(resp.data.items, { updateCounter: _actionCreators.updateCommentCounter });

                // create the like recipes reducer
                dynamicLikes(resp.data.items, {
                    dynamicName,
                    location: 'discussion.like'
                });

                // create the like paginator recipes reducer
                dynamicRecipeLikes(resp.data.items, {
                    dynamicName,
                    location: 'discussion.like.recipes'
                });

                return resp;
            });
        },
        afterStore: (data) => (dispatch) => {
            // update comment counter if bound action creator exists
            stateMap[listId].updaterDiscussionCounter && dispatch(stateMap[listId].updaterDiscussionCounter(1));

            // create the discussion comments recipes reducer
            dynamicComments(data, { updateCounter: _actionCreators.updateCommentCounter });

            // create the like recipes reducer
            dynamicLikes(data, {
                dynamicName,
                location: 'discussion.like'
            });

            // create the like paginator recipes reducer
            dynamicRecipeLikes(data, {
                dynamicName,
                location: 'discussion.like.recipes'
            });

            return data;
        },
        deleteDiscussion: ({ itemId, discusion }) => (dispatch, getState) => {
            const { session } = getState();

            const deleteData = deleteCreator([
                actionType(actionTypes.REMOVE_DISCUSSION_REQUEST, listId),
                actionType(actionTypes.REMOVE_DISCUSSION_SUCCESS, listId),
                actionType(actionTypes.REMOVE_DISCUSSION_FAILURE, listId)
            ], params => laroute.route('discusion.destroy', params));

            dispatch(pageActions.removeAsync(
                itemId,
                dispatch(deleteData({ discusion }, {_token: session.csrftoken})),
                false
            )).then(() => {
                // update comment counter if bound action creator exists
                stateMap[listId].updaterDiscussionCounter && dispatch(stateMap[listId].updaterDiscussionCounter(-1));
            });
        },
        updateCommentCounter: (entryItem) => (dispatch, getState) => {
            const entry = getItem(getState(), listId, entryItem.cod);

            dispatch(pageActions.updateItem(
                entry.get('cod'),
                { contadorComentariosDiscucion: entry.get('contadorComentariosDiscucion') + 1 }
            ));
        }
    };

    return _actionCreators;
}

// --------
// reducers
// --------
// higher order reducer to build a discussion reducer
export function createDiscussion(pageConfig = {}) {
    const listId = pageConfig.listId || LIST_ID;
    const resolve = t => actionType(t, listId);

    const defaultConfig = {
        listId,
        initialSettings: {
            pageSize: 8
        },
        pageParams: {
            endpoint: params => laroute.route('discusion.index', params),
            endpointPost: params => laroute.route('discusion.store', params),
            loadTypes: [
                resolve(actionTypes.DISCUSSIONS_REQUEST),
                resolve(actionTypes.DISCUSSIONS_SUCCESS),
                resolve(actionTypes.DISCUSSIONS_FAILURE)
            ],
            storeTypes: [
                resolve(actionTypes.CREATE_DISCUSSION_REQUEST),
                resolve(actionTypes.CREATE_DISCUSSION_SUCCESS),
                resolve(actionTypes.CREATE_DISCUSSION_FAILURE)
            ],
            cancelFetch
        }
    };

    const config = {...defaultConfig, ...pageConfig};
    const pageActions = actionCreators(config);

    return createPaginator({
        ...config,
        fetch: pageActions.loadDiscussions,
        afterStore: pageActions.afterStore
    });
}
export default function reducer(state = initialState, action) {
    const { type, payload, error, data } = action;

    return state;
}

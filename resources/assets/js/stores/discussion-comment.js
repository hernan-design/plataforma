// resources/assets/js/stores/discussion-comment.js
import laroute from '../helpers/laroute.js';
import createPaginator, { composables } from './paginator';
import { get as getProp } from 'lodash';
import { getResource } from '../helpers/states';
import { dynamicRecipes as dynamicLikes, dynamicRecipeLikes } from './like';
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
export const LIST_ID = 'recipeDiscussionComments';

// ----------------
// function helpers
// ----------------

const dynamicName = `_${namedContent(getResource('discusion.comentario'), true)}`

/**
 * build discussion comments recipes for every entry
 * @param { Array|Object } entries
 * @param { String } location
 */
export const dynamicRecipes = composeDynamicReducers({
    location: 'discussionComment',
    nameReducer: (entry) => `${LIST_ID}_${entry.cod}`,
    createReducer: (entry, { dynamicName, location, updateCounter }) => {
        if(entry.cod) {
            return createDiscussionComment({
                listId: dynamicName,
                locator: state => (getProp(state, location) || {})[dynamicName],
                updaterCommentCounter: updateCounter(entry)
            });
        }
        return false;
    }
});

// ------------
// action types
// ------------
export const actionTypes = {
    COMMENTS_REQUEST: '@@comment/COMMENTS_REQUEST',
    COMMENTS_SUCCESS: '@@comment/COMMENTS_SUCCESS',
    COMMENTS_FAILURE: '@@comment/COMMENTS_FAILURE',
    CREATE_COMMENT_REQUEST: '@@comment/CREATE_COMMENT_REQUEST',
    CREATE_COMMENT_SUCCESS: '@@comment/CREATE_COMMENT_SUCCESS',
    CREATE_COMMENT_FAILURE: '@@comment/CREATE_COMMENT_FAILURE'
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

    return {
        loadEntries: (pageInfo) => (dispatch, getState) => {
            const promise = dispatch(pageActions.loadEntries(pageInfo));

            return promise.then(resp => {
                // create the like recipes reducer
                dynamicLikes(resp.data.items, {
                    dynamicName,
                    location: 'discussionComment.like'
                });

                // create the like paginator recipes reducer
                dynamicRecipeLikes(resp.data.items, {
                    dynamicName,
                    location: 'discussionComment.like.recipes'
                });

                return resp;
            });
        },
        afterStore: (data) => (dispatch) => {
            // update comment counter if, bound action creator exists
            stateMap[listId].updaterCommentCounter && dispatch(stateMap[listId].updaterCommentCounter);

            // create the like recipes reducer
            dynamicLikes(data, {
                dynamicName,
                location: 'discussionComment.like'
            });

            // create the like paginator recipes reducer
            dynamicRecipeLikes(data, {
                dynamicName,
                location: 'discussionComment.like.recipes'
            });

            return data;
        }
    }
}

// --------
// reducers
// --------
// higher order reducer to build a discussion comment reducer
export function createDiscussionComment(pageConfig = {}) {
    const listId = pageConfig.listId || LIST_ID;
    const resolve = t => actionType(t, listId);

    const defaultConfig = {
        listId: LIST_ID,
        initialSettings: {
            pageSize: 5
        },
        pageParams: {
            endpoint: params => laroute.route('discusion.comentario.index', params),
            endpointPost: params => laroute.route('discusion.comentario.store', params),
            loadTypes: [
                resolve(actionTypes.COMMENTS_REQUEST),
                resolve(actionTypes.COMMENTS_SUCCESS),
                resolve(actionTypes.COMMENTS_FAILURE)
            ],
            storeTypes: [
                resolve(actionTypes.CREATE_COMMENT_REQUEST),
                resolve(actionTypes.CREATE_COMMENT_SUCCESS),
                resolve(actionTypes.CREATE_COMMENT_FAILURE)
            ],
            cancelFetch
        }
    };
    const config = {...defaultConfig, ...pageConfig};
    const pageActions = actionCreators(config);

    return createPaginator({
        ...config,
        fetch: pageActions.loadEntries,
        afterStore: pageActions.afterStore
    });
}
export default function reducer(state = initialState, action) {
    const { type, payload, error, data } = action;

    return state;
}

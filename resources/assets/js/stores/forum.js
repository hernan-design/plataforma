// resources/assets/js/stores/forum.js
import laroute from '../helpers/laroute.js';
import { fetchCreator, storeCreator, updateCreator, deleteCreator } from '../middleware/api';
import createPaginator, { composables } from './paginator';
import { TypedError, actionCreators as errorActions } from './error-message';
import { createLike, createRecipeLikes } from './like';
import { createDiscussion } from './discussion';
import { composeDynamicReducers, buildActionType as actionType } from '../helpers/redux-utils';
import { get as getProp } from 'lodash';
import { camelizeKeys } from 'humps';

const initialState = {
    forum: {},
    category: {},
    categories: []
};

// set constants to define the list id name
export const LIST_ID = 'recipeForums';
export const SHALLOW_LIST_ID = 'recipeShallowForums';
export const RELATED_LIST_ID = 'recipeRelatedForums';
export const AUTHOR_LIST_ID = 'recipeAuthorForums';
export const MORE_COMMENTED_LIST_ID = 'recipeMoreCommentedForums';

// ----------------
// helper functions
// ----------------
/**
 * build forum recipes for each category
 * @param { Array|Object } entries
 * @param { Object } options
 */
export const dynamicRecipes = composeDynamicReducers({
    location: 'forumRecipes',
    nameReducer: (c) => `${LIST_ID}_${c.urlCategoriaForo || c.url_categoria_foro}`,
    createReducer: (c, { dynamicName, location, ...restConfig }) => {
        const catUrl = c.urlCategoriaForo || c.url_categoria_foro;
        return createPaginator({
            listId: dynamicName,
            locator: state => (getProp(state, location) || {})[dynamicName],
            initialSettings: {
                // initialized: true,
                pageSize: 5,
                filters: {
                    url_categoria_foro: catUrl
                }
            },
            pageParams: {
                endpoint: params => laroute.route('api.foro.index', params),
                loadTypes: [
                    actionType(actionTypes.FORUMS_REQUEST, dynamicName),
                    actionType(actionTypes.FORUMS_SUCCESS, dynamicName),
                    actionType(actionTypes.FORUMS_FAILURE, dynamicName)
                ]
            },
            ...restConfig
        });
    }
});

// ------------
// action types
// ------------
export const actionTypes = {
    FORUMS_REQUEST: '@@forum/FORUMS_REQUEST',
    FORUMS_SUCCESS: '@@forum/FORUMS_SUCCESS',
    FORUMS_FAILURE: '@@forum/FORUMS_FAILURE',
    SHALLOW_FORUMS_REQUEST: '@@forum/SHALLOW_FORUMS_REQUEST',
    SHALLOW_FORUMS_SUCCESS: '@@forum/SHALLOW_FORUMS_SUCCESS',
    SHALLOW_FORUMS_FAILURE: '@@forum/SHALLOW_FORUMS_FAILURE',
    RELATED_FORUMS_REQUEST: '@@forum/RELATED_FORUMS_REQUEST',
    RELATED_FORUMS_SUCCESS: '@@forum/RELATED_FORUMS_SUCCESS',
    RELATED_FORUMS_FAILURE: '@@forum/RELATED_FORUMS_FAILURE',
    AUTHOR_FORUMS_REQUEST: '@@forum/AUTHOR_FORUMS_REQUEST',
    AUTHOR_FORUMS_SUCCESS: '@@forum/AUTHOR_FORUMS_SUCCESS',
    AUTHOR_FORUMS_FAILURE: '@@forum/AUTHOR_FORUMS_FAILURE',
    MORE_COMMENTED_FORUMS_REQUEST: '@@forum/MORE_COMMENTED_FORUMS_REQUEST',
    MORE_COMMENTED_FORUMS_SUCCESS: '@@forum/MORE_COMMENTED_FORUMS_SUCCESS',
    MORE_COMMENTED_FORUMS_FAILURE: '@@forum/MORE_COMMENTED_FORUMS_FAILURE',
    SHOW_FORUM_REQUEST: '@@forum/SHOW_FORUM_REQUEST',
    SHOW_FORUM_SUCCESS: '@@forum/SHOW_FORUM_SUCCESS',
    SHOW_FORUM_FAILURE: '@@forum/SHOW_FORUM_FAILURE',
    CREATE_FORUM_REQUEST: '@@forum/CREATE_FORUM_REQUEST',
    CREATE_FORUM_SUCCESS: '@@forum/CREATE_FORUM_SUCCESS',
    CREATE_FORUM_FAILURE: '@@forum/CREATE_FORUM_FAILURE',
    UPDATE_FORUM_REQUEST: '@@forum/UPDATE_FORUM_REQUEST',
    UPDATE_FORUM_SUCCESS: '@@forum/UPDATE_FORUM_SUCCESS',
    UPDATE_FORUM_FAILURE: '@@forum/UPDATE_FORUM_FAILURE',
    REMOVE_FORUM_REQUEST: '@@forum/REMOVE_FORUM_REQUEST',
    REMOVE_FORUM_SUCCESS: '@@forum/REMOVE_FORUM_SUCCESS',
    REMOVE_FORUM_FAILURE: '@@forum/REMOVE_FORUM_FAILURE',
    FILL_FORUM: '@@forum/FILL_FORUM',
    UPDATE_FORUM_COMMENT_COUNTER: '@@forum/UPDATE_FORUM_COMMENT_COUNTER'
};

// ---------------
// action creators
// ---------------
let cancelFetch = null;
let cancelFetchShallow = null;
let cancelFetchRelated = null;
let cancelFetchByAuthor = null;
let cancelFetchMoreCommented = null;
export const actionCreators = {
    loadForum: (foro, sendData={}) => (dispatch) => {
        const showData = fetchCreator([
            actionTypes.SHOW_FORUM_REQUEST,
            actionTypes.SHOW_FORUM_SUCCESS,
            actionTypes.SHOW_FORUM_FAILURE
        ], params => laroute.route('api.foro.show', params));

        const promise = dispatch(showData(sendData, { foro }));

        return promise.then(({ data }) => {
            if(typeof data.success !== 'undefined' && !data.success) {
                // set error message
                const error = new TypedError(data.errors, { type: 'alert' });
                dispatch(errorActions.errorMessage(error));

                return error;
            }

            // fill forum state data
            dispatch({
                type: actionTypes.FILL_FORUM,
                payload: data
            });

            return data;
        });
    },
    storeForum: (nameForm, data = {}) => (dispatch, getState) => {
        const { form, session } = getState();

        const storeData = storeCreator([
            actionTypes.CREATE_FORUM_REQUEST,
            actionTypes.CREATE_FORUM_SUCCESS,
            actionTypes.CREATE_FORUM_FAILURE
        ], params => laroute.route('foro.store', params));

        const promise = dispatch(storeData({
            'csrftoken': session.csrftoken,
            '_token': session.csrftoken,
            ...form[nameForm],
            ...data
        }));

        return promise.then(({ data }) => {
            if(typeof data.success !== 'undefined' && !data.success) {
                // set error message
                const error = new TypedError(data.errors, { type: 'alert' });
                dispatch(errorActions.errorMessage(error));

                return error;
            }

            return data;
        }).catch(err => {
            throw err;
        });;
    },
    updateForumOfList: (nameForm, { itemId, listId=LIST_ID, foro, ...restData }) => (dispatch, getState) => {
        const pageActions = composables({ listId });
        const { form, session } = getState();

        const sendData = { ...restData, ...form[nameForm] };
        const endpoint = laroute.route('foro.update', { foro });

        const updateData = updateCreator([
            actionType(actionTypes.UPDATE_FORUM_REQUEST, listId),
            actionType(actionTypes.UPDATE_FORUM_SUCCESS, listId),
            actionType(actionTypes.UPDATE_FORUM_FAILURE, listId)
        ], endpoint, true);

        const promise = dispatch(pageActions.updateAsync(
            itemId,
            camelizeKeys(sendData),
            dispatch(updateData({
                ...sendData,
                _token: session.csrftoken
            }))
        ));

        return promise.then(({ data }) => {
            if(typeof data.success !== 'undefined' && !data.success) {
                // set error message
                const error = new TypedError(data.errors, { type: 'alert' });
                dispatch(errorActions.errorMessage(error));

                return error;
            }

            // update item with data that come from the server
            dispatch(pageActions.updateItem(itemId, data));

            return data;
        });
    },
    deleteForumOfList: ({ itemId, listId=LIST_ID, foro }) => (dispatch, getState) => {
        const pageActions = composables({ listId: listId });
        const { session } = getState();

        const deleteData = deleteCreator([
            actionType(actionTypes.REMOVE_FORUM_REQUEST, listId),
            actionType(actionTypes.REMOVE_FORUM_SUCCESS, listId),
            actionType(actionTypes.REMOVE_FORUM_FAILURE, listId)
        ], params => laroute.route('foro.destroy', params));

        const promise = dispatch(pageActions.removeAsync(
            itemId,
            dispatch(deleteData({ foro }, {_token: session.csrftoken})),
            false
        ));

        promise.then(({ data }) => {
            if(typeof data.success !== 'undefined' && !data.success) {
                // set error message
                const error = new TypedError(data.errors, { type: 'alert' });
                dispatch(errorActions.errorMessage(error));

                return error;
            }
        });
    },
    loadMoreCommented: pageInfo => dispatch => {
        const { pageSize, ...restQuery } = pageInfo.query;

        const fetchData = fetchCreator(
            [
                actionTypes.MORE_COMMENTED_FORUMS_REQUEST,
                actionTypes.MORE_COMMENTED_FORUMS_SUCCESS,
                actionTypes.MORE_COMMENTED_FORUMS_FAILURE
            ],
            params => laroute.route('api.foro.index', params),
            cancelFetchMoreCommented
        );

        const promise = dispatch(fetchData({}, {
            limit: pageSize,
            ...( JSON.parse(JSON.stringify(restQuery)) )
        }));

        return promise.then(resp => ({
            data: {
                items: resp.data
            }
        }));
    },
    updateDiscussionCounter: (mount = 1) => (dispatch, getState) => {
        const { forum } = getState().forum;

        dispatch({
            type: actionTypes.UPDATE_FORUM_COMMENT_COUNTER,
            payload: { contadorComentario: forum.contadorComentario + mount }
        });
    }
};

// --------
// reducers
// --------
export const recipeForums = createPaginator({
    listId: LIST_ID,
    initialSettings: {
        pageSize: 20
    },
    pageParams: {
        endpoint: params => laroute.route('api.foro.index', params),
        loadTypes: [
            actionTypes.FORUMS_REQUEST,
            actionTypes.FORUMS_SUCCESS,
            actionTypes.FORUMS_FAILURE
        ],
        cancelFetch
    }
});

export const recipeShallowForums = createPaginator({
    listId: SHALLOW_LIST_ID,
    initialSettings: {
        pageSize: 4
    },
    pageParams: {
        endpoint: params => laroute.route('api.foro.index', params),
        loadTypes: [
            actionTypes.SHALLOW_FORUMS_REQUEST,
            actionTypes.SHALLOW_FORUMS_SUCCESS,
            actionTypes.SHALLOW_FORUMS_FAILURE
        ],
        cancelFetch: cancelFetchShallow
    }
});

export const recipeRelatedForums = createPaginator({
    listId: RELATED_LIST_ID,
    initialSettings: {
        pageSize: 5,
        filters: {
            type: 'related'
        }
    },
    pageParams: {
        endpoint: params => laroute.route('api.foro.index', params),
        loadTypes: [
            actionTypes.RELATED_FORUMS_REQUEST,
            actionTypes.RELATED_FORUMS_SUCCESS,
            actionTypes.RELATED_FORUMS_FAILURE
        ],
        cancelFetch: cancelFetchRelated
    }
});

export const recipeAuthorForums = createPaginator({
    listId: AUTHOR_LIST_ID,
    initialSettings: {
        pageSize: 5,
        filters: {
            type: 'author'
        }
    },
    pageParams: {
        endpoint: params => laroute.route('api.foro.index', params),
        loadTypes: [
            actionTypes.AUTHOR_FORUMS_REQUEST,
            actionTypes.AUTHOR_FORUMS_SUCCESS,
            actionTypes.AUTHOR_FORUMS_FAILURE
        ],
        cancelFetch: cancelFetchByAuthor
    }
});

export const recipeMoreCommentedForums = createPaginator({
    listId: MORE_COMMENTED_LIST_ID,
    fetch: actionCreators.loadMoreCommented,
    initialSettings: {
        pageSize: 4,
        filters: {
            type: 'moreCommented'
        }
    }
});

export const forumThemeLike = createLike({
    recipeId: 'forumThemeLike'
});

export const recipeForumLikes = createRecipeLikes({
    listId: 'recipeForumLikes'
});

export const recipeForumDiscussion = createDiscussion({
    listId: 'recipeForumDiscussion',
    initialSettings: {
        initialized: true,
        pageSize: 10
    },
    updaterDiscussionCounter: actionCreators.updateDiscussionCounter
});

export default function reducer(state = initialState, action) {
    const { type, payload, error, data } = action;

    if(type === actionTypes.FILL_FORUM) {
        return { ...state, forum: payload };
    }

    if(type === actionTypes.UPDATE_FORUM_COMMENT_COUNTER) {
        return {...state, forum: {
            ...state.forum,
            contadorComentario: payload.contadorComentario
        }};
    }

    return state;
};

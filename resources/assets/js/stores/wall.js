// resources/assets/js/stores/wall.js
import laroute from '../helpers/laroute.js';
import { fetchCreator, storeCreator, deleteCreator, updateCreator } from '../middleware/api';
import createPaginator, { composables } from './paginator';
import { TypedError, actionCreators as errorActions } from './error-message';
import { namedContent, typeContent } from '../helpers/redux-utils';
import { getModule } from '../helpers/states';
import { dynamicRecipes as dynamicDiscussions } from './discussion';
import { dynamicRecipes as dynamicLikes, dynamicRecipeLikes } from './like';
import { getItem } from '@orange-marmalade/paginate-this';
import { camelizeKeys } from 'humps';

const initialState = {
    discussion: {},
    like: {
        recipes: {}
    }
};

// set constant to define the list id name
export const LIST_ID = 'recipeEntries';

// get the pagination's bound action creators
const pageActions = composables({ listId: LIST_ID });

const dynamicName = (entry) => `_${namedContent(entry.codigoModulo)}`

// ------------
// action types
// ------------
export const actionTypes = {
    ENTRIES_REQUEST: '@@wall/ENTRIES_REQUEST',
    ENTRIES_SUCCESS: '@@wall/ENTRIES_SUCCESS',
    ENTRIES_FAILURE: '@@wall/ENTRIES_FAILURE',
    CREATE_ENTRY_REQUEST: '@@wall/CREATE_ENTRY_REQUEST',
    CREATE_ENTRY_SUCCESS: '@@wall/CREATE_ENTRY_SUCCESS',
    CREATE_ENTRY_FAILURE: '@@wall/CREATE_ENTRY_FAILURE',
    REMOVE_ENTRY_REQUEST: '@@wall/REMOVE_ENTRY_REQUEST',
    REMOVE_ENTRY_SUCCESS: '@@wall/REMOVE_ENTRY_SUCCESS',
    REMOVE_ENTRY_FAILURE: '@@wall/REMOVE_ENTRY_FAILURE',
    UPDATE_ENTRY_REQUEST: '@@wall/UPDATE_ENTRY_REQUEST',
    UPDATE_ENTRY_SUCCESS: '@@wall/UPDATE_ENTRY_SUCCESS',
    UPDATE_ENTRY_FAILURE: '@@wall/UPDATE_ENTRY_FAILURE',
    SUBSCRIBE_CHANNEL_REQUEST: '@@wall/SUBSCRIBE_CHANNEL_REQUEST',
    SUBSCRIBE_CHANNEL_SUCCESS: '@@wall/SUBSCRIBE_CHANNEL_SUCCESS',
    SUBSCRIBE_CHANNEL_FAILURE: '@@wall/SUBSCRIBE_CHANNEL_FAILURE',
    UNSUBSCRIBE_CHANNEL_REQUEST: '@@wall/UNSUBSCRIBE_CHANNEL_REQUEST',
    UNSUBSCRIBE_CHANNEL_SUCCESS: '@@wall/UNSUBSCRIBE_CHANNEL_SUCCESS',
    UNSUBSCRIBE_CHANNEL_FAILURE: '@@wall/UNSUBSCRIBE_CHANNEL_FAILURE'
};

// -----------------------------------
// functions to consume resources api
// -----------------------------------
let cancelFetch = null;

// ---------------
// action creators
// ---------------
export const actionCreators = {
    loadEntries: (pageInfo) => (dispatch) => {
        const promise = dispatch(pageActions.loadEntries(pageInfo));

        return promise.then(resp => {
            // create the discussion recipes reducer
            dynamicDiscussions(resp.data.items, {
                dynamicName,
                location: 'wall.discussion',
                updateCounter: actionCreators.updateDiscussionCounter
            });

            // create the like recipes reducer
            dynamicLikes(resp.data.items, {
                dynamicName,
                location: 'wall.like'
            });

            // create the like paginator recipes reducer
            dynamicRecipeLikes(resp.data.items, {
                dynamicName,
                location: 'wall.like.recipes'
            });

            return resp;
        });
    },
    storeEntry: (nameForm, data = {type:''}) => (dispatch, getState) => {
        const { form, session } = getState();
        let endpoint = '';

        switch(data.type) {
            case typeContent(getModule('calendar')):
                endpoint = 'calendario.evento.store';
                break;
            case typeContent(getModule('forum')):
                endpoint = 'foro.store';
                break;
            default: endpoint = 'comunidad.index';
        }

        const storeData = storeCreator([
            actionTypes.CREATE_ENTRY_REQUEST,
            actionTypes.CREATE_ENTRY_SUCCESS,
            actionTypes.CREATE_ENTRY_FAILURE
        ], params => laroute.route(endpoint, params));

        const promise = dispatch(pageActions.addAsync(storeData({
            'csrftoken': session.csrftoken,
            '_token': session.csrftoken,
            ...form[nameForm],
            ...data
        }), 'start'));

        return promise.then(data => {
            if(typeof data.success !== 'undefined' && !data.success) {

                dispatch(pageActions.addFailed(data));
                // set error message
                const error = new TypedError(data.errors, { type: 'alert' });
                dispatch(errorActions.errorMessage(error));

                return error;
            }

            // create the discussion recipes reducer
            dynamicDiscussions(data, {
                dynamicName,
                location: 'wall.discussion',
                updateCounter: actionCreators.updateDiscussionCounter
            });

            // create the like recipes reducer
            dynamicLikes(data, {
                dynamicName,
                location: 'wall.like'
            });

            // create the like paginator recipes reducer
            dynamicRecipeLikes(data, {
                dynamicName,
                location: 'wall.like.recipes'
            });

            return data;
        });
    },
    updateEntry: (nameForm, { type='', itemId, ...restData }) => (dispatch, getState) => {
        const { form, session } = getState();

        const sendData = { ...restData, ...form[nameForm] };
        let endpoint = '';

        switch(type) {
            case typeContent(getModule('forum')):
                endpoint = laroute.route('foro.update', { foro: restData.codigo_foro });
                break;
            case typeContent(getModule('calendar')):
                endpoint = laroute.route('calendario.evento.update', { evento: restData.codigo_evento });
                break;
            case typeContent(getModule('wall')):
                endpoint = laroute.route('comunidad.update', { comunidad: itemId });
                break;
            default: endpoint = laroute.route('comunidad.update', { comunidad: itemId });
        }

        const updateData = updateCreator([
            actionTypes.UPDATE_ENTRY_REQUEST,
            actionTypes.UPDATE_ENTRY_SUCCESS,
            actionTypes.UPDATE_ENTRY_FAILURE
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
    deleteEntry: (itemId) => (dispatch, getState) => {
        const { session } = getState();

        const deleteData = deleteCreator([
            actionTypes.REMOVE_ENTRY_REQUEST,
            actionTypes.REMOVE_ENTRY_SUCCESS,
            actionTypes.REMOVE_ENTRY_FAILURE
        ], params => laroute.route('comunidad.destroy', params));

        dispatch(pageActions.removeAsync(
            itemId,
            dispatch(deleteData({comunidad: itemId}, {_token: session.csrftoken})),
            false
        ));
    },
    subscribeChannel: (slug) => (dispatch, getState) => {
        const { session, channel } = getState();

        const storeData = storeCreator([
            actionTypes.SUBSCRIBE_CHANNEL_REQUEST,
            actionTypes.SUBSCRIBE_CHANNEL_SUCCESS,
            actionTypes.SUBSCRIBE_CHANNEL_FAILURE
        ], params => laroute.route('comunidad.canalusuario.store', params));

        const promise = dispatch(storeData({
            'csrftoken': session.csrftoken,
            '_token': session.csrftoken,
            [slug]: true
        }));

        return promise.then(({ data }) => {
            if(data.success) {
                return dispatch(pageActions.showByState('url_canal', channel.channels.find(ch => (
                    ch.codigoCanal === data.codigoCanal
                )).urlCanal));
            }
        });
    },
    unsubscribeChannel: (canalusuario) => (dispatch, getState) => {
        const { session, channel } = getState();

        const updateData = updateCreator([
            actionTypes.UNSUBSCRIBE_CHANNEL_REQUEST,
            actionTypes.UNSUBSCRIBE_CHANNEL_SUCCESS,
            actionTypes.UNSUBSCRIBE_CHANNEL_FAILURE
        ], params => laroute.route(`comunidad.canalusuario.update`, params), true);

        const promise = dispatch(updateData(
            {
                'csrftoken': session.csrftoken,
                '_token': session.csrftoken
            },
            { canalusuario }
        ));

        return promise;
    },
    updateDiscussionCounter: (entryItem) => (mount = 1) => (dispatch, getState) => {
        const entry = getItem(getState(), LIST_ID, entryItem.cod);

        dispatch(pageActions.updateItem(
            entry.get('cod'),
            { contadorComentario: entry.get('contadorComentario') + mount }
        ));
    }
};

// --------
// reducers
// --------
export const recipeEntries = createPaginator({
    listId: LIST_ID,
    fetch: actionCreators.loadEntries,
    initialSettings: {
        initialized: true,
        pageSize: 20
    },
    pageParams: {
        endpoint: params => laroute.route('api.comunidad.index', params),
        loadTypes: [
            actionTypes.ENTRIES_REQUEST,
            actionTypes.ENTRIES_SUCCESS,
            actionTypes.ENTRIES_FAILURE
        ],
        cancelFetch
    }
});
export default function reducer(state = initialState, action) {
    const { type, payload, error, data } = action;

    return state;
};

// resources/assets/js/stores/articles.js
import laroute from '../helpers/laroute.js';
import { CALL_API, CancelToken, fetchCreator } from '../middleware/api';
import createPaginator, { composables } from './paginator';
import { TypedError, actionCreators as errorActions } from './error-message';

const initialState = {
    'types': []
};

// set constant to define the list id name
export const SHALLOW_LIST_ID = 'recipeShallowEvents';

// get the pagination's bound action creators
export const pageActionsShallow = composables({ listId: SHALLOW_LIST_ID });

// ------------
// action types
// ------------
export const actionTypes = {
    SHALLOW_EVENTS_REQUEST: '@@event/SHALLOW_EVENTS_REQUEST',
    SHALLOW_EVENTS_SUCCESS: '@@event/SHALLOW_EVENTS_SUCCESS',
    SHALLOW_EVENTS_FAILURE: '@@event/SHALLOW_EVENTS_FAILURE',
    SHOW_EVENT_REQUEST: '@@event/SHOW_EVENT_REQUEST',
    SHOW_EVENT_SUCCESS: '@@event/SHOW_EVENT_SUCCESS',
    SHOW_EVENT_FAILURE: '@@event/SHOW_EVENT_FAILURE'
};

// ---------------
// action creators
// ---------------
let cancelFetchShallow = null;
const { SHALLOW_EVENTS_REQUEST, SHALLOW_EVENTS_SUCCESS, SHALLOW_EVENTS_FAILURE } = actionTypes;
const fetchShallowes = (data = {}, params = {}) => {
    const { csrftoken, ...restData } = data;

    return {
        [CALL_API]: {
            types: [SHALLOW_EVENTS_REQUEST, SHALLOW_EVENTS_SUCCESS, SHALLOW_EVENTS_FAILURE],
            endpoint: laroute.route('api.evento.index', { type: 'calendar', ...params }),
            data: restData,
            meta: {
                csrftoken,
                cancelToken: new CancelToken(c => {
                    cancelFetchShallow = c;
                })
            }
        }
    };
};

export const actionCreators = {
    loadShallowes: (pageInfo) => (dispatch, getState) => {
        const { session } = getState();
        const { page, pageSize, ...restQuery } = pageInfo.query;

        const promise = dispatch(fetchShallowes(
            { 'csrftoken': session.csrftoken },
            {
                limit: pageSize,
                ...( JSON.parse(JSON.stringify(restQuery)) )
            }
        ));

        return promise;
    },
    loadShallowesByChannel: (channel, time = 0) => (dispatch, getState) => {
        if(typeof cancelFetchShallow === 'function' && time) cancelFetchShallow();

        return dispatch(pageActionsShallow.loadByState(
            'url_canal',
            channel,
            time
        ));
    },
    loadEvent: evento => (dispatch) => {

        const showData = fetchCreator([
            actionTypes.SHOW_EVENT_REQUEST,
            actionTypes.SHOW_EVENT_SUCCESS,
            actionTypes.SHOW_EVENT_FAILURE
        ], params => laroute.route('calendario.evento.show', params));

        const promise = dispatch(showData({ type: 'encrypt' }, { evento }));

        return promise.then(({ data }) => {
            if(typeof data.success !== 'undefined' && !data.success) {
                // set error message
                const error = new TypedError(data.errors, { type: 'alert' });
                dispatch(errorActions.errorMessage(error));

                return error;
            }

            return data;
        });
    }
};

// --------
// reducers
// --------
export const recipeShallowEvents = createPaginator({
    listId: SHALLOW_LIST_ID,
    fetch: actionCreators.loadShallowes,
    initialSettings: {
        pageSize: 4,
        filters: {
            type: 'calendar'
        }
    },
    pageParams: {
        idProps: 'codigoEvento'
    }
});

export default function reducer(state = initialState, action) {
    const { type, payload, error, data } = action;

    return state;
};

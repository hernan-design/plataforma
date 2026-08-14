// resources/assets/js/stores/articles.js
import laroute from '../helpers/laroute.js';
import { CALL_API, CancelToken } from '../middleware/api';
import createPaginator, { composables } from './paginator';

const initialState = {};

// set constant to define the list id name
export const SHALLOW_LIST_ID = 'recipeShallowArticles';

// get the pagination's bound action creators
export const pageActionsShallow = composables({ listId: SHALLOW_LIST_ID });

// ------------
// action types
// ------------
export const actionTypes = {
    SHALLOW_ARTICLES_REQUEST: '@@article/SHALLOW_ARTICLES_REQUEST',
    SHALLOW_ARTICLES_SUCCESS: '@@article/SHALLOW_ARTICLES_SUCCESS',
    SHALLOW_ARTICLES_FAILURE: '@@article/SHALLOW_ARTICLES_FAILURE'
};

// ---------------
// action creators
// ---------------
let cancelFecthShallow = null;
const {SHALLOW_ARTICLES_REQUEST, SHALLOW_ARTICLES_SUCCESS, SHALLOW_ARTICLES_FAILURE} = actionTypes;
const fetchShallowes = (data = {}, params = {}) => {
    const { csrftoken, ...restData } = data;

    return {
        [CALL_API]: {
            types: [SHALLOW_ARTICLES_REQUEST, SHALLOW_ARTICLES_SUCCESS, SHALLOW_ARTICLES_FAILURE],
            endpoint: laroute.route('api.blog.index', {...params}),
            data: restData,
            meta: {
                csrftoken,
                cancelToken: new CancelToken(c => {
                    cancelFecthShallow = c;
                })
            }
        }
    }
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
        if(typeof cancelFecthShallow === 'function' && time) cancelFecthShallow();

        return dispatch(pageActionsShallow.loadByState(
            'url_canal',
            channel,
            time
        ));
    }
};

// --------
// reducers
// --------
export const recipeShallowArticles = createPaginator({
    listId: SHALLOW_LIST_ID,
    fetch: actionCreators.loadShallowes,
    initialSettings: {
        pageSize: 4
    }
    // pageParams: {
    //     idProps: 'codigoContenido'
    // }
});

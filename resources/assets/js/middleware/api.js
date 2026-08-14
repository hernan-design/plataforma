// resources/assets/js/middleware/api.js
// import { normalize, schema } from 'normalizr';
import '../../config';
import { camelizeKeys } from 'humps';
import axios from 'axios';
import laroute from '../helpers/laroute';
import Misc from '../helpers/misc';

const API_ROOT = `http://localhost${process.env.NODE_ENV !== 'production' ? process.env.BASE_PATHNAME : ''}`;

// create http api with axios to consume resources
export const httpApi = axios.create({
    baseURL: API_ROOT,
    xsrfHeaderName: 'X-CSRF-TOKEN',
    headers: {
        "X-Requested-With": "XMLHttpRequest"
    }
});

// create a source cancel token and export it
export const CancelToken = axios.CancelToken;
const source = CancelToken.source();
export const sourceCancel = source.cancel;

/**
 * Fetches an API response and normalizes the result JSON according to schema.
 * This makes every API response have the same shape, regardless of how nested it was.
 *
 * @param endpoint String
 * @param data Object
 * @param meta Object
 * @param schema Object
 * @return Promise
 */
const callApi = ({ endpoint:fullUrl, schema, data, meta }) => {
    let setConfig = {
        cancelToken: (meta && meta.cancelToken) || source.token,
        method: (meta && meta.method) || 'get'
    };
    if(/^(PUT|POST|PATCH)$/i.test(meta && meta.method)) {
        setConfig['data'] = data;
    }else {
        setConfig['params'] = data;
    }
    // meta && meta.csrftoken && (httpApi.defaults.headers.common['Authorization'] = meta.csrftoken);
    meta && meta.csrftoken && (httpApi.defaults.headers['X-CSRF-TOKEN'] = meta.csrftoken);
    httpApi.defaults.headers.post['Content-Type'] = "application/x-www-form-urlencoded; charset=UTF-8";

    return httpApi(fullUrl, setConfig)
        .then(({ data:json }) => {
            const camelizedJson = camelizeKeys(json);

            return camelizedJson; //normalize(camelizedJson, schema);
        });
};

// Add a response interceptor
httpApi.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    // Handling status codes
    if(error.response.status == 400) {
        Misc.redirect();
    }else if(error.response.status == 401) {
        Misc.redirect( Misc.urlFull(laroute.route('login')) );
    }else if(error.response.status == 402) {
        Misc.redirect( Misc.urlFull(laroute.route('precios')) );
    }

    return Promise.reject(error);
});

/**
 * creator to fetch data to consume the api
 * @param types { Array }
 * @param endpoint { Function|String }
 * @param cancelFetch { Any } variable to assign a request cancel function
 * @return bound action creator
 */
export function fetchCreator(types, endpoint, cancelFetch) {
    return (data = {}, params = {}) => {
        const { csrftoken, ...restData } = data;

        return {
            [CALL_API]: {
                types,
                endpoint: typeof endpoint === 'function' ? endpoint(params) : endpoint,
                data: restData,
                meta: {
                    csrftoken,
                    cancelToken: new CancelToken(c => {
                        cancelFetch || (cancelFetch = c);
                    })
                }
            }
        }
    }
}
/**
 * creator to store a new entry to the server
 * @param types { Array }
 * @param endpoint { Function|String }
 * @return bound action creator
 */
export function storeCreator(types, endpoint) {
    return (data = {}, params = {}) => {
        const { csrftoken, ...restData } = data;

        return {
            [CALL_API]: {
                types,
                endpoint: typeof endpoint === 'function' ? endpoint(params) : endpoint,
                data: restData,
                meta: {
                    method: 'post',
                    csrftoken
                }
            }
        }
    }
}
/**
 * creator to update a new entry to the server
 * @param types { Array }
 * @param endpoint { Function|String }
 * @param patch {Boolean}
 * @return bound action creator
 */
export function updateCreator(types, endpoint, patch) {
    return (data = {}, params = {}) => {
        const { csrftoken, ...restData } = data;

        return {
            [CALL_API]: {
                types,
                endpoint: typeof endpoint === 'function' ? endpoint(params) : endpoint,
                data: restData,
                meta: {
                    method: !!patch ? 'patch' : 'put',
                    csrftoken
                }
            }
        }
    }
}
/**
 * creator to delete an item to the server
 * @param types { Array }
 * @param endpoint { Function|String }
 * @return bound action creator
 */
export function deleteCreator(types, endpoint) {
    return (params = {}, data = {}) => {
        const { csrftoken, ...restData } = data;

        return {
            [CALL_API]: {
                types,
                endpoint: typeof endpoint === 'function' ? endpoint(params) : endpoint,
                data: restData,
                meta: {
                    method: 'delete',
                    csrftoken
                }
            }
        }
    }
}

// Action key that carries API call info interpreted by this Redux middleware.
export const CALL_API = 'CALL_API';

// A Redux middleware that interprets actions with CALL_API info specified.
// Performs the call and promises when such actions are dispatched.
export default store => next => action => {
    const callAPI = action[CALL_API];

    if (typeof callAPI === 'undefined') {
        return next(action)
    }

    let { endpoint } = callAPI;
    const { data, meta, schema, types } = callAPI;
    const { session } = store.getState();

    // set default base url that come from preload state session
    if( session && session.rootUrl ) {
        httpApi.defaults.baseURL = session.rootUrl;
    }

    if( typeof endpoint === 'function' ) {
        endpoint = endpoint(store.getState());
    }

    if( typeof endpoint !== 'string' ) {
        throw new Error('Specify a string endpoint URL.');
    }

    // if( !schema ) {
    //     throw new Error('Specify one of the exported Schemas.');
    // }

    if( !Array.isArray(types) || types.length !== 3 ) {
        throw new Error('Expected an array of three action types.');
    }

    // if( !types.every(type => typeof type !== 'string') ) {
    //     throw new Error('Expected action types to be strings.');
    // }

    /**
     * function that build a new action, based on action called
     * @param { Object } action
     * @return { Object } new action
     */
    const actionWith = newAction => {
        const finalAction = Object.assign({}, action, newAction);
        delete finalAction[CALL_API];
        return finalAction;
    };

    const [ requestType, successType, failureType ] = types;
    next(actionWith({ type: requestType }));

    return callApi({ endpoint, schema, data, meta }).then(
        response => next(actionWith({
            type: successType,
            data: response
        })),
        error => {
            if(axios.isCancel(error)) {
                console.log('Request canceled: ', error.message);
                return error;
            }else {
                // handle error
                next(actionWith({
                    type: failureType,
                    error: (error.message && error) || new Error('Something bad happened')
                }));

                throw error;
            }
        }
    );
}

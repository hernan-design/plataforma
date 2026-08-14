// resources/assets/js/stores/payment.js
import qs from 'qs';
import { pick } from 'lodash';
import $ from 'jquery';
import Misc from '../helpers/misc';
import Globalize from 'globalize';
import laroute from '../helpers/laroute.js';
import 'isomorphic-fetch';
import { actionCreators as errorActions, TypedError } from './error-message';

const initialState = {
    key: '',
    title: '',
    pricing: '',
    detail: '',
    purchaser: {},
    token: {}
};

// action types
export const types = {
    CREATE_CARD_TOKEN: '@@payment/CREATE_CARD_TOKEN',
    SEND_DATA: '@@payment/SEND_DATA',
    CARD_ERROR: '@@payment/CARD_ERROR'

};
// action creators
export const actionCreators = {
    setTokenError: error => ({
        type: types.CARD_ERROR,
        payload: error,
        error: true
    }),

    getCardToken : (formData = {}) => (dispatch, getState) => {
        const { payment } = getState();
        let dataToSend = pick(formData, 'card');
        dataToSend.key = payment.key;

        return fetch('https://api.stripe.com/v1/tokens', {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: qs.stringify(dataToSend)
        })
        .then(resp => resp.json())
        .then(data => {
            if(data.error) {
                const { error } = data;

                // set error message
                dispatch(errorActions.errorMessage(new TypedError(
                    Globalize.formatMessage(`payment/${error.type}/${error.code}`),
                    { type: 'alert' }
                )));

                // set token error
                dispatch(actionCreators.setTokenError(error));
            }else {
                dispatch({
                    type: types.CREATE_CARD_TOKEN,
                    payload: {token: data}
                });
            }
        })
        .catch(error => {
            // set error message
            dispatch(errorActions.errorMessage(new TypedError(
                error.message,
                { type: 'alert' }
            )));
        });
    },

    sendData: (addData) => (dispatch, getState) => {
        const { payment, form } = getState();
        if(payment.token.error) return Promise.resolve(null);

        let dataToSend = {
            pricing: payment.pricing,
            token: payment.token,
            ...form['form_payment_method'],
            ...addData
        };

        let customHeaders = {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        return fetch(Misc.urlFull( laroute.route('comprar.index') ), {
            method: 'POST',
            credentials: "same-origin",
            headers: {
                ...customHeaders,
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: qs.stringify(dataToSend)
        })
        .then(resp => resp.json())
        .then(data => {
            if(data.success === false) {
                // set error message
                dispatch(errorActions.errorMessage(new TypedError(
                    data.errors,
                    { type: 'alert' }
                )));
            }else if(data.success) {
                const { charge } = data;
                dispatch(errorActions.errorMessage(new TypedError(
                    Globalize.formatMessage(`payment/${charge.type}/${charge.network_status}`),
                    { type: 'success' }
                )));
            }
        })
        .catch(error => {
            // set error message
            dispatch(errorActions.errorMessage(new TypedError(
                error.message,
                { type: 'alert' }
            )));
        });
    }
};

// reducer
export default function reducer (state = initialState, action) {
    const { type, payload, error } = action;

    switch(type) {
        case types.CREATE_CARD_TOKEN :
            return {...state, token: payload.token};

        case types.CARD_ERROR :
            return error ? { ...state, token: {error: payload} } : state;

        default :
            return state;
    }
}

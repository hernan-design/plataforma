// resources/assets/js/stores/error-message.js
const initialState = {
    type: '',
    message: '',
    showAlert: false
};

// action types
export const actionTypes = {
    'SET_ERROR_MESSAGE': '@@error/SET_ERROR_MESSAGE',
    'CLEAN_ERROR_MESSAGE': '@@error/CLEAN_ERROR_MESSAGE'
};

// action creators
export const actionCreators = {
    errorMessage: (error) => ({
        type: actionTypes.SET_ERROR_MESSAGE,
        payload: error,
        error: true
    }),
    cleanError: () => ({
        type: actionTypes.CLEAN_ERROR_MESSAGE
    })
};

// custome error object
export function TypedError (message, { type }) {
    this.name = 'TypedError';
    this.message = message || 'Something went wrong.';
    this.stack = (new Error()).stack;
    this.type = type || 'warning';
}
TypedError.prototype = Object.create(Error.prototype);
TypedError.prototype.constructor = TypedError;

// reducer
export default function reducer (state = initialState, action) {
    const { type, payload, error } = action;

    switch(type) {
        case actionTypes.SET_ERROR_MESSAGE:
            return { ...state, ...payload, showAlert: true };
        case actionTypes.CLEAN_ERROR_MESSAGE:
            return { ...state, showAlert: false };
        default:
            return state;
    }
}

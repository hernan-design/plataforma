// resources/assets/js/stores/session.js
import { actionTypes as wallTypes } from './wall';

const initialState = {
    slugInstitution: '',
    rootUrl: '',
    csrftoken: null,
    user: {},
    institution: {}
}

// reducer user channel
const reduceUser = (state = initialState.user, action) => {
    const { type, data } = action;

    if(type === wallTypes.SUBSCRIBE_CHANNEL_SUCCESS) {
        return {
            ...state,
            channels: [
                ...state.channels,
                data
            ]
        };
    }

    if(type === wallTypes.UNSUBSCRIBE_CHANNEL_SUCCESS) {
        return {
            ...state,
            channels: state.channels.filter(
                codChannel => codChannel !== parseInt(data.codigoCanal)
            )
        };
    }

    return state;
}

// reducer
export default function reducer(state = initialState, action) {
    const { type, payload, error, data } = action;

    switch(type) {
        case wallTypes.SUBSCRIBE_CHANNEL_SUCCESS:
            return { ...state, user: reduceUser(state.user, action) };
        case wallTypes.UNSUBSCRIBE_CHANNEL_SUCCESS:
            return { ...state, user: reduceUser(state.user, action) }
        default:
            return state;
    }
}

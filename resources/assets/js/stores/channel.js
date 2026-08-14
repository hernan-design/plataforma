// resources/assets/js/stores/channel.js
import { normalize , schema } from 'normalizr';

const initialState = {
    channels: [],
    categories: []
};

// stablish schema entities
// const categorySchema = new schema.Entity('categories', {}, { idAttribute: 'codigoCategoriaCanal' });

// const channelSchema = new schema.Entity('channels', {}, { idAttribute: 'codigoCanal' });

// export const Schemas = {
//     CATEGORY_ARRAY: [ categorySchema ],
//     CHANNEL_ARRAY: channelSchema,
// };

// ---------------
// action creators
// ---------------

// --------
// reducer
// --------
export default function reducer(state = initialState, action) {

    return state;
}

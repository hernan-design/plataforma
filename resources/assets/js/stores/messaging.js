// resources/assets/js/stores/messaging.js

const initialState = {
	items: []
};

export default function reducer (state = initialState, action) {
	switch (action.type) {
		case 'ADD_ITEM':
			return state;
		default:
			return state;
	}
}


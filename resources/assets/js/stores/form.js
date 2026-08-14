// resources/assets/js/stores/form.js
const initialState = {};

// action types
export const actionTypes = {
	FILL_DATA: '@@form/FILL_DATA'
};

// action creators
export const actionCreators = {
	fillFormData: (formFields) => ({
		type: actionTypes.FILL_DATA,
		payload: formFields
	})
};

// reducer
export default function reducer (state = initialState, action) {
	const { type, payload } = action;

	switch (type) {
		case actionTypes.FILL_DATA :
			return {...state, ...payload};
		default:
			return state;
	}
}

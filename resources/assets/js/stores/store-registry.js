let useStore = null; export function setStore(store) { useStore = store; } export function attachReducers(newReducers = {}) { if(useStore) useStore.attachReducers(newReducers); }

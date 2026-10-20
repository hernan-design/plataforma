import initApp from './init-app.orig.js';

export default initApp;

// Named exports used across components
export const copCurrencyF        = (...a) => initApp.copCurrencyF(...a);
export const dolarCurrencyF      = (...a) => initApp.dolarCurrencyF(...a);
export const initConfigForm      = (...a) => initApp.initConfigForm(...a);
export const configInputMask     = (...a) => initApp.configInputMask(...a);
export const formatMessage       = (...a) => initApp.formatMessage(...a);
export const messageFormatter    = (...a) => initApp.messageFormatter(...a);
export const select2Trigger      = (...a) => initApp.select2Trigger(...a);
export const datepickerTrigger   = (...a) => initApp.datepickerTrigger(...a);
export const loadSVGEntryAnimation = (...a) => initApp.loadSVGEntryAnimation(...a);
export const loadSVGItemAnimation  = (...a) => initApp.loadSVGItemAnimation(...a);
export const noCloseModal        = (...a) => initApp.noCloseModal(...a);
export const noScrollModal       = (...a) => initApp.noScrollModal(...a);
export const initTabs            = (...a) => initApp.initTabs(...a);

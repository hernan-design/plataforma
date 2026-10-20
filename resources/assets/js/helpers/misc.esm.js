/**
 * ESM wrapper for misc.js (UMD/CommonJS → ESM)
 * Exposes named exports for Vite compatibility
 */
import Misc from './misc.orig.js';

export default Misc;

// Named exports used across components
export const formToJson        = (...a) => Misc.formToJson(...a);
export const ajaxHandler       = (...a) => Misc.ajaxHandler(...a);
export const validateEmptyFields = (...a) => Misc.validateEmptyFields(...a);
export const setSpinner        = (...a) => Misc.setSpinner(...a);
export const removeSpinner     = (...a) => Misc.removeSpinner(...a);
export const getCsrf           = (...a) => Misc.getCsrf ? Misc.getCsrf(...a) : undefined;
export const strToNickname     = (...a) => Misc.strToNickname(...a);
export const stripTags         = (...a) => Misc.stripTags(...a);
export const urlWrapLink       = (...a) => Misc.urlWrapLink(...a);
export const imageDefault      = (...a) => Misc.imageDefault(...a);
export const showNotification  = (...a) => Misc.showNotification(...a);
export const isEmail           = (...a) => Misc.isEmail(...a);
export const redirect          = (...a) => Misc.redirect(...a);
export const latinToAnglo      = (...a) => Misc.latinToAnglo(...a);
export const jsonToObject      = (...a) => Misc.jsonToObject(...a);
export const htmlEntities      = (...a) => Misc.htmlEntities(...a);
export const isEmptyObject     = (...a) => Misc.isEmptyObject(...a);
export const numberDots        = (...a) => Misc.numberDots(...a);
export const shuffle           = (...a) => Misc.shuffle(...a);
export const isUrl             = (...a) => Misc.isUrl(...a);
export const rtrim             = (...a) => Misc.rtrim(...a);
export const ltrim             = (...a) => Misc.ltrim(...a);
export const trim              = (...a) => Misc.trim(...a);
export const setCountdown      = (...a) => Misc.setCountdown(...a);
export const humanCountDown    = (...a) => Misc.humanCountDown(...a);
export const randomFrom        = (...a) => Misc.randomFrom(...a);
export const customizeDate     = (...a) => Misc.customizeDate(...a);
export const clearAllIntervals = (...a) => Misc.clearAllIntervals(...a);
export const closeOnClickOut   = (...a) => Misc.closeOnClickOut(...a);
export const showModalWindow   = (...a) => Misc.showModalWindow(...a);
export const closeModalWindow  = (...a) => Misc.closeModalWindow(...a);
export const argIsRequired     = (...a) => Misc.argIsRequired(...a);

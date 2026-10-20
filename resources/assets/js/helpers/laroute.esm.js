/**
 * ESM wrapper for laroute.js (IIFE → ESM)
 * Exposes named exports for Vite compatibility
 */
import laroute from './laroute.orig.js';

export default laroute;

// Named exports used across components
export const route          = (...a) => laroute.route(...a);
export const action         = (...a) => laroute.action(...a);
export const link_to_route  = (...a) => laroute.link_to_route(...a);
export const link_to_action = (...a) => laroute.link_to_action(...a);

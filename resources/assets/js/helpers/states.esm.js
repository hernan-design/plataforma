/**
 * ESM wrapper for states.js (IIFE → ESM)
 * Exposes named exports for Vite compatibility
 */
import _tp from './states.orig.js';

export default _tp;

// Named exports used across components
export const thumbs      = _tp.thumbs;
export const getModule   = _tp.getModule;
export const getResource = _tp.getResource;
export const getState    = _tp.getState;
export const uploadFile  = _tp.uploadFile;

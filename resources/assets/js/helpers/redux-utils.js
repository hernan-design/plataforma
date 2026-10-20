// resources/assets/js/helpers/redux-utils.js
import Immutable from 'immutable';
import { mapValues } from 'lodash';
import { getModule, getResource } from './states.esm';
import { attachReducers } from '../stores/store-registry';
import { combineReducers } from 'redux';

const locationMap = {};

export function defaultLocator(listId) {
    return state => state[listId];
}

/**
 * @param {String} action type
 * @param {String} id
 * @return {String} built action type
 */
export function buildActionType(t, id) {
    return `${t}_${id}`;
}

export function fromJSIterable(js) {
    return typeof js !== 'object' || js === null ? js :
        (Array.isArray(js) && js.every(v => typeof v !== 'object' && !Array.isArray(v)) ?
            Immutable.Seq(js).map(fromJSIterable).toSet() :
            (Array.isArray(js) ?
                Immutable.Seq(js).map(fromJSIterable).toList() :
                Immutable.Seq(js).map(fromJSIterable).toMap()
            )
        );
}

/**
 * @params {Object} preState
 * @return {Object}
 */
export function recipesToImmutable(preState) {
    const keyRecipes = 'recipes';

    return mapValues(preState, (obj, key) => {
        if(
            obj instanceof Object &&
            (key.indexOf(keyRecipes) === 0 ||
             key.toLowerCase().lastIndexOf(keyRecipes) === (key.length - keyRecipes.length) ||
            'recipes' in obj)
        ) {
            return recipesToImmutable(obj);
        }

        if( key.indexOf('recipe') === 0 && key.indexOf('recipes') !== 0 ) {
            return fromJSIterable(obj);
        }

        return obj;
    });
}

/**
 * name content
 * @param {Number} modType
 * @param {Boolean} isResource
 * @return {String}
 */
export function namedContent(modType, isResource) {
    const mod = {
        [getModule('blog')]: 'Article',
        [getModule('wall')]: 'Wall',
        [getModule('forum')]: 'Forum',
        [getModule('calendar')]: 'Event',
        [getModule('learn')]: 'Course'
    };

    const rsc = {
        [getResource('discusion.gestion')]: 'Discussion',
        [getResource('discusion.comentario')]: 'DiscussionComment'
    };

    if(!isResource) {
        return mod[modType];
    }else {
        return rsc[modType];
    }

};

/**
 * get content type
 * @param {Number} modType
 * @return {String} type
 */
export function typeContent(modType) {
    const mod = {
        [getModule('blog')]: 'article',
        [getModule('wall')]: 'post',
        [getModule('forum')]: 'forum',
        [getModule('calendar')]: 'event',
        [getModule('learn')]: 'course'
    }

    return mod[modType]
}

function versioningLocation(location) {
    if( ({}).hasOwnProperty.call(locationMap, location) && locationMap[location] > 0 ) {
        locationMap[location] = locationMap[location] + 1;
    }else {
        locationMap[location] = 1;
    }
}
/**
 * function compose to build dynamic reducers
 * @param { Object } options
 * @return { Function } to be pass those parameters: entries { Array|Object }, options ({ location, updateCounter, dynamicName })
 */
const attachedKeysByLocation = {};

export function composeDynamicReducers({ nameReducer, createReducer, location }) {
    return (entries, options={}) => {
        const _entries = Array.isArray(entries) ? entries : [entries];
        let attachDynamics = {};

        const settings = {
            location,
            updateCounter: () => {},
            ...options
        };
        const currentLocation = settings.location;
        const replace = options.replace || false;
        if (!attachedKeysByLocation[currentLocation]) {
            attachedKeysByLocation[currentLocation] = new Set();
        }
        const attachedSet = attachedKeysByLocation[currentLocation];
        let hasNew = false;

        _entries.forEach(entry => {
            const prefixName = typeof nameReducer === 'function' ? nameReducer(entry) : (nameReducer || '');
            const sufixName = typeof options.dynamicName === 'function' ? options.dynamicName(entry) : (options.dynamicName || '');

            const dynamicName = `${prefixName}${sufixName}`;

            if(
                typeof dynamicName === 'string' &&
                typeof createReducer === 'function'
            ) {
                if (replace || !attachedSet.has(dynamicName)) {
                    hasNew = true;
                    attachedSet.add(dynamicName);
                }
                attachDynamics[dynamicName] = createReducer(entry, {
                    ...settings,
                    dynamicName,
                    location: currentLocation
                });
            }
        });

        // attach recipes to store root reducer only if there are new reducers
        if( Object.keys(attachDynamics).length && hasNew ) {
            attachReducers({ [currentLocation]: combineReducers(attachDynamics) });
        }
    }
}

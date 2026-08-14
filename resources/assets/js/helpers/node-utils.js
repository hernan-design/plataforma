// resources/assets/js/helpers/node-utils.js
// include dependencies
// - - - - - - - - - -
const path = require('path');
const fs = require('fs');
const tls = require('tls');

// Globalize
let locale = 'es-CO';
const Globalize = require('globalize/dist/globalize');
require('globalize/dist/globalize/message');
require('globalize/dist/globalize/plural');
// load required CLDR JSON
Globalize.load(
    require('cldr-data/supplemental/likelySubtags.json'),
    require('cldr-data/supplemental/plurals.json'),
    require('cldr-data/supplemental/ordinals.json')
);
// load globalize messages from json file
Globalize.loadMessages( require('../../../lang/es/messages.json') );
Globalize.locale( locale );

// Initialize attributes
// - - - - - - - - - - -
const assetsBaseDir = `${__dirname}/../../../assets/`;

/**
 * get a built path from the assets location
 * @param {String} topath
 * @param {String} currentPath, eg. __dirname from module to resolve
 * @return {String} path to assets module
 */
const getAssetsPath = exports.getAssetsPath = (topath, currentPath) => {
    currentPath || (currentPath = process.env.NODE_PATH || __dirname);
    return path.relative( currentPath, path.resolve(assetsBaseDir, topath) )
            .replace((new RegExp(`^[^\\.\\${path.sep}]`)), `.${path.sep}$&`);
}

/**
 * format message for institution
 * @param {String} message
 * @param {Object} data
 * @param {String} _locale
 * @return {String} formated message
 */
const formatMessage = exports.formatMessage = (message, data, _locale) => {

    const _Globalize = _locale ? Globalize(_locale) : Globalize;
    const slugInstitution = process.env.SLUG_INSTITUTION;

    try {
        return _Globalize.formatMessage(`${slugInstitution ? slugInstitution +'/' : ''}${message}`, data);

    }catch(e) {
        return _Globalize.formatMessage(message, data);
    }
}

/**
 * message formatter for institution
 * @param {String} message
 * @param {String} _locale
 * @return {Function} formatter, parameters: {Object}
 */
const messageFormatter = exports.messageFormatter = (message, _locale)  => {

    const _Globalize = _locale ? Globalize(_locale) : Globalize;
    const slugInstitution = process.env.SLUG_INSTITUTION;

    try {
        return _Globalize.messageFormatter(`${slugInstitution ? slugInstitution +'/' : ''}${message}`);

    }catch(e) {
        return _Globalize.messageFormatter(message);
    }
}

/**
 * (multiple certs in one file) into an array exploded by the -END CERTIFICATE- line
 * @param {String} Bundle path
 * @return {Array} ca
 */
const getCABundle = exports.getCABundle = (Bundle) => {
    let ca = [];
    let cert = [];
    const chain = fs.readFileSync(Bundle, 'utf8').split('\n');

    for(let line in chain) {
        if(line.length > 0) {
            cert.push(chain[line]);
            if(chain[line].match(/-END CERTIFICATE-/)){
                ca.push(cert.join("\n"));
                cert = [];
            }
        }
    }
    return ca;
}

const getCredentialsContext = exports.getCredentialsContext = (cer) => {
    return tls.createSecureContext({
        key:  fs.readFileSync(cer.key),
        cert: fs.readFileSync(cer.cert),
        ca: getCABundle(cer.ca)
    });
}

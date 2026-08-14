import '../../config';
import React from 'react';
import ReactDOM from 'react-dom';
import ContentEditor from './content-editor';
import SimpleEditor from './simple-editor';

// Globalize
import Globalize from 'globalize/dist/globalize';
import 'globalize/dist/globalize/message';
import 'globalize/dist/globalize/number';
import 'globalize/dist/globalize/plural';
import 'globalize/dist/globalize/currency';

// load required CLDR JSON
Globalize.load(
    require('cldr-data/supplemental/likelySubtags.json'),
    require('cldr-data/main/es-CO/numbers.json'),
    require('cldr-data/supplemental/numberingSystems.json'),
    require('cldr-data/supplemental/plurals.json'),
    require('cldr-data/supplemental/ordinals.json'),
    require('cldr-data/main/es-CO/currencies.json'),
    require('cldr-data/supplemental/currencyData.json')
);
// load globalize messages from json file
Globalize.loadMessages( require('../../../lang/es/messages.json') );

window.SLUG_INSTITUTION = process && process.env.SLUG_INSTITUTION;
window.React = React;
window.ReactDOM = ReactDOM;
window.ContentEditor = ContentEditor;
window.SimpleEditor = SimpleEditor;
window.Globalize = Globalize;

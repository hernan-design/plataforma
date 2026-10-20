window.process = window.process || { env: { NODE_ENV: 'development' } };
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

import likelySubtags from 'cldr-data/supplemental/likelySubtags.json';
import numbers from 'cldr-data/main/es-CO/numbers.json';
import numberingSystems from 'cldr-data/supplemental/numberingSystems.json';
import plurals from 'cldr-data/supplemental/plurals.json';
import ordinals from 'cldr-data/supplemental/ordinals.json';
import currencies from 'cldr-data/main/es-CO/currencies.json';
import currencyData from 'cldr-data/supplemental/currencyData.json';
import esMessages from '../../../lang/es/messages.json';

// load required CLDR JSON
Globalize.load(
    likelySubtags,
    numbers,
    numberingSystems,
    plurals,
    ordinals,
    currencies,
    currencyData
);
// load globalize messages from json file
Globalize.loadMessages( esMessages );

window.SLUG_INSTITUTION = process && process.env.SLUG_INSTITUTION;
window.React = React;
window.ReactDOM = ReactDOM;
window.ContentEditor = ContentEditor;
window.SimpleEditor = SimpleEditor;
window.Globalize = Globalize;



// file: resources/server/main.js

// main node server config
//
// include dependencies
import '../assets/config';
import bodyParser from 'body-parser';
import express from 'express';
import { getAssetsPath } from '../assets/js/helpers/node-utils';

// initial attributes
const app = express();

// define assets paths of the application
process.env.NODE_PATH = __dirname;
global.getAssetsPath = getAssetsPath;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));

// Serve static files
app.use( express.static('../../public') );

// include components for server side render
require('./ssrender')(app);

if (process.env.NODE_ENV === 'production') {
    require('./server.prod')(app);
} else {
    require('./server.dev')(app);
}

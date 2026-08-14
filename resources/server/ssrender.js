// resources/server/ssrender.js
// dependencies require
import React from 'react';
import { renderToString } from 'react-dom/server';
import { StaticRouter } from 'react-router-dom';
import { Provider } from 'react-redux';
import { matchRoutes, renderRoutes } from 'react-router-config';
import { camelizeKeys } from 'humps';

// initial attributes
const routes = require( getAssetsPath('js/routers/reactroutes', __dirname) );
const factoryStore = require( getAssetsPath('js/stores/store', __dirname) ).default;

//
// request handler function
// @param req
// @param res
//
const handleRequest = (req, res) => {
    let store = null;
    // retrive data from the server request
    let promiseData = Promise.resolve(req.body);

	return promiseData.then(rawData => {

		let parsedData = camelizeKeys(rawData);
		const branch = matchRoutes(routes, req.url);

        // set host envirotment variable returned by application server
        if( parsedData.session ){
            if(parsedData.session.rootUrl) process.env.host = parsedData.session.rootUrl;
            if(parsedData.session.slugInstitution) process.env.SLUG_INSTITUTION = parsedData.session.slugInstitution;
        }

		// create redux store with preloaded state
		store = factoryStore(parsedData);

		const promises = branch.map(({ route }) => {
			let fetchData = route.component.fetchData;

			return fetchData instanceof Function ? fetchData(store) : Promise.resolve(null);
		});

		return Promise.all(promises);
	})
	.then((data) => {
		let context = {};

		const markup = renderToString(
			<Provider store={store}>
				<StaticRouter
                    basename={ process.env.NODE_ENV !== 'production' || process.env.TEST ? process.env.BASE_PATHNAME : '' }
                    location={req.url}
                    context={context}
                >
					{renderRoutes(routes, {queryParams: req.query})}
				</StaticRouter>
			</Provider>
		);

        if (context.url) {
            res.writeHead(301, {
                Location: context.url
            });

            return res.end();
        }

		return res.status(context.statusCode || 200).send({
			content: markup,
			preloadedState: JSON.stringify(store.getState())
		});
	});
}

export default function (app) {

	app.post('/messaging', (req, res) => {
		return handleRequest(req, res);
	});

	// universal routing and rendering
	app.post('*', (req, res) => {
		return handleRequest(req, res);
	});
}

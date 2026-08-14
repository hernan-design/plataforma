// file: resources/server/server.dev.js
// include dependencies
import http from 'http';
import config from '../assets/config/config.json';

export default async function (app) {
    const server = http.Server(app);

	// call to connection to app and resources
    const connect = await (await import('./connect')).default(app);

	// use websokect with socket.io
    (await import('./io')).default(server, connect.sessionStore);

	// Server http listening on port 3001
	server.listen(config.port, err => {
		if (err) { throw err; }

		console.log( 'Servidor corriendo en '+ config.host +':' + config.port );
	});
}


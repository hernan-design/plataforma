// file: resources/server/io.js
// require dependencies for realtime
import { parseCookies } from '../assets/js/helpers/misc';
import Server from 'socket.io';

export default async function (server, sessionStore) {

	// Initialize io server
	const io = new Server(server);

	// socket authorization config
	io.use((socket, next) => {

		const dataHandshake = socket.request;

		if(dataHandshake.headers['cookie']) {
			const cookies = parseCookies(dataHandshake.headers['cookie']);

			return next();
		}

		next(new Error('Authorization error'));
	});

	// Import notification io controller
    (await import( getAssetsPath('notify-realtime/controllers/io', __dirname) )).default(io, sessionStore);
};

// file: resources/server/server.prod.js
// include dependencies
import fs from 'fs';
import https from 'https';
import config from '../assets/config/config.json';
import { getCredentialsContext } from '../assets/js/helpers/node-utils';

let certs = {};

if(Array.isArray(config.certs)) {
    config.certs.forEach(cer => {
        let passCert = {
            key: cer.key,
            cert: cer.cert
        };
        if(cer.ca) { passCert.ca = cer.ca; }

        certs[cer.domain] = getCredentialsContext(passCert);
    });
}

export default async function (app) {
	// Secure options server
	const secureOpts = {
        SNICallback: (hostname, cb) => {
            const passCheck = config.certs.find(cer => cer.domain.toLowerCase() === hostname);

            if(!passCheck) {
                cb(new Error('domain not allowed'));
            }else {
                cb(null, certs[hostname]);
            }
        },
        // fallback / default domain
		key: fs.readFileSync('/usr/local/apache/ssl/coposoftware/coposoftware.key'),
		cert: fs.readFileSync('/usr/local/apache/ssl/coposoftware/STAR_coposoftware_com.crt')
	};
    console.log("Variable secureOpts :"+secureOpts)
	// include dependencies
    const serverssl = https.Server(secureOpts, app);
    console.log("Variable serverssl: "+serverssl);

	// call to connection to app and resources
    const connect = await (await import('./connect')).default(app);
    console.log("Variable connect: "+connect);
	// use websokect with socket.io
    (await import('./io')).default(serverssl, connect.sessionStore);

	// Server ssl listening on port 8443
	serverssl.listen(config.port, err => {
		if (err) { throw err; }

		console.log( 'Servidor SSL corriendo en '+ config.host +':'+ serverssl.address().port );
	});
}
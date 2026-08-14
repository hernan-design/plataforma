// file: notify-realtime/controllers/io.js
// Require dependencies for realtime notifications
import sharedsession from 'express-socket.io-session';
import Redis from 'ioredis';
import _ from 'underscore';
import mongoose from 'mongoose';
import * as Notifications from './notifications';

const { parseCookies } = require( getAssetsPath('js/helpers/misc.js', __dirname) );
const laroute          = require( getAssetsPath('js/helpers/laroute.js', __dirname) );
const tpStates         = require( getAssetsPath('js/helpers/states', __dirname) );
const config           = require( getAssetsPath('config/config.json', __dirname) );

//
// Methods and attributes
//
const redis = new Redis(config.redis.port, config.redis.host);
// Events handler to the connection Redis
redis.on('error', console.error.bind(console, 'Redis connection error:'));
const User = mongoose.model('User');
const ioUsers = {};
const hs = {};
let host = null;

// Switch notification url type
const urlNotify = {
    [ tpStates.typeNotify['friendship'] ]: nickname => (
        laroute.route('usuario.nickname', { nickname: nickname })
    ),
    [ tpStates.typeNotify['general'] ]: url => url,
    'default': url => url
};

const whereTypes = _.chain(tpStates.typeNotify)
                    .values()
                    .without(tpStates.typeNotify['friendship']).value();
/**
 * Get user from io handshake
 * @param Object hs
 * @param Function callback
 */
function getUserFromHS(hs, callback) {
	if(hs && hs.session && hs.session.user) {
		User.findById(hs.session.user, callback);
	} else {    
		callback(true, null);
	}
}

/**
 * Get last 15 general notifications and count them
 * @param user {Object}
 * @param client {Object}, socket
 */
function refreshNotifications(user, client) {
    Notifications.getNotsNCountOfUser(user, { limit:15, fields:'name nickname avatar cod -_id', where:{'type': {$in:whereTypes}, 'institution': client.handshake.session['inst_id']} }, (notificationsUser, notifyCount, err) => {
        if(err) { console.error('Error general notifications::', err); }

        // Send notifications for user
        client.emit('sendNotifications', notificationsUser, notifyCount, tpStates.typeNotify['general']);
    });

    // Get last 15 friendship notifications and count them
    Notifications.getNotsNCountOfUser(user, { limit:15, fields:'name nickname avatar cod -_id', where:{'type': tpStates.typeNotify['friendship'], 'institution': client.handshake.session['inst_id']} }, (notificationsUser, notifyCount, err) => {
        if(err) { console.error('Error friendship notifications::', err); }

        // Send notifications for user
        client.emit('sendNotifications', notificationsUser, notifyCount, tpStates.typeNotify['friendship']);
    });
}

/**
*
*/
export default function (io, sessionStore) {

	// Namespace for notifications and share session with io sockets
	const notifyio = io.of('/nsp-notify').use( sharedsession(sessionStore, { autoSave: true }) );

	// Redis broadcasting | subscribe channels
	redis.subscribe('user-channel', 'notification-channel', (err, count) => {
        console.error.bind(console, 'Did not subscribed to any Redis broadcasting channels. %s', err);
    });

	// ------------------------
	// Listen message broadcast
	// ------------------------
	redis.on('message', (channel, message) => {
		message = JSON.parse(message);

		// Streams of channel
		const toChannel = {
			// Store user notification
			'notification-channel': () => {
				// Save user notification
				if(message.event == 'App\\Events\\Notification') {

					getUserFromHS(hs[message.data.deliveredBy], (err, user) => {
						if(err) { return console.error('Error getting user for notify from getUserFromHS::', err); }

						// message.data.receivedBy = 180;
						let notify = message.data || {};
						notify.deliveredBy = user;

						Notifications.saveOne(_.clone(notify), (err, savedNotify) => {
							if(err) { console.error('Error notification save::', err); }

							const paramNotify = {
								title: savedNotify.title,
								content: savedNotify.content,
								icon: savedNotify.type == tpStates.typeNotify['friendship'] ? notify.deliveredBy.avatar: savedNotify.image,
								url: savedNotify.type == tpStates.typeNotify['friendship'] ? urlNotify[savedNotify.type](notify.deliveredBy.nickname)
										: ( typeof urlNotify[savedNotify.type] == 'function' ? urlNotify[savedNotify.type](savedNotify.url)
											: urlNotify['default'](savedNotify.url) )
                            };
                            
                            if( Array.isArray(savedNotify.receivedBy) && !_.isEmpty(savedNotify.receivedBy) ) {
                            
                                // Emit notifications for every participants
                                savedNotify.receivedBy.forEach(user => {
                                    const client =  notifyio.to(host).connected[ioUsers[user.cod]];

                                    if( client ) {
                                        client.emit(`${channel}:${message.event}`, paramNotify);

                                        // refresh notification results
                                        refreshNotifications(user, client);
                                    }
                                });
                            }else if (savedNotify.isGlobal) {

                                _.each(ioUsers, function(value, user){
                                    const client =  notifyio.to(host).connected[value];

                                    if( client ) {
                                        client.emit(`${channel}:${message.event}`, paramNotify);

                                        // refresh notification results
                                        refreshNotifications(user, client);
                                    }

                                });

                            }else {
                            
                                // Emit notification
                                const client = notifyio.to(host).connected[ioUsers[notify.receivedBy]];
                                if( client ) {
                                    // get user that receive from handshake
                                    getUserFromHS( client.handshake, (err, user) => {
                                        if(err) { console.error('Error getting user from getUserFromHS::', err); }

                                        // console.log( 'send socket::', client );
        								notifyio.to(host).connected[ioUsers[user.cod]].emit(`${channel}:${message.event}`, paramNotify);

    									if(user) {
                                            // refresh notification results
                                            refreshNotifications(user, notifyio.to(host).connected[ioUsers[user.cod]]);
    									}
    								});
    							}
                            }
						});
					});

				}else if(message.event == 'App\\Events\\LeaveNotification') {

					getUserFromHS(hs[message.data.user], (err, user) => {
						if(err) { return console.error('Error to leave notification: the user that was passed does not exist::', err); }

						let leaveNotify = message.data || {};
                        leaveNotify.user = user;
                        leaveNotify.institution || (leaveNotify.institution = hs[user.cod].session['inst_id']);

						// remove user from the notification
						Notifications.removeNotificationUser(leaveNotify, (err, removedNotify) => {
							if(err) { return console.error('Error leave notification::', err); }

							// get user that receive from handshake
                            removedNotify.receivedBy.forEach(userReceive => {
    							getUserFromHS( notifyio.to(host).connected[ioUsers[userReceive.cod]].handshake, (err, user) => {
    								if(err) { console.error('Error getting user from getUserFromHS::', err); }

    								if(user) {
                                        // refresh notification results
                                        refreshNotifications(user, notifyio.to(host).connected[ioUsers[user.cod]]);
    								}
    							});
                            });
						});
					});

				} else {
					console.log( 'El evento broadcast no esta registrado a los canales de stream de Redis.' );
				}
			},
			// Save new user in mongodb
			'user-channel': () => {
				User.saveOne(message.data, (err, user) => {
					if(err) { console.error('Error user storage from user-channel broadcast', err); }
				});
			}
		};

		// Switch channel
		if (toChannel[channel]) {
			toChannel[channel]();
		} else {
			toChannel['default']();
		}
	});

	// ------------------------
	// Listen socket connection
	// ------------------------
	notifyio.on('connection', (socket) => {

		host = socket.handshake.headers.host.split(":").shift();
		// Join to room
		socket.join(host);

		console.log( 'Un cliente se conecto al socket de notificaciones::', host);

		// When client was connected
		socket.on('checkuser', addUser => {
			const cookies = parseCookies(socket.handshake.headers['cookie']);

			addUser.id || (addUser.id = cookies._user_id);

			ioUsers[addUser.id] = socket.id;

            // assign institution id to session object from the cookies
			if(socket.handshake.session) {
				socket.handshake.session['inst_id'] = cookies._inst_id;
            }
            
            // console.log( 'ioUsers: ', ioUsers, ' -socket.handshake: ', socket.handshake );            
			// console.log( 'socket.cookies::', cookies);

			// Add user id to the session handshake io
			User.findOne({ cod: addUser.id }, (err, user) => {
				if(err) { console.error('Error checking user::', err); }

				if(user) {                
					if(socket.handshake.session) {
						socket.handshake.session['user'] = user.id;
						socket.handshake.session.save( err => {
						 	if(err) { console.error( 'Error session save::', err ); }
						});
					}

					hs[user.cod] = socket.handshake;

                    // refresh notification results
                    refreshNotifications(user, socket);
				}
			});
		});

		// When client was disconnected
		socket.on('disconnect', () => {

			// if session is enabled, then it will be disabled
			if(socket.handshake.session) {
				socket.handshake.session.destroy();
			}

            // // disconnect to DB
            // if(mongoose.connection) {
            //     mongoose.disconnect();
            // }
		});
	});
}

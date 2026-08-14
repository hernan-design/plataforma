// file: notify-realtime/controllers/notifications.js
import mongoose from 'mongoose';
import _ from 'underscore';
const { messageFormatter } = require( getAssetsPath('js/helpers/node-utils', __dirname) );
const { typeNotify } = require( getAssetsPath('js/helpers/states', __dirname) );

// initial attributes
const Notification = mongoose.model('Notification');
const User = mongoose.model('User');

// Use Globalize to format a message with plural inflection.
const likedBy = messageFormatter( "like/likedBy" );
const discussedBy = messageFormatter( "discussion/discussedBy" );

//
// Methods
//

/**
* build title for notification
* @param notify {Document|object}
* @return builtTitle {String}
*/
function buildTitle(notifyTitle, notify) {
	let builtTitle = '';

	switch(notify.type) {
		case typeNotify['like']:
			builtTitle = likedBy({
				count : _.isArray(notify.deliveredBy) ? notify.deliveredBy.length : 1,
				firstName : !_.isEmpty(notify.deliveredBy) ?
								(_.isArray(notify.deliveredBy) ? _.last(notify.deliveredBy).name : notify.deliveredBy.name)
									: null,
				secondName : !_.isEmpty(notify.deliveredBy) ?
								(_.isArray(notify.deliveredBy) ?
									(!_.isEmpty(_.initial(notify.deliveredBy)) ? _.chain(notify.deliveredBy).initial().sample().value().name : null)
										: notify.deliveredBy.name)
									: null,
				lastConcat : notifyTitle || null
			});
        break;

        case typeNotify['discussion']:
            builtTitle = discussedBy({
                count: _.isArray(notify.deliveredBy) ? notify.deliveredBy.length : 1,
                firstName : !_.isEmpty(notify.deliveredBy) ?
                                (_.isArray(notify.deliveredBy) ? _.last(notify.deliveredBy).name : notify.deliveredBy.name)
                                    : null,
                secondName : !_.isEmpty(notify.deliveredBy) ?
                                (_.isArray(notify.deliveredBy) ?
                                    (!_.isEmpty(_.initial(notify.deliveredBy)) ? _.chain(notify.deliveredBy).initial().sample().value().name : null)
                                        : notify.deliveredBy.name)
                                    : null,
                lastConcat : notifyTitle || null
            });
        break;

		default: builtTitle = notifyTitle || '';
        break;
	}

	return builtTitle;
}

/**
* Save new notification
* @param notify {Object}
* @param done {Function}
*/
export function saveOne(notify, done) {
    const findUsers = Array.isArray(notify.receivedBy) ? notify.receivedBy : [notify.receivedBy];

    // Notification all users
    if(notify.isGlobal){        
        let notification = {
            ...notify,
            title: buildTitle(notify.title, notify),
            isGlobal: notify.isGlobal
        };

        notification = new Notification(notification);
        notification.save(done);
    }
    
	// check out, whether the user that receives to exists
	User.find({ cod: { $in: findUsers } }, (err, users) => {
		if(err) { console.log("Error look up the user to notify::", err) };

        if(!err && users) {
            
            users.forEach(async user => {
                let notification = null;
                try { // save the notification for the current user or users 
                    notification = await Notification.findResource(notify, user); 
                    
                    // check out if the user has already notified
                    if(notification) {
                        if(_.findWhere(notification.deliveredBy, { id: notify.deliveredBy.id }) === undefined) {
                            notification.deliveredBy.push( notify.deliveredBy );
                            notification.title = buildTitle(notify.title, notification);
                            notification.updated = Date.now();
                            notification.save(done);
                        }
                    }else {
                        let notification = {
                            ...notify,
                            title: buildTitle(notify.title, notify),
                            receivedBy: user
                        };

                        notification = new Notification(notification);

                        notification.save(done);
                    }
                }catch(e) {
                    let notification = {
                        ...notify,
                        title: buildTitle(notify.title, notify),
                        receivedBy: user
                    };

                    notification = new Notification(notification);

                    notification.save(done);
                }
            });
		}

        // check out, if the users do not exists, else would be create them and notify them
        findUsers.forEach(codUser => {
            if(!Array.isArray(users)) { users = []; }

            if( !users.length || users.find(docUser => docUser.cod === codUser) === undefined ) {
    			const newUser = new User({ cod: codUser });

    			// if user that recive, doesn't exists, then create the user
    			newUser.save(err => {
    				if(err) return err;

                    let notification = {
                        ...notify,
                        title: buildTitle(notify.title, notify),
                        receivedBy: newUser
                    };

    				notification = new Notification(notification);
    				notification.save(done);
    			});
            }
        });
	});
};

/**
* Get user's notifications and count to all
* @param user {Object}
* @param limit {Number}
* @param done {Function}
* @return _return {Array|null}, optional
*/
export async function getNotsNCountOfUser(user, options, done) {
	if( typeof arguments[1] === 'function' ) { done = arguments[1]; }

	let _return =  null;
	const defaults = {
		limit : 0,
		fields : null,
		where : null
	};
	const settings = Object.assign({}, defaults, _.isObject(options) ? options : {});

	if(!user) { return; }

	if(user instanceof mongoose.Document) {

		return await Notification.getNotsNCount(user, settings, done);
	}else {
		const queryOne = User.findOne({ cod: parseInt(user) });

		_return = await queryOne.then(user => {
			return Notification.getNotsNCount(user, settings, done);
		}, err => {
            return err;
        });

		return _return;
	}
};

/**
* remove user from the notification
* @param leaveNotify {Object}
* @param done {Function}
*/
export function removeNotificationUser(leaveNotify, done) {

	Notification.findOne({
        institution: leaveNotify.institution,
        module: leaveNotify.module,
        resource: leaveNotify.resource,
        type: leaveNotify.type
    }, (err, notification) => {
		if (err) { return console.error("Error removing user from the notification, could be that does not exist::", err); }

		if(notification) {

			notification
			.populate('receivedBy')
			.populate({
				path: 'deliveredBy',
				select: 'name nickname avatar cod'
			}, (errIn, notify) => {
				if(errIn) { return console.log( "didn't could remove user from the notification::", errIn ) };

				// remove user from the collection of delivered by
				notify.deliveredBy.pull(leaveNotify.user._id);

				// If deliveredBy array is empty the notification will removing, else the notification will updating
				if( notify.deliveredBy.length <= 0 ) {

					notify.remove(done);
				} else {

					notify.title = buildTitle(leaveNotify.title, notify);
                    notify.updated = Date.now();

					notify.save(done);
				}
			});
		}
	});
};

// file: notify-realtime/models/notification.js
import mongoose from 'mongoose';
import _ from 'underscore';
const { typeNotify } = require( getAssetsPath('js/helpers/states', __dirname) );

export default function () {

	const Schema = mongoose.Schema;

	const notificationSchema = new Schema({
		title: { type: String, trim: true },
		content: { type: String, trim: true },
		image: String,
		receivedBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
		deliveredBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
		readBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
		deletedBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
		openedBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
		// read: { type: Boolean, 'default': false },
		isGlobal: { type: Boolean, 'default': false },
		created: { type: Date, 'default': Date.now() },
        updated: { type: Date },
		institution: { type: Number, required: true },
		url: { type: String },
		type: { type: Number, 'default': 1, required: true }, // general = 1, friendship = 2, like = 3, favorite = 4, discussion = 5
		resource: { type: Number },
		module: { type: Number }
	});

	//
	// Methods
	//

	/**
	* get notification existing
	* @param notify Object
	* @return Promise
	*/
	notificationSchema.statics.findResource = function (notify, user) {
		var notifyQuery = this.findOne({
			resource: notify.resource || null, 
			module: notify.module || null,
			institution: notify.institution,
            readBy: { $nin: [user] },
            deletedBy: { $nin: [user] },
			receivedBy: { $in: [user] },
			type: notify.type != typeNotify['general'] ? notify.type : null

		}, 'title type resource module receivedBy deliveredBy')
		.populate(
			'deliveredBy receivedBy',
			'name nickname avatar cod'
		);

        // catch error
        notifyQuery.catch(err => {
            console.error( 'Error when retrieve a notification::', err );
            return err;
        });

		return ( notifyQuery.then(notification => {
			return notification;
		}) );
	};

	/**
	* get notifications and count of them for user
	* @param user Document MongoDb
	* @param settings Object
	* @param done Function callback
	* @return Promise with param - [notificationsUser, notifyCount]
	*/
	notificationSchema.statics.getNotsNCount = async function (user, settings, done) {
		// Query notifications
		let _return = null,
            notifyCount = 0,
            notificationsUser = [];

		const Notification = this;
    	const notifyQuery = Notification.find({
			$or: [{receivedBy: user}, {isGlobal:true}],
			deletedBy: { $nin: [user] }
		}, 'title content image deliveredBy isGlobal created readBy institution url type').where(settings.where);
    	const countQuery = Notification.find({
			$or: [{receivedBy: user}, {isGlobal:true}],
			deletedBy: { $nin: [user] },
			openedBy: { $nin: [user] }
		}, 'title content image deliveredBy isGlobal created readBy institution url type').where(settings.where);

		// Get notifications quantity
		countQuery.where({ readBy: { $nin: [user] }}).count((err, count) => {
			if(!err) {
				notifyCount = count;
			}else { console.error( 'Error counting notification::', err); }

			// Get notifications
			notifyQuery.sort('-created -updated').limit(settings.limit)
				.populate('receivedBy deliveredBy', settings.fields)
				.populate({
					path: 'readBy',
					match: { '_id': user._id },
					select: 'cod _id',
					options: { limit: 1 }
				});
		});

        _return = await notifyQuery.exec((err, nots) => {
            if(err) { done(notificationsUser, notifyCount, err); return err; }

            _.each(nots, (notificationDoc, index) => {
                nots[index].deliveredBy = _.last(notificationDoc.deliveredBy);
            });

            notificationsUser = nots;

            done(notificationsUser, notifyCount);

            return [notificationsUser, notifyCount];
        });

		return _return;
	};

    // stablish hooks for methods
    notificationSchema.post('save', async function (doc) {
        await doc.populate('receivedBy', 'name nickname avatar cod').execPopulate();
    });

	const Notification = mongoose.model('Notification', notificationSchema);
};

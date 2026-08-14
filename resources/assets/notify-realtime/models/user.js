// file: notify-realtime/models/user.js
import passportLocalMongoose from 'passport-local-mongoose';
import mongoose from 'mongoose';

export default function () {

	const Schema = mongoose.Schema;

	const userSchema = new Schema({
		cod: { type: Number, unique: true, required: true },
		name: String,
		nickname: { type: String, unique: true },
		avatar: String,
		username: String,
		password: String
	});

	//
	// Methods
	//

	/**
	* Create or update user in DB
	* @param attrs Object
	* @param done Function
	* @return void
	*/
	userSchema.statics.saveOne = function (attrs, done) {

		this.findOne({ cod: attrs.cod }, (err, user) => {
			if(err) { return done(err); }

			if(user) {
				user.name = attrs.name;
				user.nickname = attrs.nickname;
				user.avatar = attrs.avatar;

				user.save(done);

				return;
			}

			user = new User(attrs);
			user.save(done);
		});
	}

    // set plugins
	userSchema.plugin(passportLocalMongoose);

	const User = mongoose.model('User', userSchema);

	return User;
};

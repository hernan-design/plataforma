// Connection to app's db and session
import mongoose from 'mongoose';
// import cookieParser from 'cookie-parser';
import session from 'express-session';
import passport from 'passport';
import { Strategy as LocalStrategy } from 'passport-local';
import connectMongo from 'connect-mongo';
import config from '../assets/config/config.json';

// initialize attributes
const MongoStore = connectMongo(session)

export default async function (app) {
    // Connection to the DB
    mongoose.connect(`mongodb://${config.db.username && config.db.password ? config.db.username +':'+ config.db.password +'@' : ''}${config.db.host}/${config.db.name}`);
    const connection = mongoose.connection;

    // Events handler to the connection DB
    connection.on('error', console.error.bind(console, 'Connection error:'));
    connection.once('open', () => { console.log('Connected to Database.'); });

    // MongoDb session storage
    const memoryStore = new MongoStore({
        mongooseConnection: connection,
        touchAfter: 24 * 3600,
        ttl: 2 * 24 * 60 * 60 // = 2 days. Default
    });

    // Session configuration
    const sessConfig = {
        key: config.session['key'],
        secret: config.session['secret'],
        resave: true,
        saveUninitialized: false,
        cookie: {
            // httpOnly: false,
            maxAge: 2 * 24 * 60 * 60 * 1000 // milliseconds
        },
        store: memoryStore
    };

    if(app.get('env') === 'production') {
        sessConfig.cookie.secure = true;
    }
    const sessionStore = session(sessConfig);
    
    // app.use( cookieParser(config.cookie.secret) );
    app.use( sessionStore );
    app.use( passport.initialize() );
    app.use( passport.session() );
    
    // import notification entry
    const { User } = await (await import(getAssetsPath('notify-realtime/notification'))).default();

    // use static authenticate method of model in LocalStrategy
    passport.use( new LocalStrategy(User.authenticate()) );

    // use static serialize and deserialize of model for passport session support
    passport.serializeUser(User.serializeUser());
    passport.deserializeUser(User.deserializeUser());

    // Return attributes
    return { app, sessionStore };
}

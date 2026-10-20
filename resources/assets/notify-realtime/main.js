// file: notify-realtime/main.js
// Include notiftication dependencies for client side
import _ from 'underscore';
import $ from 'jquery';
import moment from 'moment';
import momentDurationFormatSetup from 'moment-duration-format';
import Backbone from 'backbone';
import PageableCollection from'backbone.paginator';
import io from 'socket.io-client';
import Misc from 'js/helpers/misc';
import _tp from 'js/helpers/states';
import laroute from 'js/helpers/laroute';

import config from 'config/config.json';
// import FriendshipNotifyView form 'js/views/notification/friendshipnotify';
import GeneralNotifyView  from 'js/views/notification/generalnotify';
import NotifyViewList  from 'js/views/notification/notifylist';
import NotificationModel  from 'js/models/notification';
import NotificationList  from 'js/collections/notifications';

import 'notification-polyfill/notification';
import 'moment/locale/es.js';

//Init Attributes
Backbone.PageableCollection = PageableCollection;

$.ajaxSetup({
    cache: false,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

momentDurationFormatSetup(moment);
global._tp = _tp;
global.Misc = Misc;
global.Route = laroute;
global.moment = moment;

// socket.io client
let ioNotify = null;
if (config.NODE_ENV !== 'development') {
    ioNotify = io.connect(`${window.location.host}:${config.port}/nsp-notify`, { 
        'forceNew': true,
        'reconnectionAttempts': 2 
    });
} else {
    // Dummy object to prevent errors when ioNotify.on is called below
    ioNotify = {
        on: () => {},
        emit: () => {}
    };
}

// Initialize attributes
const PERMISSION_GRANTED = 'granted';
const PERMISSION_DENIED = 'denied';
const PERMISSION_UNKNOWN = 'unknown';
const permissionLevel = Notification.permission;

const userid = Misc.getCookie('_user_id');

// Listen connect client
ioNotify.on('connect',() => {
	ioNotify.emit('checkuser', {id: userid});
});

// ------------------
// Send notifications

// Listen predis brotcasting of laravel for notifications
ioNotify.on("notification-channel:App\\Events\\Notification", message => {
    // increase the power everytime we load test route

    sendNotification(message);
});

// Get notifications
ioNotify.on("sendNotifications", (nots, countNot, typeNot) => {
	switch(typeNot) {
		case _tp.typeNotify['general']: renderGeneralNotify({ notifications: nots, count: countNot });
			break;
		case _tp.typeNotify['friendship']: renderFriendshipNotify({ notifications: nots, count: countNot });
			break;
		default : renderGeneralNotify({ notifications: nots, count: countNot });
			break;
	}
});

/**
* Render general notifications
* @param data Object
*/
function renderGeneralNotify (data) {
	console.log( 'renderGeneralNotify::', data );

	// Render notifications quantity
	if( data.count ) {
        $('.general-notify-quantity').append(_.template((document.querySelector('#count-notify-tpl').innerHTML || ''))({ count: data.count }));
	}

	// Render notifications collection
	if( data.notifications ){

		document.querySelectorAll('.notification-opt-notify').forEach(el => {
			const generalNotifyList = new NotifyViewList({
				el: el,
				collection: new NotificationList(data.notifications),
				parameters: {
					renderTemplate: 'template'
				}
			});
		});
	}
}

/**
* Render friendship notifications
* @param data Object
*/
function renderFriendshipNotify (data) {
	console.log( 'renderFriendshipNotify::', data );

	// Render notifications quantity
	if( data.count ) {
		$('.friendship-notify-quantity').append(_.template((document.querySelector('#count-notify-tpl').innerHTML || ''))({ count: data.count }));
	}

	// Render notifications collection
	if( data.notifications ){

		document.querySelectorAll('.friendship-opt-notify').forEach(el => {
			const friendshipNotifyList = new NotifyViewList({
				el: el,
				collection: new NotificationList(data.notifications),
				parameters: {
					renderTemplate: 'templateFriendship'
				}
			});
		});
	}
}

// Listener for notification click event
function sendNotification(msgAttr) {

	// check for notifications support
	// you can omit the 'window' keyword
	if( permissionLevel === PERMISSION_UNKNOWN ) {
		// window.alert( "Notifications are not supported for this Browser/OS version yet." );
		console.log("Notifications are not supported for this Browser/OS version yet.");

		return false;
	}

	// To throw notification
	if( permissionLevel === PERMISSION_GRANTED ) {
		const notifyEl = new Notification(msgAttr.title, {
			body: msgAttr.content,
			icon: msgAttr.icon
		});

		notifyEl.onshow = () => {
			// setTimeout(() => { notifyEl.close(); }, 10000);
		}

		notifyEl.onclick = () => {
			if(msgAttr.url) { Misc.redirect( Misc.urlFull(msgAttr.url) ); }

			notifyEl.close();
		}
	}
}

// When load already DOM
window.addEventListener('load', () => {

	if( permissionLevel !== PERMISSION_GRANTED ){
		Notification.requestPermission(permission => {
			console.log( 'Permitio Notificaciones' );
		});
	}

}, false);

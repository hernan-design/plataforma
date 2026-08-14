/*
* include dependencies
*/
var elixir = require('laravel-elixir'),
		argv = require('yargs').argv;

require('laravel-elixir-sass-compass');

// Check for flags
var runRealtime = !!(argv.realtime),
		onlyLanding = !!(argv.landing),
		onlyApplication = !!(argv.application),
		copiying = !!(argv.copy),
		onlyServer = !!(argv.server),
		testProduction = !!(argv.test);

// libs path
var libsPath = './'+ elixir.config.assetsPath +'/libs';
var modulesPath = './node_modules';
// File paths to several assets are defined here.
var PATHS = {
  sass: {
  	landing: [
			libsPath +'/foundation/scss/',
			libsPath +'/Materialize/sass/',
			libsPath +'/font-awesome/scss/',
			libsPath +'/slick.js/slick/',
			libsPath +'/'
  	],
  	app: [
  		libsPath +'/foundation/scss/',
			libsPath +'/Materialize/sass/',
			libsPath +'/font-awesome/scss/',
			libsPath +'/slick.js/slick/',
			libsPath +'/'
  	]
  },

  javascript: {
  	vendorLand: [
  		libsPath +'/jquery/dist/jquery.js',
	 		libsPath +'/jquery-ui/ui/core.js',
	 		libsPath +'/jquery-ui/ui/widget.js',
	 		libsPath +'/jquery-ui/ui/menu.js',
	 		libsPath +'/jquery-ui/ui/button.js',
	 		libsPath +'/jquery-ui/ui/mouse.js',
	 		libsPath +'/jquery-ui/ui/draggable.js',
		 	libsPath +'/jquery-ui/ui/resizable.js',
	 		libsPath +'/jquery-ui/ui/position.js',
	 		libsPath +'/jquery-ui/ui/effect.js',
	 		libsPath +'/jquery-ui/ui/autocomplete.js',
		 	libsPath +'/jquery-ui/ui/dialog.js',
			libsPath +'/Materialize/js/initial.js',
		 	libsPath +'/Materialize/js/global.js',
		 	libsPath +'/Materialize/js/animation.js',
		 	libsPath +'/Materialize/js/dropdown.js',
		 	libsPath +'/Materialize/js/character_counter.js',
		 	libsPath +'/Materialize/js/forms.js',
		 	libsPath +'/Materialize/js/collapsible.js',
			libsPath +'/foundation/js/foundation/foundation.js',
		 	libsPath +'/foundation/js/foundation/foundation.abide.js',
		 	libsPath +'/foundation/js/foundation/foundation.accordion.js',
		 	libsPath +'/foundation/js/foundation/foundation.alert.js',
		 	libsPath +'/foundation/js/foundation/foundation.dropdown.js',
		 	libsPath +'/foundation/js/foundation/foundation.offcanvas.js',
		 	libsPath +'/foundation/js/foundation/foundation.reveal.js',
		 	libsPath +'/foundation/js/foundation/foundation.tab.js',
		 	libsPath +'/foundation/js/foundation/foundation.tooltip.js',
		 	libsPath +'/foundation/js/foundation/foundation.topbar.js',
		 	libsPath +'/foundation/js/foundation/foundation.magellan.js',
		 	libsPath +'/underscore/underscore.js',
		 	libsPath +'/backbone/backbone.js',
		 	libsPath +'/backbone.paginator/lib/backbone.paginator.js',
		 	libsPath +'/slick.js/slick/slick.js',
		 	libsPath +'/perfect-scrollbar/js/perfect-scrollbar.jquery.js',
		 	libsPath +'/sticky/jquery.sticky.js',
		 	libsPath +'/swfobject/swfobject/src/swfobject.js',
		 	libsPath +'/froogaloop/froogaloop.js',
		 	libsPath +'/mediaelement/build/mediaelement-and-player.js',
			libsPath +'/jQuery.dotdotdot/src/jquery.dotdotdot.js',
		 	libsPath +'/moment/moment.js',
		 	libsPath +'/moment/locale/es.js',
		 	libsPath +'/moment-duration-format/lib/moment-duration-format.js',
		 	libsPath +'/chosen/chosen.jquery.js',
			libsPath +'/select2/dist/js/select2.js',
		 	libsPath +'/select2/dist/js/i18n/es.js',
		 	libsPath +'/stellar/src/jquery.stellar.js',
		 	modulesPath +'/raphael/raphael.js'
  	],
  	landing: [
  		// Helpers landing
  		'helpers/laroute.js',
			'helpers/states.js',
			'helpers/misc.js',
			'helpers/innpulsa-colombia-map.js',

			// Models landing
			'models/callstageuser.js',
			'models/project.js',

			// Views landing
			'views/login/usersignup.js',
			'views/project/form/projectcreate.js',

			// Route landing
			'routers/routeslanding.js',

			// Scripts to initialize landing
			'initlanding.js',
			'animated.js'
  	],
  	thirdParty: [
  		libsPath +'/jquery/dist/jquery.js',
  		libsPath +'/jquery-ui/ui/core.js',
	 		libsPath +'/jquery-ui/ui/widget.js',
	 		libsPath +'/jquery-ui/ui/menu.js',
	 		libsPath +'/jquery-ui/ui/button.js',
	 		libsPath +'/jquery-ui/ui/mouse.js',
	 		libsPath +'/jquery-ui/ui/draggable.js',
		 	libsPath +'/jquery-ui/ui/resizable.js',
	 		libsPath +'/jquery-ui/ui/position.js',
	 		libsPath +'/jquery-ui/ui/effect.js',
	 		libsPath +'/jquery-ui/ui/tooltip.js',
	 		libsPath +'/jquery-ui/ui/autocomplete.js',
		 	libsPath +'/jquery-ui/ui/dialog.js',
		 	libsPath +'/jquery-ui/ui/spinner.js',
  			libsPath +'/Materialize/js/initial.js',
		 	libsPath +'/Materialize/js/global.js',
		 	libsPath +'/Materialize/js/animation.js',
		 	libsPath +'/Materialize/js/waves.js',
		 	libsPath +'/Materialize/js/buttons.js',
		 	libsPath +'/Materialize/js/dropdown.js',
		 	libsPath +'/Materialize/js/character_counter.js',
		 	libsPath +'/Materialize/js/velocity.min.js',
		 	libsPath +'/Materialize/js/forms.js',
		 	libsPath +'/Materialize/js/cards.js',
		 	libsPath +'/Materialize/js/scrollspy.js',
		 	libsPath +'/Materialize/js/hammer.min.js',
		 	libsPath +'/Materialize/js/jquery.hammer.js',
		 	libsPath +'/Materialize/js/slider.js',
		 	libsPath +'/Materialize/js/collapsible.js',
		 	libsPath +'/Materialize/js/sideNav.js',
  			libsPath +'/foundation/js/foundation/foundation.js',
		 	libsPath +'/foundation/js/foundation/foundation.abide.js',
		 	libsPath +'/foundation/js/foundation/foundation.accordion.js',
		 	libsPath +'/foundation/js/foundation/foundation.alert.js',
		 	libsPath +'/foundation/js/foundation/foundation.dropdown.js',
		 	libsPath +'/foundation/js/foundation/foundation.offcanvas.js',
		 	libsPath +'/foundation/js/foundation/foundation.reveal.js',
		 	libsPath +'/foundation/js/foundation/foundation.tab.js',
		 	libsPath +'/foundation/js/foundation/foundation.tooltip.js',
		 	libsPath +'/foundation/js/foundation/foundation.topbar.js',
		 	libsPath +'/jQuery.dotdotdot/src/jquery.dotdotdot.js',
		 	libsPath +'/datetimepicker/build/jquery.datetimepicker.full.js',
		 	elixir.config.assetsPath +'/js/helpers/entryShapeAnimator.js'
  	],
  	vendorApp: [
  		libsPath +'/jquery/dist/jquery.js',
	 		libsPath +'/jquery-ui/ui/core.js',
	 		libsPath +'/jquery-ui/ui/widget.js',
	 		libsPath +'/jquery-ui/ui/menu.js',
	 		libsPath +'/jquery-ui/ui/button.js',
	 		libsPath +'/jquery-ui/ui/mouse.js',
	 		libsPath +'/jquery-ui/ui/draggable.js',
		 	libsPath +'/jquery-ui/ui/resizable.js',
	 		libsPath +'/jquery-ui/ui/position.js',
	 		libsPath +'/jquery-ui/ui/effect.js',
			libsPath +'/jquery-ui/ui/tooltip.js',
	 		libsPath +'/jquery-ui/ui/autocomplete.js',
		 	libsPath +'/jquery-ui/ui/dialog.js',
		 	libsPath +'/jquery-ui/ui/spinner.js',
		 	libsPath +'/Materialize/js/initial.js',
		 	libsPath +'/Materialize/js/global.js',
		 	libsPath +'/Materialize/js/animation.js',
		 	libsPath +'/Materialize/js/waves.js',
		 	libsPath +'/Materialize/js/buttons.js',
		 	libsPath +'/Materialize/js/dropdown.js',
		 	libsPath +'/Materialize/js/character_counter.js',
		 	libsPath +'/Materialize/js/velocity.min.js',
		 	libsPath +'/Materialize/js/forms.js',
		 	libsPath +'/Materialize/js/cards.js',
		 	libsPath +'/Materialize/js/scrollspy.js',
		 	libsPath +'/Materialize/js/hammer.min.js',
		 	libsPath +'/Materialize/js/jquery.hammer.js',
		 	libsPath +'/Materialize/js/slider.js',
		 	libsPath +'/Materialize/js/collapsible.js',
		 	libsPath +'/Materialize/js/sideNav.js',
		 	// libsPath +'/wnumb/wNumb.js',
		 	// libsPath +'/nouislider/distribute/nouislider.js',
		 	libsPath +'/Materialize/extras/noUiSlider/nouislider.js',
		 	libsPath +'/foundation/js/foundation/foundation.js',
		 	libsPath +'/foundation/js/foundation/foundation.abide.js',
		 	libsPath +'/foundation/js/foundation/foundation.accordion.js',
		 	libsPath +'/foundation/js/foundation/foundation.alert.js',
		 	libsPath +'/foundation/js/foundation/foundation.dropdown.js',
		 	libsPath +'/foundation/js/foundation/foundation.offcanvas.js',
		 	libsPath +'/foundation/js/foundation/foundation.reveal.js',
		 	libsPath +'/foundation/js/foundation/foundation.tab.js',
		 	libsPath +'/foundation/js/foundation/foundation.tooltip.js',
		 	libsPath +'/foundation/js/foundation/foundation.topbar.js',
		 	libsPath +'/underscore/underscore.js',
		 	libsPath +'/backbone/backbone.js',
		 	libsPath +'/backbone.paginator/lib/backbone.paginator.js',
		 	libsPath +'/jquery.tagsinput/src/jquery.tagsinput.js',
		 	libsPath +'/chosen/chosen.jquery.js',
		 	libsPath +'/wysiwyg.js/src/wysiwyg.js',
		 	libsPath +'/wysiwyg.js/src/wysiwyg-editor.js',
		 	libsPath +'/jqcloud2/dist/jqcloud.js',
		 	libsPath +'/swfobject/swfobject/src/swfobject.js',
		 	libsPath +'/slick.js/slick/slick.js',
		 	libsPath +'/fineuploader-dist/dist/all.fine-uploader.js',
		 	libsPath +'/fineuploader-dist/dist/jquery.fine-uploader.js',
		 	libsPath +'/jcrop/js/jquery.Jcrop.js',
		 	libsPath +'/moment/moment.js',
		 	libsPath +'/moment/locale/es.js',
		 	libsPath +'/moment-duration-format/lib/moment-duration-format.js',
		 	libsPath +'/fullcalendar/dist/fullcalendar.js',
		 	libsPath +'/fullcalendar/dist/lang/es.js',
		 	libsPath +'/datetimepicker/build/jquery.datetimepicker.full.js',
		 	libsPath +'/sticky/jquery.sticky.js',
		 	libsPath +'/perfect-scrollbar/js/perfect-scrollbar.jquery.js',
		 	libsPath +'/alertify.js/lib/alertify.js',
		 	libsPath +'/stellar/src/jquery.stellar.js',
		 	libsPath +'/froogaloop/froogaloop.js',
		 	libsPath +'/mediaelement/build/mediaelement-and-player.js',
		 	libsPath +'/imagelightbox/src/imagelightbox.js',
		 	libsPath +'/notify/notification.js',
		 	libsPath +'/select2/dist/js/select2.js',
		 	libsPath +'/select2/dist/js/i18n/es.js',
			libsPath +'/jQuery.dotdotdot/src/jquery.dotdotdot.js',
		 	libsPath +'/inputmask/dist/inputmask/inputmask.js',
		 	libsPath +'/inputmask/dist/inputmask/inputmask.extensions.js',
		 	libsPath +'/inputmask/dist/inputmask/inputmask.numeric.extensions.js',
		 	libsPath +'/inputmask/dist/inputmask/inputmask.phone.extensions.js',
		 	libsPath +'/inputmask/dist/inputmask/jquery.inputmask.js',
		 	libsPath +'/chart.js/dist/Chart.js'
  	],
  	app: [
  		// Helpers application
  		'helpers/events-priority.js',
			'helpers/laroute.js',
  			'helpers/states.js',
			'helpers/misc.js',
			'helpers/wysiwyg-config.js',
			'helpers/mep-woopranalytics.js',
			'helpers/image-uploader-crop.js',
			'views/login/usersignup.js',
			'views/login/googlerecaptcha.js',

			// Models application
			'models/basemodel.js',
			'models/breadcrumb.js',
			'models/urlmetadata.js',
			'models/user.js',
			'models/advice.js',
			'models/mentoring.js',
			'models/entity.js',
			'models/event.js',
			'models/eventuser.js',
			'models/like.js',
			'models/project.js',
			'models/projectbusinessmodel.js',
			'models/call.js',
			'models/callstageuser.js',
			'models/team.js',
			'models/survey.js',
			'models/course.js',
			'models/coursetheme.js',
			'models/coursethemeattached.js',
			'models/courseattachment.js',
			'models/registrationcourse.js',
			'models/blogarticle.js',
			'models/mentoringevaluation.js',
			'models/projectteam.js',
			'models/mentor.js',
			'models/mentoringtags.js',
			'models/mentoringtask.js',
			'models/mentoringcalificationtask.js',
			'models/mentoringprocess.js',
			'models/mentoringitem.js',
			'models/mentorigsession.js',
			'models/marketplace.js',
			'models/marketplaceagreement.js',
			'models/purchase.js',
			// 'models/purchasedetail.js',
			'models/mentorentrepreneur.js',
			// 'models/calendar.js',
			'models/userreason.js',
			'models/usereducation.js',
			'models/userspeciality.js',
			'models/userinterest.js',
			'models/usernetwork.js',
			'models/discussioncomment.js',
			'models/usernote.js',
			'models/attachment.js',
			'models/evaluationpurchase.js',
			'models/faq.js',
			'models/projectinterest.js',
			'models/projectsponsor.js',
			'models/group.js',
			'models/groupproject.js',
			'models/groupcluster.js',
			'models/notification.js',
			'models/personeconomicsector.js',
			'models/recommendation.js',
			'models/mentorevaluation.js',
			'models/discussion.js',
			'models/discussionparticipant.js',
			'models/projectevaluation.js',
			'models/itemevaluation.js',
			'models/evaluationitementrepreneur.js',
			'models/favorite.js',
			'models/offer.js',
			'models/promotion.js',
			'models/voucher.js',

			// Collection application
			'collections/likes.js',
			'collections/userlikes.js',
			'collections/projects.js',
			'collections/projectsuser.js',
			'collections/calls.js',
			'collections/teams.js',
			'collections/surveys.js',
			'collections/surveyquestions.js',
			'collections/course.js',
			'collections/coursethemes.js',
			'collections/courseattachments.js',
			'collections/blogarticles.js',
			'collections/coursethemeattachments.js',
			'collections/entities.js',
			'collections/events.js',
			'collections/eventusers.js',
			'collections/projectteams.js',
			'collections/mostviewedarticles.js',
			'collections/mentoringquestions.js',
			'collections/mentoringsessions.js',
			'collections/mentoringtasks.js',
			'collections/mentoringtags.js',
			'collections/mentoringcalificationtasks.js',
			'collections/mentoringprocesslist.js',
			'collections/mentoringitems.js',
			'collections/marketplaces.js',
			'collections/promotions.js',
			'collections/projectproducts.js',
			'collections/userreasons.js',
			'collections/usereducation.js',
			'collections/userspecialities.js',
			'collections/userinterests.js',
			'collections/discussions.js',
			'collections/discussioncomments.js',
			'collections/usernotes.js',
			'collections/registrationcourses.js',
			'collections/usernetworks.js',
			'collections/users.js',
			'collections/buys.js',
			'collections/productattachments.js',
			// 'collections/purchasedetails.js',
			'collections/sales.js',
			'collections/saledetails.js',
			'collections/faqprograms.js',
			'collections/participantsprogramuser.js',
			'collections/projectinterests.js',
			'collections/projectsponsors.js',
			'collections/projectattachments.js',
			'collections/groups.js',
			'collections/groupclusters.js',
			'collections/notifications.js',
			'collections/personeconomicsectors.js',
			'collections/mentors.js',
			'collections/mentorevaluations.js',
			'collections/discussionparticipants.js',
			'collections/projectevaluations.js',
			'collections/itemevaluations.js',

			// Views application
			'views/breadcrumb.js',
			'views/menufilter.js',
			'views/paginator.js',
			'views/previewpost.js',
			'views/sectiontitle.js',
			'views/eventmodal.js',
			'views/mentoring/mentoringbase.js',
			'views/mentoring/mentoringquestionitem.js',
			'views/mentoring/mentoringquestionitemgrid.js',
			'views/mentoring/mentoringquestionlist.js',
			'views/mentoring/mentoringsessionpagelist.js',
			'views/mentoring/mentoringsessionlist.js',
			'views/mentoring/mentoringquestion.js',
			'views/mentoring/mentoringconfirmclose.js',
			'views/mentoring/mentoringcalendar.js',
			'views/mentoring/mentoringevalsession.js',
			'views/mentoring/mentoringevalsessionitem.js',
			'views/mentoring/mentoringevalsessionlist.js',
			'views/mentoring/mentoringsessionlistitem.js',
			'views/mentoring/mentoringsessionitem.js',
			'views/mentoring/mentoringsession.js',
			'views/mentoring/mentorignitemsessionlist.js',
			'views/mentoring/scheduleadviser.js',
			'views/mentoring/mentoringtask.js',
			'views/mentoring/mentoringtasklist.js',
			'views/mentoring/mentoringtaskconfirmremove.js',
			'views/mentoring/mentoringcalificationtask.js',
			'views/mentoring/mentoringcalificationtaskitem.js',
			'views/mentoring/mentoringcalificationtasklist.js',
			'views/mentoring/form/editmentor.js',
			'views/mentoring/form/mentoreditassistance.js',
			'views/mentoring/form/mentoreditexperience.js',
			'views/mentoring/form/mentoreditexpertise.js',
			'views/mentoring/form/creatementor.js',
			'views/mentoring/form/mentorleveldevelopment.js',
			'views/mentoring/form/mentoreditsocials.js',
			'views/mentoring/form/mentorattachments.js',
			'views/mentoring/editmentorspecialities.js',
			'views/mentoring/mentorspecialitiesitem.js',
			'views/mentoring/editpersoneconomicsectorlist.js',
			'views/mentoring/personeconomicsectoritem.js',
			'views/mentoring/mentorlist.js',
			'views/mentoring/mentoritem.js',
			'views/mentoring/profilementor.js',
			'views/mentoring/mentoringavailability.js',
			'views/mentoring/confirmremoveprocessmentoring.js',
			'views/mentoring/mentorevaluation.js',
			'views/mentoring/mentoringquestiondocument.js',
			'views/mentoring/process/processmentoring.js',
			'views/mentoring/process/processmentor.js',
			'views/mentoring/process/proccessmentorlist.js',
			'views/like.js',
			'views/vote.js',
			'views/userlikes.js',
			'views/userlikeslist.js',
			'views/project/projectbase.js',
			'views/project/project.js',
			'views/project/projectlist.js',
			'views/project/projectitem.js',
			'views/project/projectbusinessmodel.js',
			'views/project/projectproductlist.js',
			'views/project/projectproductitem.js',
			'views/project/projectprogramlist.js',
			'views/project/projectprogramitem.js',
			'views/project/discussionprojecthide.js',
			'views/project/projectprivacyactions.js',
			'views/project/projectinterestitem.js',
			'views/project/projectitemroster.js',
			'views/project/projectmembersitem.js',
			'views/project/projectsponsoritem.js',
			'views/project/projectsurveylist.js',
			'views/project/projectsurveyitem.js',
			'views/project/form/projectcreate.js',
			'views/project/form/projectstepbase.js',
			'views/project/form/editproject.js',
			'views/project/form/projecteditname.js',
			'views/project/form/projecteditlocation.js',
			'views/project/form/projecteditindustry.js',
			'views/project/form/projectedittag.js',
			'views/project/form/projecteditvideo.js',
			'views/project/form/projecteditsocials.js',
			'views/project/form/projecteditinterests.js',
			'views/project/form/projecteditdescription.js',
			'views/project/form/projecteditmembers.js',
			'views/project/form/projecteditsponsors.js',
			'views/project/form/projecteditsummary.js',
			'views/project/form/projecteditpageweb.js',
			'views/project/form/projecteditnumerowhatsapp.js',
			'views/project/form/projecteditmailcontact.js',
			'views/project/form/projecteditdocuments.js',
			'views/call/call.js',
			'views/call/calllist.js',
			'views/call/callitem.js',
			'views/call/applytouser.js',
			'views/call/faqprogramlist.js',
			'views/call/faqprogramitem.js',
			'views/call/participantsprogramuserlist.js',
			'views/call/participantsprogramusertitem.js',
			'views/call/apply/applyprogram.js',
			'views/call/apply/applytermsprogram.js',
			'views/call/apply/applyentityprogram.js',
			'views/call/apply/applyuserprogram.js',
			'views/call/apply/applyformprogram.js',
			'views/call/apply/applyeditentityprogram.js',
			'views/call/apply/applyedituserprogram.js',
			'views/user/profile.js',
			'views/user/userprojectlist.js',
			'views/user/userteamitem.js',
			'views/user/userteamlist.js',
			'views/user/usersurveyitem.js',
			'views/user/usersurveylist.js',
			'views/user/userwallpost.js',
			'views/user/userwallpostlist.js',
			'views/user/userwallcomment.js',
			'views/user/userwallcommentlist.js',
			'views/user/usercalendar.js',
			'views/user/confirmmentoring.js',
			'views/user/confirmmentoringprofile.js',
			'views/user/usercreateevent.js',
			'views/user/userrequestmentoring.js',
			'views/user/requestmentoring.js',
			'views/user/userreasonitem.js',
			'views/user/usereducationitem.js',
			'views/user/userspecialityitem.js',
			'views/user/userinterestitem.js',
			'views/user/confirmremovementoring.js',
			'views/user/usernetworklist.js',
			'views/user/usernetworkitem.js',
			'views/user/usercontactconfirmhide.js',
			'views/user/userlist.js',
			'views/user/useritem.js',
			'views/user/pendingfriendshiplist.js',
			'views/user/pendingfriendshipitem.js',
			'views/user/usermessagecontact.js',
			'views/user/usermessage.js',
			'views/user/usermessagelist.js',
			'views/user/usermessageitem.js',
			'views/user/userproductlist.js',
			'views/user/userprogramlist.js',
			'views/user/userproductitem.js',
			'views/user/userprogramitem.js',
			'views/user/form/editprofile.js',
			'views/user/form/usereditname.js',
			'views/user/form/usereditlocation.js',
			'views/user/form/usereditbiography.js',
			'views/user/form/usereditsocials.js',
			'views/user/form/usereditbasicdata.js',
			'views/user/form/usereditexperience.js',
			'views/user/form/usereditreasons.js',
			'views/user/form/userediteducation.js',
			'views/user/form/usereditspecialities.js',
			'views/user/form/usereditinterests.js',
			'views/user/form/buttonsfriendly.js',
			'views/course/coursebrowselist.js',
			'views/course/coursebrowseitemnoted.js',
			'views/course/courseNotedList.js',
			'views/course/coursebrowseitem.js',
			'views/course/course.js',
			'views/course/coursethemebase.js',
			'views/course/coursecontent.js',
			'views/course/coursethemelist.js',
      'views/course/courseclass.js',
      'views/course/coursesurvey.js',
			'views/course/coursethemeitem.js',
			'views/course/coursethemeclassitem.js',
			'views/course/coursethemes.js',
			'views/course/coursethemeattached.js',
			'views/course/courseconfirmunsubscribe.js',
			'views/course/courseattachedlist.js',
			'views/course/courseattacheditem.js',
			'views/course/usernotelist.js',
			'views/course/usernoteitem.js',
			'views/course/userregistrationlist.js',
			'views/course/userregistrationitem.js',
			'views/course/coursebase.js',
			'views/blog/articleitem.js',
			'views/blog/articlelist.js',
			'views/blog/article.js',
			'views/blog/mostviewedarticlelist.js',
			'views/blog/mostviewedarticleitem.js',
			'views/blog/articlebase.js',
			'views/blog/mostviewedinternalarticle.js',
			'views/blog/articleactions.js',
			'views/blog/form/createarticle.js',
			'views/blog/form/editarticle.js',
			'views/blog/form/editarticle.js',
			'views/blog/form/articleeditbasic.js',
			'views/blog/form/articleeditdescription.js',
			'views/marketplace/marketplacebase.js',
			'views/marketplace/marketplacebrowse.js',
			'views/marketplace/marketplacedetail.js',
			'views/marketplace/deliverablesagreement.js',
			'views/marketplace/marketplaceproductitem.js',
			'views/marketplace/marketplacetrendingitem.js',
			'views/marketplace/marketplacetrendinglist.js',
			'views/marketplace/marketplacepromotionsitem.js',
			'views/marketplace/marketplacepromotionslist.js',
			'views/marketplace/marketplacepurchase.js',
			'views/marketplace/discussionhide.js',
			'views/marketplace/mybuylist.js',
			'views/marketplace/mybuyitem.js',
			'views/marketplace/saleslist.js',
			'views/marketplace/salesitem.js',
			'views/marketplace/promotionslist.js',
			'views/marketplace/promotionsitem.js',
			// 'views/marketplace/saledetaillist.js',
			// 'views/marketplace/saledetailitem.js',
			'views/marketplace/marketplaceproductactions.js',
			'views/marketplace/marketplacesaleactions.js',
			'views/marketplace/marketplacepurchaseevaluation.js',
			'views/marketplace/marketplacepurchasegeneralevaluation.js',
			'views/marketplace/form/createseller.js',
			'views/marketplace/form/createproduct.js',
			'views/marketplace/form/createpromotion.js',
			'views/marketplace/form/marketplaceedit.js',
			'views/marketplace/form/marketplaceeditbasic.js',
			'views/marketplace/form/marketplaceeditsummary.js',
			'views/marketplace/form/marketplaceeditclassification.js',
			'views/marketplace/form/marketplaceeditdescription.js',
			'views/marketplace/form/marketplaceeditlocation.js',
			'views/marketplace/form/createsaleagreement.js',
			'views/marketplace/form/marketplaceagreementcar.js',
			'views/marketplace/productdetailgalleryimage.js',
			'views/marketplace/productgalleryimage.js',
			'views/marketplace/productgallery.js',
			'views/marketplace/marketplacepurchaseactions.js',
			'views/marketplace/marketplacepayment.js',
			'views/marketplace/cargaentregables.js',
			'views/calendar/eventitem.js',
			'views/calendar/eventlist.js',
			'views/calendar/event.js',
			'views/calendar/eventparticipate.js',
			'views/calendar/eventparticipantslist.js',
			'views/calendar/eventparticipantsitem.js',
			'views/calendar/eventparticipantscall.js',
			'views/calendar/form/editevent.js',
			'views/calendar/form/eventeditcity.js',
			'views/calendar/form/eventeditbasic.js',
			'views/calendar/form/eventeditdescription.js',
			'views/middleware/verifyaccount.js',
			'views/middleware/stepprofile.js',
			'views/middleware/stepchannels.js',
			'views/filterdata.js',
			'views/recommendation.js',
			'views/requestadvisory.js',
			'views/group/groupbuttonaction.js',
			'views/group/groupitem.js',
			'views/group/groupitemroster.js',
			'views/group/grouplist.js',
			'views/group/group.js',
			'views/group/groupteamitem.js',
			'views/group/groupteamlist.js',
			'views/group/jointocompanygroup.js',
			'views/group/groupclusteritem.js',
			'views/group/groupclusterlist.js',
			'views/group/form/editgroup.js',
			'views/survey/survey.js',
			'views/survey/imageuploaderquestion.js',
			'views/survey/surveyquestion.js',
			'views/survey/surveyreview.js',
			'views/confirmwindow.js',
			// 'views/notification/friendshipnotify.js',
			'views/notification/generalnotify.js',
			'views/notification/notificationlist.js',
			'views/discussion/discussion.js',
			'views/discussion/discussionlist.js',
			'views/discussion/discussionitem.js',
			'views/discussion/discussioncommentlist.js',
			'views/discussion/discussioncommentitem.js',
			'views/discussion/discussionparticipantslist.js',
			'views/discussion/discussionparticipantsitem.js',
			'views/evaluator/evaluationprojectbase.js',
			'views/evaluator/evaluationitemdocument.js',
			'views/evaluator/evaluationprojectitem.js',
			'views/evaluator/evaluationprojectlist.js',
			'views/evaluator/evaluationprojectdetail.js',
			// 'views/evaluator/evaluationitemlist.js',
			'views/evaluator/evaluationitem.js',
			'views/favorite.js',
			'views/gallery/galleryedititem.js',
			'views/gallery/gallerylist.js',
			'views/vote/vote.js',
			'views/vote/voteverify.js',

			// Route application
			'routers/routes.js',

			// Scripts to initilize application
			'init.js',
			'animated.js'
  	]
  },

  css: {
  	landing: [
			libsPath +'/jquery-ui/themes/base/core.css',
			libsPath +'/jquery-ui/themes/base/accordion.css',
			libsPath +'/jquery-ui/themes/base/button.css',
			libsPath +'/jquery-ui/themes/base/datepicker.css',
			libsPath +'/jquery-ui/themes/base/dialog.css',
			libsPath +'/jquery-ui/themes/base/draggable.css',
			libsPath +'/jquery-ui/themes/base/menu.css',
			libsPath +'/jquery-ui/themes/base/progressbar.css',
			libsPath +'/jquery-ui/themes/base/resizable.css',
			libsPath +'/jquery-ui/themes/base/selectable.css',
			libsPath +'/jquery-ui/themes/base/selectmenu.css',
			libsPath +'/jquery-ui/themes/base/sortable.css',
			libsPath +'/jquery-ui/themes/base/slider.css',
			libsPath +'/jquery-ui/themes/base/spinner.css',
			libsPath +'/jquery-ui/themes/base/tabs.css',
			libsPath +'/jquery-ui/themes/base/tooltip.css',
			libsPath +'/jquery-ui/themes/base/theme.css',
			libsPath +'/perfect-scrollbar/css/perfect-scrollbar.css',
			libsPath +'/mediaelement/build/mediaelementplayer.css',
			libsPath +'/chosen/chosen.css',
			libsPath +'/select2/dist/css/select2.css'
  	],
  	app: [
			libsPath +'/jquery-ui/themes/base/core.css',
			libsPath +'/jquery-ui/themes/base/accordion.css',
			libsPath +'/jquery-ui/themes/base/button.css',
			libsPath +'/jquery-ui/themes/base/datepicker.css',
			libsPath +'/jquery-ui/themes/base/dialog.css',
			libsPath +'/jquery-ui/themes/base/draggable.css',
			libsPath +'/jquery-ui/themes/base/menu.css',
			libsPath +'/jquery-ui/themes/base/progressbar.css',
			libsPath +'/jquery-ui/themes/base/resizable.css',
			libsPath +'/jquery-ui/themes/base/selectable.css',
			libsPath +'/jquery-ui/themes/base/selectmenu.css',
			libsPath +'/jquery-ui/themes/base/sortable.css',
			libsPath +'/jquery-ui/themes/base/slider.css',
			libsPath +'/jquery-ui/themes/base/spinner.css',
			libsPath +'/jquery-ui/themes/base/tabs.css',
			libsPath +'/jquery-ui/themes/base/tooltip.css',
			libsPath +'/jquery-ui/themes/base/theme.css',
			libsPath +'/chosen/chosen.css',
			libsPath +'/wysiwyg.js/src/wysiwyg-editor.css',
			libsPath +'/jqcloud2/dist/jqcloud.css',
			libsPath +'/fineuploader-dist/dist/fine-uploader-new.css',
			libsPath +'/jcrop/css/jquery.Jcrop.css',
			libsPath +'/fullcalendar/dist/fullcalendar.css',
			libsPath +'/datetimepicker/jquery.datetimepicker.css',
			libsPath +'/perfect-scrollbar/css/perfect-scrollbar.css',
			libsPath +'/alertify.js/themes/alertify.core.css',
			libsPath +'/alertify.js/themes/alertify.default.css',
			libsPath +'/mediaelement/build/mediaelementplayer.css',
			libsPath +'/imagelightbox/src/imagelightbox.css',
			libsPath +'/select2/dist/css/select2.css',
			libsPath +'/nouislider/distribute/nouislider.css',
			libsPath +'/Materialize/extras/noUiSlider/nouislider.css',
			modulesPath + '/summernote/dist/summernote-lite.css'
			// modulesPath + '/react-summernote/dist/react-summernote.css'
  	]
  },

  // copy paths object declare
  copy: {}
};

// fonts
// -----
// move awesome fonts to public/css/ directory
PATHS.copy[libsPath +'/font-awesome/fonts/**'] = elixir.config.publicPath +'/build/css/fonts/';
// move slick fonts to public/css/ directory
PATHS.copy[libsPath +'/slick.js/slick/fonts/**'] = elixir.config.publicPath +'/build/css/fonts/';
// move material design icons fonts to public/css/ directory
PATHS.copy[libsPath +'/mdi/fonts/**'] = elixir.config.publicPath +'/build/css/fonts/';
// move summernote fonts
PATHS.copy[modulesPath + '/summernote/dist/font/**.{eot,ttf,woff}'] = elixir.config.publicPath +'/build/css/fonts/';

// Institution fonts
// -----
PATHS.copy[elixir.config.assetsPath +'/css/fonts/**'] = elixir.config.publicPath +'/css/institution/fonts/';

// images
// ------
//move chosen's images to public/img
PATHS.copy[libsPath +'/chosen/**.png'] = elixir.config.publicPath +'/img/';
//move slick's images to public/img
PATHS.copy[libsPath +'/slick.js/slick/**.{png,gif}'] = elixir.config.publicPath +'/img/';
//move fine-uploader images to public/img
PATHS.copy[libsPath +'/fineuploader-dist/dist/placeholders/**.{png,gif}'] = elixir.config.publicPath +'/img/';
//move mediaelement images to public/img/mediaelement
PATHS.copy[libsPath +'/mediaelement/build/*.{png,gif}'] = elixir.config.publicPath +'/img/mediaelement/';
//move jQuery ui images to public/img/jquery-ui/ directory
PATHS.copy[libsPath +'/jquery-ui/themes/base/images/**.png'] = elixir.config.publicPath +'/img/jquery.ui/';

PATHS.copy[libsPath +'/jcrop/css/Jcrop.gif'] = elixir.config.publicPath +'/build/css/Jcrop.gif';
PATHS.copy[libsPath +'/fine-uploader/dist/edit.gif'] = elixir.config.publicPath +'/build/css/edit.gif';

// javascript
// ----------
// move extra for jquery.inputmask
PATHS.copy[libsPath +'/inputmask/dist/inputmask/phone-codes/**.js'] = elixir.config.publicPath +'/build/js/vendor/phone-codes/';

// others
// ------
// player flashmediaelement.js and silverlightmediaelement.js for swf
PATHS.copy[libsPath +'/mediaelement/build/flashmediaelement.swf'] = elixir.config.publicPath +'/js/vendor/flashmediaelement.swf';
PATHS.copy[libsPath +'/mediaelement/build/silverlightmediaelement.xap'] = elixir.config.publicPath +'/js/vendor/silverlightmediaelement.xap';

// ---------------------------
// Initialize taks with elixir
// ---------------------------
elixir(function (mix) {

	if(!runRealtime) {
		// Minify javascript
		// -----------------
		if(!onlyApplication && !copiying) {
			mix.scripts(PATHS.javascript['vendorLand'],
				elixir.config.publicPath +'/js/vendor/vendor-landing.min.js'
			);
			mix.scripts(PATHS.javascript['landing'],
				elixir.config.publicPath +'/js/landing.min.js'
			);
		}
		if(!onlyLanding && !copiying) {
			mix.scripts(PATHS.javascript['vendorApp'],
				elixir.config.publicPath +'/js/vendor/vendor.min.js'
			);
			mix.scripts(PATHS.javascript['app'],
				elixir.config.publicPath +'/js/app.min.js'
			);
			mix.scripts(PATHS.javascript['thirdParty'],
				elixir.config.publicPath +'/js/vendor/third-party.js'
			);
		}
		mix.scripts( libsPath + '/foundation/js/vendor/modernizr.js', elixir.config.publicPath +'/js/vendor/modernizr.min.js');

		// Sass compiles with compass
		// -------------------------
		if(!onlyLanding && !copiying) {
			mix.compass("application.scss", elixir.config.publicPath +'/css', {
				sourcemap: ! elixir.config.production,
				import_path: PATHS.sass['app'],
				javascript: elixir.config.publicPath + '/build/' + elixir.config.js.outputFolder,
				css: elixir.config.publicPath +'/css',
				image: 'img',
				font: 'build/css/fonts'
			});
		}

		if(!onlyApplication && !copiying) {
			mix.compass("landing.scss", elixir.config.publicPath +'/css', {
				sourcemap: ! elixir.config.production,
				import_path: PATHS.sass['landing'],
				javascript: elixir.config.publicPath + '/build/' + elixir.config.js.outputFolder,
				css: elixir.config.publicPath +'/css',
				image: 'img',
				font: 'build/css/fonts'
			});
		}

		// Minify css
        // ----------
        if(!onlyApplication && !copiying) {
            mix.styles(PATHS.css['landing'],
                elixir.config.publicPath +'/css/vendor-landing.min.css'
            )
        }

        if(!onlyLanding && !copiying) {
            mix.styles(PATHS.css['app'],
                elixir.config.publicPath +'/css/vendor.min.css'
            );
        }

        // Copy files
        // ----------
        if(copiying || elixir.config.production) {
		 	for (var fileCopy in PATHS.copy) {
		  	mix.copy( fileCopy, PATHS.copy[fileCopy] );
		 	}
	    }
	}

	// Compile with browserify
	// ------------------------
	// browserify config to production
	if(elixir.config.production) {
		elixir.config.js.browserify.transformers.push({
			name: 'envify',
			options: {
				NODE_ENV: 'production',
				TEST: testProduction
			}
		});
		elixir.config.js.browserify.transformers.push({ name: 'uglifyify' });
		elixir.config.js.browserify.plugins.push({ name: 'bundle-collapser/plugin' });
	}

	// run if --realtime flag was passed
	if(runRealtime || elixir.config.production) {
		mix.browserify('/notify-realtime/main.js', elixir.config.publicPath +'/js/realtime.app.js', elixir.config.assetsPath);
	}
	// bundle application with browserify
	if(!onlyLanding && !copiying && !runRealtime) {
		mix.browserify('/js/app-client.js', elixir.config.publicPath +'/js/bundle.js', elixir.config.assetsPath);
		mix.browserify('/js/components/main.js', elixir.config.publicPath +'/js/component.js', elixir.config.assetsPath);
	}

	// Cache busting
    // -------------
    mix.version([
        'css/application.css',
        'css/vendor.min.css',
        'css/landing.css',
        'css/vendor-landing.min.css',
        'js/app.min.js',
        'js/landing.min.js',
        'js/vendor/vendor-landing.min.js',
        'js/vendor/vendor.min.js',
        'js/vendor/third-party.js',
        'js/bundle.js',
        'js/realtime.app.js',
        'js/component.js'
    ]);

    // refresh automatically the browser
    // --------------------------------
    // mix.browserSync({
    //     proxy: 'project.dev'
    // });
});
/**
* Class UserProfileView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserProfileView = Backbone.View.extend({

        el: '#user-content',
        template: _.template( ($('#user-profile-tpl').html() || '') ),
        templateMainImg: _.template( ($('#main-image-profile-user-tpl').html() || '') ),
        templateDeskNotify: _.template( ($('#desktop-notify-permission-tpl').html() || '') ),
        events: {
            'click .get-databasic-user': 'onGetDataBasic',
            // 'click .get-wall-user': 'onGetWall',
            'click .get-projects-user': 'onGetProjects',
            'click .get-calendar-user': 'onGetCalendar',
            'click .get-preferences-user': 'onGetPreferences',
            'click .get-contacts-user': 'onGetContacts',
            'click .get-messages-user': 'onGetMessages',
            'click .get-product-user': 'onGetProducts',
            'click .get-program-user': 'onGetPrograms',
            // 'click .get-surveys-user': 'onGetSurveys',
            'click #change-photo-user': 'onChangeImage',
            'click .request-permission-notify': 'onPermissionNotify'
        },
        parameters: {
            tab: 'basico',
            dataFilter: {}
        },
        isDefault: true,

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

            // extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                _.extend(this.parameters, opts.parameters);

            //Init Attributes
            this.$modalBase = $('#modal-base-tp');
            this.$modalBase.find('.content-modal').addClass('reset-content');
            this.$imgCropUser = $('#image-user-tocrop');
            this.$modalImageCrop = $('#modal-chage-avatar');


            // this.wallPostList = new app.WallPostList();
            this.projectList = new app.ProjectUserList();
            this.teamList = new app.TeamList();
            // this.surveysList = new app.SurveysList();
            this.reasonList = new app.UserReasonList();
            this.educationList = new app.UserEducationList();
            this.specialitiesList = new app.UserSpecialitiesList();
            this.interestsList = new app.UserInterestsList();
            this.mentorEntrepreneurModel = new app.MentorEntrepreneurModel();
            this.callList = new app.CallList();
            this.callList.url = function () {
				return window.Misc.urlFull( Route.route('usuario.convocatorias.index') );
			};

            this.userNetworkModel = new app.UserNetworkModel();
            this.userNetworkList = new app.UserNetworkList();
            this.pendingFriendshipList = new app.UserNetworkList();
            this.marketPlaceList = new app.MarketPlaceList();
            this.notifyPermissionLevel = Notification.permission;

            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

            // Change modal title
            this.$modalBase.find('.inner-title-modal').html('Solicitud Mentoria').attr('area-title');

        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON(),
                socialAttrs = this.socialModel instanceof Backbone.Model ? this.socialModel.toJSON() : {},
                _this = this;

            _.extend(attributes, {
                facebook_usuario: socialAttrs.facebook_usuario || attributes.facebook_usuario,
                linkedin_usuario: socialAttrs.linkedin_usuario || attributes.linkedin_usuario,
                twitter_usuario: socialAttrs.twitter_usuario || attributes.twitter_usuario,
                tiktok_usuario: socialAttrs.tiktok_usuario || attributes.tiktok_usuario
            });

            attributes.tab = this.parameters.tab;
            this.$el.html( this.template(attributes) );

            //Initialize reference to elements
            this.$calendarUser = this.$('#calendar-user');
            this.$calendarMentor = this.$('#calendar-mentor');
            this.$buttonsConnect = this.$('#buttons-connect-user');
            this.$wrapperUserNetwork = this.$('#contacts-users-friendship');
            this.$wrapperPendingFriendship = this.$('#pending-users-confirm');
            this.$wrapperUserMessage = this.$('#user-messages');
            this.$wrapperProduct = this.$('#user-product');
            this.$wrapperProgram = this.$('#user-program');
            this.$wrapperPermissionNotify = this.$('#stage-permission-notification');
            this.$tabProductUser = this.$('.get-product-user');
            this.$tabProgramUser = this.$('.get-program-user');

            // overwrite model id attribute
            if( this.model.changed.codigo_usuario !== undefined ) {
                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_usuario';
                this.model.set({'codigo_usuario': this.model.get('codigo_usuario')},{'silent':true});

                // Set update URL
                this.socialModel = this.model.clone();
                this.stopListening( this.socialModel, 'change');
                this.listenTo( this.socialModel, 'change', this.render );
                this.socialModel.url = function () {
                    return window.Misc.urlFull( Route.route('usuario.socialnetworks', {usuario: _this.model.get('codigo_usuario')}) );
                };
            }
            // Instance views tabs content
            this.referenceToViews();
            this.renderMainImage();

            // render template permission notification
            this.$wrapperPermissionNotify.html( this.templateDeskNotify({permissionLevel : this.notifyPermissionLevel}) );
        },

        /**
        * render main image
        */
        renderMainImage: function (model, value, opts) {

            this.$imgCropUser.html( this.templateMainImg( this.model.toJSON()) );
            this.ready();
        },

        /**
        * reference to instande views
        */
        referenceToViews: function () {

            var _this = this;

            // Instance user sections
            if( this.model.attributes.codigo_usuario != false && this.model.attributes.codigo_usuario !== undefined && this.model.hasChanged('codigo_usuario') ) {
                if(window.Misc.checkSession(false)) {
                    // ---------------------------
                    // Instance user section views
                    // ---------------------------
                    // projects list
                    if ( this.projectListView instanceof Backbone.View ){
                        this.projectListView.stopListening();
                        this.projectListView.undelegateEvents();
                    }

                    this.projectListView = new app.UserProjectListView( {
                        collection: this.projectList,
                        attributes:{
                            viewShow: 'user',
                            'srcparams-user': this.model.get('srcparams')
                        }
                    });

                    // user wall
                    // this.wallPostCreate = new app.PostCreateView({
                    //     el: this.el,
                    //     collection: this.wallPostList,
                    //     events: {
                    //         'submit #form-post-wall-user': 'onStore'
                    //     },
                    //     attributes: {
                    //         'srcparams-user': this.model.get('srcparams'),
                    //         'formCreate': '#form-post-wall-user'
                    //     }
                    // });
                    // window.app.AppRouter.previewPost.trigger('reassign');
                    // // user wall post list
                    // this.wallPostListView = new app.UserWallPostListView({
                    //     collection: this.wallPostList,
                    //     attributes: {
                    //         'srcparams-user': this.model.get('srcparams')
                    //     }
                    // });
                    // this.wallPostListView['wallPostCreate'] = this.wallPostCreate;

                    // user calendar
                    this.calendar = new app.UserCalendarView();
                    this.calendar.codigo_usuario = this.model.get('codigo_usuario');



                    // instance of user Network view
                    this.userNetworkListView = new app.UserNetworkListView({
                        el: this.$wrapperUserNetwork,
                        collection: this.userNetworkList,
                        parameters: {
                            'userprofile': this.model.get('codigo_usuario')
                        }
                    });

                    if( this.model.get('owner') ) {
                        this.$wrapperPendingFriendship.css('display', 'none');

                        // instance of Pending Friendship view
                        this.pendingFriendshipListView = new app.PendingFriendshipListView({
                            el: this.$wrapperPendingFriendship,
                            collection: this.pendingFriendshipList,
                            parameters: {
                                'userprofile': this.model.get('codigo_usuario')
                            }
                        });
                    }

                    if(this.$tabProductUser.length){
                        if ( this.userProductListView instanceof Backbone.View ){
                            this.userProductListView.stopListening();
                            this.userProductListView.undelegateEvents();
                        }

                        this.userProductListView = new app.UserProductListView( {
                            el: this.$wrapperProduct,
                            collection: this.marketPlaceList,
                            parameters: {
                                dataFilter: {
                                    type: 'user',
                                    'srcparams-user': this.model.get('codigo_usuario')
                                }
                            }
                        });
                    }

                    if ( this.userProgramListView instanceof Backbone.View ){
                        this.userProgramListView.stopListening();
                        this.userProgramListView.undelegateEvents();
                    }

                    this.userProgramListView = new app.UserProgramListView( {
                        el: this.$wrapperProgram,
                        collection: this.callList,
                        parameters: {
                            dataFilter: {
                                type: 'user',
                                'srcparams-user': this.model.get('codigo_usuario')
                            }
                        }
                    });


                    // teams list
                    // this.teamListView = new app.UserTeamListView({
                    //     collection:this.teamList,
                    //     attributes: {
                    //         'srcparams-user': this.model.get('srcparams')
                    //     }
                    // });
                    // surveys list
                    // this.surveyListView = new app.UserSurveyListView({
                    //     collection:this.surveysList,
                    //     attributes: {
                    //         'srcparams-user': this.model.get('srcparams')
                    //     }
                    // });
                }
            }

            if(window.Misc.checkSession(false)) {

                // if id attribute has changed
                if( this.model.hasChanged('id') ){
                     // Instance edit profile view
                    this.editProfile = new app.UserEditProfile({
                        model: this.model,
                        parameters: {
                            'reasonsList': this.reasonList,
                            'educationList': this.educationList,
                            'specialitiesList': this.specialitiesList,
                            'interestsList': this.interestsList,
                            'socialModel': this.socialModel,
                            'user': this.model.get('codigo_usuario')
                        }
                    });

                    // Only show if not owner profile
                    if( !this.model.get('owner') ) {

                        this.userNetworkModel.set({'seg_codigo_usuario': this.model.get('srcparams'), 'state_friendship' : this.model.get('state_friendship'), 'owner': true });
                        this.buttonsFriendly = new app.UserButtonsFriendlyView({
                            el: this.$buttonsConnect,
                            model: this.userNetworkModel,
                            parameters: {
                                'type_action': '',
                                'userprofile': this.model.get('codigo_usuario')
                            }
                        });
                    }
                }

                if( this.editProfile )
                    this.editProfile.render();

                // to check profile tabs
                if( this.parameters.tab.length ){
                    this.stuffTab( this.parameters.tab );
                }

                // Education
                this.educationList.fetch({
                    data: {codigo_persona: this.model.get('codigo_persona')},
                    reset: true
                });

                // Reason
                this.reasonList.fetch({
                    data: {codigo_usuario: this.model.get('codigo_usuario')},
                    reset: true
                });

                // Specialities
                this.specialitiesList.fetch({
                    data: {codigo_usuario: this.model.get('codigo_usuario')},
                    reset: true
                });

                // Interests
                this.interestsList.fetch({
                    data: {codigo_usuario: this.model.get('codigo_usuario')},
                    reset: true
                });
            }
        },

        stuffTab: function ( tab ) {

            var _this = this,
                stuffTab = {
                    // 'comunidad' : function() {
                    //     _this.onGetWall();
                    // },
                    'basico' : function() {
                        _this.onGetDataBasic();
                    },
                    'proyectos' : function() {
                        _this.onGetProjects();
                    },
                    'grupos' : function() {
                        _this.onGetTeams();
                    },
                    // 'encuestas' : function() {
                    //     _this.onGetSurveys();
                    // }
                    'calendario': function(){
                        _this.onGetCalendar();
                    },
                    'preferencias': function(){
                        _this.onGetPreferences();
                    },
                    'contactos': function(){
                        _this.onGetContacts();
                    },
                    'mensajes': function(){
                        _this.onGetMessages();
                    },
                    'productos': function(){
                        _this.onGetProducts();
                    },
                    'convocatorias': function() {
                        _this.onGetPrograms();
                    },
                    'default': function () {
                        _this.onGetDataBasic();
                    }
                };

            if (stuffTab[tab]) {
                stuffTab[tab]();
                this.isDefault = false;

            } else {
                stuffTab['default']();
                this.isDefault = true;
            }
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function() {
            //
        },

        /**
        * Fires before of run render function
        */
        afterRender: function() {
            this.ready();
            this.setImgUploaderCrop();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                $(document).foundation('abide', 'reflow');
                $(document).foundation('tab', 'reflow');
                $(document).foundation('equalizer', 'reflow');
                $(document).foundation('dropdown', 'reflow');
            }

            if( typeof window.initComponent.configSlick == 'function' )
                window.initComponent.configSlick();

            if( typeof window.initComponent.calendarTrigger == 'function' )
                window.initComponent.calendarTrigger();

            if( typeof window.initComponent.configScrollbar == 'function' )
                window.initComponent.configScrollbar();
        },

        /**
        * Event associate with Linkedin
        */
        onAssociateLinkedin: function (e) {
            e.preventDefault();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },

        //---------Event handler for tabs content-------------------
        /**
        * Event to show basic data
        */
        onGetDataBasic: function (e) {
            // if( e !== undefined )
            //     e.preventDefault();

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'basico'}), {trigger: false, replace: true} );
            }

            this.parameters.tab = 'basico';
        },

        /**
        * Event to show user calendar
        */
        onGetCalendar: function (e) {
            this.calendar.render();
            this.ready();

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'calendario'}), {trigger: false, replace: true} );
            }

            this.parameters.tab = 'calendario';
        },



        /**
        * Event to show user Preferences
        */
        onGetPreferences: function (e) {
            if( e !== undefined ){
                e.preventDefault();
                this.switchContent( e.currentTarget );
            }

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'preferencias'}), {trigger: false, replace: true} );
            }


            this.parameters.tab = 'preferencias';
        },

        /**
        * Event to show user contacts
        */
        onGetContacts: function (e) {
            // if( e !== undefined )
            //     e.preventDefault();

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'contactos'}), {trigger: false, replace: true} );
            }

            this.parameters.tab = 'contactos';
        },

        /**
        * Event to show user messages
        */
        onGetMessages: function (e) {
            // if( e !== undefined )
            //     e.preventDefault();

            dataFilter = this.parameters.dataFilter;
            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'mensajes'}), {trigger: false, replace: true} );
            }

            this.parameters.tab = 'mensajes';
        },

        /**
        * Event to show user projects
        */
        onGetProjects: function (e) {

            // if( e !== undefined )
                // e.preventDefault();

            var data = {'srcparams-user': this.model.get('srcparams')};

            data.type = 'user';
            this.projectListView.attributes.data = data;

            // Render project list view
            this.projectListView.render();

            // Fetch data
            this.projectListView.trigger('getData',data);

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'proyectos'}), {trigger: false, replace: true} );
            }

            this.parameters.tab = 'proyectos';
        },

        /**
        * Event to show user teams
        */
        onGetTeams: function (e) {
            // if( e !== undefined )
            //     e.preventDefault();


            // Render project list view
            this.teamListView.render();

            // Fetch data
            this.teamList.getFirstPage( {reset: true, data:{'srcparams-user':this.model.get('srcparams')}} );

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'grupos'}), {trigger: false, replace: true} );
            }

            this.parameters.tab = 'grupos';
        },

        /**
        * Event to show user product
        */
        onGetProducts: function (e) {

            if(this.$tabProductUser.length){
                // Render product list view
                this.userProductListView.render();
                this.userProductListView.trigger('getdata');

                // set route
                if(!this.isDefault){
                    app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'productos'}), {trigger: false, replace: true} );
                }

                this.parameters.tab = 'productos';
            }
        },

        onGetPrograms: function(e) {
            var data = {'codigo_usuario': this.model.get('codigo_usuario')};
            data.type = 'user';

            // Render product list view
            this.userProgramListView.render();
            this.userProgramListView.trigger('getdata', data);

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'convocatorias'}), {trigger: false, replace: true} );
            }

            this.parameters.tab = 'convocatorias';
        },

        /**
        * Event to show user surveys
        */
        // onGetSurveys: function (e) {
        //     if( e !== undefined )
        //         e.preventDefault();

        //     // Render project list view
        //     this.surveyListView.render();

        //     // Fetch data
        //     this.surveysList.getFirstPage( {reset: true, data:{'srcparams-user':this.model.get('srcparams')}} );

        //     // set route
        //     app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'encuestas'}), {trigger: false, replace: true} );

        //     this.parameters.tab = 'encuestas';
        // },

        /**
        * Event to show user wall
        */
        // onGetWall: function (e) {
        //     // if( e !== undefined )
        //     //     e.preventDefault();

        //     this.wallPostListView.trigger('getdata');

        //     // set route
        //     if(!this.isDefault){
        //         app.AppRouter.navigate( Route.route('usuario.nickname.tab', {nickname: this.model.get('nickname_usuario'), tab: 'comunidad'}), {trigger: false, replace: true} );
        //     }

        //     this.parameters.tab = 'comunidad';
        // },

        /**
        * switch content on tabs with another action
        * @param String content
        */
        switchContent: function (link) {

            var $link = this.$(link),
                content = '';

            this.$('#user-tabs-filter').find('> dd, .tab-title').removeClass('active');

            if( /^\#/.test($link.attr('href')) ) {
                content = $link.attr('href');
            }else {
                content = '#'+ $link.attr('aria-controls');
            }

            $(content).addClass('active')
                      .siblings('.content').removeClass('active');
        },
        // ---------End of event handler for tabs content------------------

        // ===============================================================
        //              start of image uploader crop
        // ===============================================================

        /**
        * set image uploader crop
        */
        setImgUploaderCrop: function () {

            var _this = this;

            this.$el.imageUploaderCrop({
                formCrop: $('#form-avatar-crop'),
				imgCrop: $('#image-user-tocrop'),
				previewImg: $('#avatar-preview-tocrop'),
				uploaderImg: $('#uploader-image-avatar'),
				templateImgUploader: 'qq-img-uploader-template',
				configImg: {
					maxWidthImg : 240 * 10,
					maxHeightImg : 240 * 10,
					minWidthImg : 240,
					minHeightImg : 240
				},
                uploadding: {
                    inputName: 'file',
                    endpoint: document.url + Route.route('file.temp'),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                cropping: {
                    endpoint: document.url + Route.route('file.crop'),
                    params: {}
                },
                extraDropzones: [$('#image-crop-avatar')],
                // Events handlers
                callbacks: {
                    onLoadImg: function ($uploaderImg, id, name) {

                        var $areaDrop = $uploaderImg.fineUploader('getDropTarget', id);

                        if( $areaDrop !== undefined && $areaDrop.length ){
                            if( $areaDrop.hasClass('image-area-drop') ){

                                $(document).on('closed.fndtn.reveal', _this.$modalImageCrop, _this.closeModalImg);
                                _this.$modalImageCrop.foundation('reveal', 'open');
                            }
                        }

                        window.Misc.setSpinner( _this.$modalImageCrop.find('.content-modal') );
                    },
                    onCompleteLoad: function ($uploaderImg, id, name, res) {
                        $uploaderImg.find('.qq-uploader').css( {'border': 'none'} );

                        window.Misc.removeSpinner({
                            'wrap': _this.$modalImageCrop,
                            'direct': false
                        });
                    },
                    onCropping: function (jcrop_img) {
                        window.Misc.setSpinner( _this.$modalImageCrop.find('.content-modal') );
                    },
                    onCropComplete: function (jcrop_img, resp, jqXHR) {
                        // response success or error
                        var confCrop = {},
                            type = resp.success ? 'success' : 'alert',
                            text = resp.success ?
                                (resp.message !== undefined ? resp.message : '')
                                : resp.errors;

                        if( _.isObject( resp.errors ) ){

                            var listError = '<ul>';

                            $.each(resp.errors, function(field, item) {
                                 listError += '<li>'+ item[0] +'</li>';
                            });
                            listError += '</ul>';

                            text = listError;
                        }

                        var conf = {
                            wrapper: _this.$modalImageCrop.find('.content-modal'),
                            text: text,
                            type: type
                        };
                        confCrop = $.extend({}, _this.configAlert, conf);

                        if( resp.success !== undefined ) {
                            if( resp.success ){
                                _this.model.save({'imagen_usuario': resp.file_path}, {patch:true, wait:true});
                                _this.model.set('imagen_usuario', resp.file_path);

                                _this.$modalImageCrop.foundation('reveal', 'close');
                            }else{
                                window.Misc.showAlertBox( confCrop );
                            }
                        }

                        window.Misc.removeSpinner({
                            'wrap': _this.$modalImageCrop,
                            'direct': false
                        });
                    },
                    onCropError: function (jcrop_img, jqXHR, error) {
                        var confCrop = {},
                            conf = {
                                wrapper: _this.$modalImageCrop.find('.content-modal'),
                                text: 'La imagen no puede ser ajustada.',
                                type: 'alert',
                                close: true
                            };

                        confCrop = $.extend({}, _this.configAlert, conf);

                        window.Misc.removeSpinner({
                            'wrap': _this.$modalImageCrop,
                            'direct': false
                        });
                        window.Misc.showAlertBox( confCrop );
                    }
                },
                messages: window._tp.messages
            });
        },

        /**
        * change project image main
        */
        onChangeImage: function (e) {

            if( e !== undefined )
                e.preventDefault();

            this.$modalImageCrop.on('opened', this.openModalImg);
            $(document).on('closed.fndtn.reveal', this.$modalImageCrop, this.closeModalImg);

            this.$modalImageCrop.foundation('reveal', 'open');
        },

        /**
        * handler event with avatar modal is opened
        */
        openModalImg: function (e) {

            var _this = this;

            if( this.$el.data('imageUploaderCrop') !== undefined )
                this.$el.imageUploaderCrop('changeImage', this.model.get('imagen_usuario'));
        },

        /**
        * handler event on crop modal is closed
        */
        closeModalImg: function (e) {

            if(e.namespace != 'fndtn.reveal') return;

            var $imgCrop = this.$el.imageUploaderCrop('getImgCrop'),
                jcrop_img = null;

            // check out if already was assigned the jcrop library
            if( $imgCrop.data('Jcrop') !== undefined ){
                jcrop_img = $imgCrop.data('Jcrop');
                jcrop_img.destroy();
            }

            // detach events
            this.$modalImageCrop.off('opened');
            $(document).off('closed.fndtn.reveal');
        },

        /**
		* request permission for desktop notification
        */
        onPermissionNotify: function (e) {
        	e.preventDefault();

        	var _this = this;

        	if( this.notifyPermissionLevel !== 'granted' ) {

        		// render template permission notification
            	this.$wrapperPermissionNotify.html( this.templateDeskNotify({permissionLevel : 'waiting'}) );

				Notification.requestPermission(function (permission) {
					_this.$wrapperPermissionNotify.html( _this.templateDeskNotify({permissionLevel : permission}) );
				});
			}
        }
   });

})(jQuery, this, this.document);

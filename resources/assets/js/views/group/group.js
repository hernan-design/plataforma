/**
* Class GroupView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.GroupView = Backbone.View.extend({

        el: '#group-content',
        template: _.template( ($('#group-detail-tpl').html() || '') ),
        templateMainImg: _.template( ($('#main-image-group-tpl').html() || '') ),
        templateTopDetail: _.template( ($('#info-basic-group-tpl').html() || '') ),
        templateLocation: _.template( ($('#info-location-group-tpl').html() || '') ),
        templateTag: _.template( ($('#info-tag-group-tpl').html() || '') ),
        templateVideo: _.template( ($('#info-video-group-tpl').html() || '') ),
        templateSummary: _.template( ($('#info-summary-group-tpl').html() || '') ),
        templateDescription: _.template( ($('#info-description-group-tpl').html() || '') ),
        templateSocials: _.template( ($('#info-socials-group-tpl').html() || '') ),
        events: {
            'click .program-shared-list .show-user-likes': 'onShowUserLikes',
            'click .get-basic-group': 'onGetBasic',
            'click .get-members-group': 'onGetMembers',
            'click .get-discussion-group': 'onGetDiscussion',
            'click #change-image-group': 'onChangeImage'
        },
        parameters: {
            tab: 'basico'
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

            //Init Attribute
            this.$modalImageCrop = $('#modal-image-group');
            this.likeList = new app.LikeList();
            this.discussionList = new app.DiscussionList();
            this.interestsList = new app.UserInterestsList();
            this.projectTeamList = new app.ProjectTeamList();
            this.groupClusterList = new app.GroupClusterList();

            this.$modalBase = $('#modal-base-tp');

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo( this.model, 'change:id_entidad' , this.render );
            this.listenTo( this.model, 'change:imagen_usuario', this.renderMainImage );
            this.listenTo( this.model, 'change:nombre_usuario', this.renderInfoBasic );
            this.listenTo( this.model, 'change:codigo_ciudad change:codigo_categoria_proyecto', this.renderInfoLocation );
            this.listenTo( this.model, 'change:tags', this.renderInfoTag );
            this.listenTo( this.model, 'change:video_entidad', this.renderInfovideo );
            this.listenTo( this.model, 'change:descripcion_entidad', this.renderInfoDescription );
            this.listenTo( this.model, 'change:biografia_usuario', this.renderInfoSummary );
            this.listenTo( this.model, 'change:facebook_usuario change:twitter_usuario change:linkedin_usuario change:tiktok_usuario', this.renderInfoSocials );
            // this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
            $( window ).off("scroll");
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            attributes.tab = this.parameters.tab;
            this.$el.html( this.template(attributes) );

            // Initialize attributes
            this.$likeLink = this.$('.data-post-share.TPlikelink');
            this.$countLikes = this.$('.data-count-likes');
            this.$buttonsActions = this.$('#buttons-group-privacy-action');
            this.$buttonsJoinActions = this.$('#buttons-group-join-action');
            this.$wrapperTeamGroup = this.$('#group-members');


            // overwrite model id attribute
            if( this.model.changed.id_entidad !== undefined ) {

                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_entidad';
                this.model.set( {'codigo_entidad': this.model.get('codigo_entidad')}, {'silent':true} );

                // reference to views
                this.renderMainImage();
                this.referenceViews();
                this.renderInfoBasic();
                this.renderInfovideo();
                this.renderInfoSocials();
                this.renderInfoLocation();
                this.renderInfoTag();
                this.renderInfoDescription();
                this.renderInfoSummary();
            }
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            //
        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {

            // call image uploader crop
            this.setImgUploaderCrop();

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {

            var _this = this;

            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }

            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('tab', 'reflow');
            }

            // reload plugins
            if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'spinner') ){
                window.initComponent.spinnerTrigger();
            }

        },

        /**
        * reference to views
        */
        referenceViews: function () {



        // switch(this.model.get('orientacion_clase_espacio')) {
        //         case window._tp.getOrientationSpace['user']:

        //             this.groupProjectModel = new app.GroupProjectModel();
        //             this.groupProjectModel.set({'codigo_proyecto': this.model.get('codigo_proyecto'), 'statejoin' : this.model.get('statejoin') });

        //             // Instance of Buttons Actions Join Group
        //             this.buttonsJoinGroup = new app.GroupButtonActionsView({
        //                 el: this.$buttonsJoinActions,
        //                 model: this.groupProjectModel,
        //                 parameters: {
        //                     'codigo_proyecto': this.model.get('codigo_proyecto'),
        //                     'owner': this.model.get('owner'),
        //                     'statejoin': this.model.get('statejoin'),
        //                     'url_proyecto': this.model.get('url_proyecto'),
        //                     'orientacion_clase_espacio': this.model.get('orientacion_clase_espacio'),
        //                     'nombre_categoria_clase_espacio':  this.model.get('nombre_categoria_clase_espacio'),
        //                     'wrapperTeamGroup': this.$wrapperTeamGroup,
        //                     'collectiongroup': this.projectTeamList
        //                 }
        //             });
        //             break;
        //         case window._tp.getOrientationSpace['project']:

        //             this.groupClusterModel = new app.GroupClusterModel();
        //             this.groupClusterModel.set({'codigo_proyecto': this.model.get('codigo_proyecto'), 'statejoin' : this.model.get('statejoin') });

        //             // Instance of Buttons Actions Join Group
        //             this.buttonsJoinGroup = new app.GroupButtonActionsView({
        //                 el: this.$buttonsJoinActions,
        //                 model: this.groupClusterModel,
        //                 parameters: {
        //                     'codigo_proyecto': this.model.get('codigo_proyecto'),
        //                     'owner': this.model.get('owner'),
        //                     'statejoin': this.model.get('statejoin'),
        //                     'url_proyecto': this.model.get('url_proyecto'),
        //                     'orientacion_clase_espacio': this.model.get('orientacion_clase_espacio'),
        //                     'nombre_categoria_clase_espacio':  this.model.get('nombre_categoria_clase_espacio'),
        //                     'wrapperTeamGroup': this.$wrapperTeamGroup,
        //                     'collectiongroup': this.groupClusterList
        //                 }
        //             });
        //             break;
        //         default:
        //             // default
        //     }




            this.projecTeamtModel = new app.ProjectTeamModel();
            this.projecTeamtModel.set({'codigo_usuario': this.model.get('codigo_usuario'), 'statejoin' : this.model.get('statejoin') });

            // Instance of Buttons Actions Join Group
            this.buttonsJoinGroup = new app.GroupButtonActionsView({
                el: this.$buttonsJoinActions,
                model: this.projecTeamtModel,
                parameters: {
                    'codigo_usuario': this.model.get('codigo_usuario'),
                    'owner': this.model.get('owner'),
                    'statejoin': this.model.get('statejoin'),
                    'url_nickname': this.model.get('url_nickname'),
                    'nombre_categoria_clase_espacio':  this.model.get('nombre_categoria_clase_espacio'),
                    'wrapperTeamGroup': this.$wrapperTeamGroup,
                    'collectiongroup': this.projectTeamList
                }
            });

            // Instance edit project view
            this.editGroup = new app.EditGroup({
                el: this.$el,
                model: this.model,
                parameters: {
                    'interests': this.interestsList,
                    'user': this.model.get('codigo_usuario')
                }
            });

            if( this.editGroup )
                this.editGroup.render();

            // Instance of Buttons Actions Group
            this.buttonsPrivacyProject = new app.ProjectPrivacyActionsView({
                el: this.$buttonsActions,
                model: this.model,
                parameters: {
                    'model': ''
                }
            });

            this.userDiscussionListView = new app.DiscussionListView( {
                collection: this.discussionList,
                    parameters: {
                        'formDiscussion': '#form-discussion-project',
                        dataFilter: {
                            'codigo_recurso_modulo': this.model.get('codigo_usuario'),
                            'codigo_modulo': window._tp.getModule('users')
                        }
                    }
             } );

            // Interests
            this.interestsList.fetch({
                data: {codigo_usuario: this.model.get('codigo_usuario')},
                reset: true
            });

            this.groupTeamListView = new app.GroupTeamListView( {
                    el: this.$wrapperTeamGroup,
                    collection: this.projectTeamList,
                    parameters: {
                        dataFilter: {
                            type: 'project',
                            'codigo_usuario': this.model.get('codigo_usuario')
                        }
                   }
            } );


            // to check project tabs
            if( this.parameters.tab.length ){
                this.stuffTab( this.parameters.tab );
            }


            // likes
            this.likeLinkView = new window.app.LikeView({
                el: this.$likeLink,
                collection: this.likeList,
                attributes: {
                    'data-srcparams': this.model.get('srcparams')
                }
            });

            this.likeLinkView.$countLikes = this.$countLikes;

        },

        stuffTab: function ( tab ) {
            var _this = this,
                stuffTab = {
                    'basico' : function() {
                        _this.onGetBasic();
                    },
                    'integrantes' : function() {
                        _this.onGetMembers();
                    },
                    'discusiones' : function() {
                        _this.onGetDiscussion();
                    },
                    'default': function () {
                        _this.onGetBasic();
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

        onGetBasic: function (e) {

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('grupo.grupo.tab', {grupo: this.model.get('url_nickname'), tab: 'basico'}), {trigger: false} );
            }

            this.parameters.tab = 'basico';
        },

        onGetMembers: function (e) {

            this.groupTeamListView.render();
            this.projectTeamList.trigger('getdata');

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('grupo.grupo.tab', {grupo: this.model.get('url_nickname'), tab: 'integrantes'}), {trigger: false} );
            }

            this.parameters.tab = 'integrantes';
        },

        onGetDiscussion: function (e) {

            // Render discussion group list view
            this.userDiscussionListView.render();
            this.userDiscussionListView.trigger('getdata');

            // set route
            if(!this.isDefault){
                app.AppRouter.navigate( Route.route('grupo.grupo.tab', {grupo: this.model.get('url_nickname'), tab: 'discusiones'}), {trigger: false} );
            }

            this.parameters.tab = 'discusiones';
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
             window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        },

        /**
        * show user likes
        */
        onShowUserLikes: function (e) {
            e.preventDefault();

            // to render view user likes
            this.viewUserLikes = new window.app.UserLikesListView({
                attributes: {
                    'data-srcparams': this.model.get('srcparams')
                }
            });
            this.$modalBase.find('.content-modal').html( this.viewUserLikes.render().el );
            this.$modalBase.find('.content-modal').append( this.viewUserLikes.$wrapViewMore );

            this.$modalBase.foundation('reveal','open');
        },

        /**
        * render main image
        */
        renderMainImage: function (model, value, opts) {

            this.$('#group-main-image').html( this.templateMainImg( this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info basic
        */
        renderInfoBasic: function (model, value, opts) {
            this.$('#group-name-container').html( this.templateTopDetail(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info Location
        */
        renderInfoLocation: function (model, value, opts) {

            this.$('#group-location-container').html( this.templateLocation(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info tag
        */
        renderInfoTag: function (model, value, opts) {

            this.$('#group-tag-container').html( this.templateTag(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info video
        */
        renderInfovideo: function (model, value, opts) {

            this.$('#group-video-container').html( this.templateVideo(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info description
        */
        renderInfoDescription: function (model, value, opts) {

            this.$('#group-description-container').html( this.templateDescription(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info summary
        */
        renderInfoSummary: function (model, value, opts) {

            this.$('#group-summary-container').html( this.templateSummary(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info socials
        */
        renderInfoSocials: function (model, value, opts) {

            this.$('#group-socials-container').html( this.templateSocials(this.model.toJSON()) );
            this.ready();
        },

        // ===============================================================
        //              begine of image uploader crop
        // ===============================================================

        /**
        * set image uploader crop
        */
        setImgUploaderCrop: function () {

            var _this = this;

            this.$el.imageUploaderCrop({
                formCrop: $('#form-group-crop'),
                imgCrop: $('#image-group-tocrop'),
                previewImg: $('#group-preview-tocrop'),
                uploaderImg: $('#uploader-image-group'),
                templateImgUploader: 'qq-img-uploader-template',
                configImg: {
                    maxWidthImg : 770 * 4,
                    maxHeightImg : 460 * 4,
                    minWidthImg : 770,
                    minHeightImg : 460
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
                extraDropzones: [/*this.$('#project-main-image'),*/ $('#image-crop-group')],
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

                                _this.model.save({'imagen_usuario': resp.file_path}, {
                                    patch: true,
                                    wait: true,
                                    success: function (model, resp, opts) {
                                        // body...
                                    }
                                });

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
        }
   });

})(jQuery, this, this.document);

/**
* Class MentoringCreateMentorView extends of Backbone View
* @author TuProyecto || Desarrolladores: @xindykatalina, @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringCreateMentorView = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#profile-mentor-tpl').html() || '') ),
        templateMainImg: _.template( ($('#main-image-profile-mentor-tpl').html() || '') ),
        events: {
        	'submit #form-mentor-profile': 'onStore',
            'change .etapa_proyecto':'onChangeField'
        },
        parameters: {
           //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

            this.economicsList = new app.PersonEconomicSectorList();
            this.specialitiesList = new app.UserSpecialitiesList();

            this.mentorModel = new app.MentorModel();

            // extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                _.extend(this.parameters, opts.parameters);
            this.parameters['stage_mentoring'] = [];    
            //Init Attribute
            this.$modalImageCrop = $('#modal-image-mentor-profile');

            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 6000,
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
            this.listenTo( this.model, 'change:codigo_usuario' , this.render );
            this.listenTo( this.model, 'change:imagen_usuario', this.renderMainImage );

            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.mentorModel, 'sync', this.responseServer );

            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();

            console.log('MentoringCreateMentorView', attributes);
            this.$el.html( this.template(attributes) );
         
            // Initialize attributes
            this.$wrapperDocuments = this.$('#wrap-documents');

            // overwrite model id attribute
            if( this.model.changed.codigo_usuario !== undefined ) {
                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_usuario';
                this.model.set({'codigo_usuario': this.model.get('codigo_usuario')},{'silent':true});

                // reference to views
                this.referenceViews();
                this.renderMainImage();
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
            }

            // reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

        },

        /**
        * reference to views
        */
        referenceViews: function () {

            this.economiccontainer = this.$('#mentor-economic-sector-container');

            this.personEconomicSectorList = new app.EditPersonEconomicSectorList( {
                el: this.economiccontainer,
                model: this.model,
                collection: this.economicsList,
                parameters: {
                    'economicsectors': this.economicsList,
                    'codigo_persona': this.model.get('codigo_persona'),
                    'owner': true
                }
            } );
            this.personEconomicSectorList.render();

            // EconomicSector
            this.economicsList.fetch({
                data: {codigo_persona: this.model.get('codigo_persona')},
                reset: true
            });

            this.specialitiescontainer = this.$('#mentor-specialities-container');


            if ( this.mentorEditSpecialities instanceof Backbone.View ){
                this.mentorEditSpecialities.stopListening();
                this.mentorEditSpecialities.undelegateEvents();

            }

            this.mentorEditSpecialities = new app.MentorEditSpecialities( {
                el: this.specialitiescontainer,
                model: this.model,
                collection: this.specialitiesList,
                parameters: {
                    'interests': this.specialitiesList,
                    'codigo_usuario': this.model.get('codigo_usuario'),
                    'owner': true
                }
            } );

            this.mentorEditSpecialities.render();

            // Specialities
            this.specialitiesList.fetch({
                data: {codigo_usuario: this.model.get('codigo_usuario')},
                reset: true
            });

            // Instance of Documents of Advice
            this.mentorAttachments = new app.MentorAttachments({
                el: this.$wrapperDocuments,
                model: this.model,
                parameters: {
                    //
                }
            });

            this.mentorAttachments.render();

            this.ready();

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

            // response success or error
            var text = resp.success ? resp.message : resp.errors,
                type = resp.success ? 'success' : 'alert';

            if( _.isObject( resp.errors ) ){

                var listError = '<ul>';

                $.each(resp.errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }

            var config = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, config );

            //complete proccess
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if(re.success != undefined) {
                            if( re.success ){
                                // Redirect to Content Questions Mentoring
                                url = document.url + Route.route('mentoria.mentores.show', {'mentores': _this.model.get('nickname_usuario')});
                                window.Misc.showAlertBox( conf );

                                setTimeout(function(){
                                    return window.Misc.redirect(url);
                                }, 10000);
                            }else{
                                window.Misc.showAlertBox( conf );
                            }
                        }
                    }
                })(this.configAlert, resp, this)
            });
        },

        /**
        * render main image
        */
        renderMainImage: function (model, value, opts) {

            this.$('#mentor-profile-main-image').html( this.templateMainImg( this.model.toJSON()) );
            this.ready();
        },


        // ===============================================================
        //              start of image uploader crop
        // ===============================================================

        /**
        * set image uploader crop
        */
        setImgUploaderCrop: function () {

            var _this = this;

            this.$el.imageUploaderCrop({
                formCrop: $('#form-mentor-profile-crop'),
                imgCrop: $('#image-mentor-profile-tocrop'),
                previewImg: $('#mentor-profile-preview-tocrop'),
                uploaderImg: $('#uploader-image-mentor-profile'),
                templateImgUploader: 'qq-img-uploader-template',
                configImg: {
                    maxWidthImg : 240 * 5,
	                maxHeightImg : 240 * 5,
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
                extraDropzones: [/*this.$('#project-main-image'),*/ $('#image-crop-mentor-profile')],
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
        * change  fields
        */
       onChangeField: function(e) {
            e.preventDefault();        

            if( e.target.type === 'checkbox' && typeof e.target.value !== 'undefined' && !isNaN(parseInt(e.target.value))){
                this.parameters['changedLevelAttributes'] = true;
                this.parameters['stage_mentoring'].push(parseInt(e.target.value));
            }

            return;
        },

        onStore: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            var terms =  $("#aceptacion_terminos").is(":checked"); 
            data['stage_mentoring'] = this.parameters['stage_mentoring'];
            data['aceptacion_terminos'] = terms;
            console.log('onStoreData',data);
            this.mentorModel.save( data, {patch: true, wait: true} );
        }
   });

})(jQuery, this, this.document);

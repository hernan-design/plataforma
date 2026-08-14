/**
* Class ProjectEditDocuments extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EvaluationItemDocument = Backbone.View.extend({
        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#edit-evaluation-documents-form-tpl').html() || '') ),
        events: {
           'submit #form-edit-project-documents': 'onUploadFiles'
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onReadyFile', 'onPrepareUpload', 'onCompleteLoadFile', 'onCompleteFetchFiles');

            if ( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({},this.parameters, opts.parameters);
            };

            // Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
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
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$el.html( this.template() );

            // Initialize references
            this.$formEdit = this.$('#form-edit-project-documents');
            this.$uploaderFile = this.$('#fnuploader-attach-file');

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            //trigger functions
            this.renderUploaderFile();

            this.ready();
        },

        /**
		* execute with already
        */
        ready: function () {

        	// trigger functions
            if( _.has($.fn, 'foundation') ){
				$(document).foundation('abide', 'reflow');
            }

        	// reload plugins
            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( _.has($.fn, 'perfectScrollbar') && typeof window.initComponent.configScrollbar == 'function' )
            	window.initComponent.configScrollbar();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();
        },

        /*
        * Remove View Element
        */
        remove: function(){

            var _this = this;
            this.$el.fadeOut('normal', function (){
                _this.$el.remove();
            });
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
        responseServer: function ( model, resp, opts ) {
            // response success or error
            var text = resp.success ? '' : resp.errors,
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
                'callback': (function (conf, re) {
                    return function () {
                        if(!_.isUndefined(re.success)) {
                            if( !re.success ){
                                window.Misc.showAlertBox( conf );
                            }
                        }
                    }
                })(this.configAlert, resp)
            });
        },

        /**
        * render files uploader
        */
        renderUploaderFile: function () {
            var _this = this;
            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-attachments-evaluation-template',
                session: {
                    endpoint: window.Misc.urlFull(Route.route('adjunto.evaluacion.index')),
                    params: {
                        'codigo_item': _this.parameters.codigo_item_evaluacion,
                    },
                    refreshOnRequest: false
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull(Route.route('adjunto.evaluacion.index')),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_item': _this.parameters.codigo_item_evaluacion
                    }
                },
                deleteFile: {
                    enabled: true,
                    endpoint: window.Misc.urlFull(Route.route('adjunto.evaluacion.index')),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_usuario': _this.model.get('codigo_usuario')
                    },
                    forceConfirm: true,
                    confirmMessage: window._tp.confirmMessage
                },
                // form: {
                //     element: 'form-edit-project-documents',
                //     interceptSubmit: false
                // },
                thumbnails: {
                    placeholders: {
                        waitingPath: window.Misc.urlFull('img/waiting-generic.png'),
                        notAvailablePath: window.Misc.urlFull('img/not_available-generic.png')
                    }
                },
                autoUpload: true,
                multiple: false,
                validation: {
                    allowedExtensions: ['pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx'],
                    itemLimit: 0,
                    sizeLimit: (100 * 1024) * 1024 // 50 kB = 50 * 1024 bytes
                },
                // Events handlers
                callbacks: {
                    onSubmitted: _this.onReadyFile,
					onUpload: _this.onPrepareUpload,
                    onComplete: _this.onCompleteLoadFile,
                    onSessionRequestComplete: _this.onCompleteFetchFiles
                },
                dragAndDrop: {
                    extraDropzones: []
                },
                text: window._tp.text,
                messages: window._tp.messages,
                showMessage: function (message) {
                    return alertify.alert(message);
                },
                showConfirm: function (message) {
                    var promise = new qq.Promise();
                    alertify.confirm(message, function(result) {
                        if (result) {
                            return promise.success(result);
                        } else {
                            return promise.failure();
                        }
                    });
                    return promise;
                },
                showPrompt: function (message, defaultValue) {
                    var promise = new qq.Promise();

                    alertify.prompt(message, function(result, inStr) {
                        if (result) {
                            return promise.success(inStr);
                        } else {
                            return promise.failure(inStr);
                        }
                    }, defaultValue);
                    return promise;
                }
            });
        },

		/**
		* upload files
		*/
		onUploadFiles: function (e) {
			e.preventDefault();
			this.$uploaderFile.fineUploader('uploadStoredFiles');
		},

        /**
        * when the file is put over loader
        * @param Number id
        * @param String name
        */
        onReadyFile: function (id, name) {

            this.ready();
        },

		/**
		* prepare files params for upload
		*/
		onPrepareUpload: function (id, name) {
			var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);

			var params = {
				'_token': $('meta[name="csrf-token"]').attr('content'),
				'codigo_item': this.parameters.codigo_item_evaluacion,
				'codigo_documento': $itemFile.find('select[name="codigo_documento"]').val(),
				'codigo_privacidad_contenido': $itemFile.find('select[name="codigo_privacidad_contenido"]').val()
			};

			this.$uploaderFile.fineUploader('setParams', params, id);
		},

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {
            // var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            // this.$uploaderFile.fineUploader('setUuid', id, resp.uuid);
            // this.itemWasLoaded($itemFile, resp);

			// Evaluate message success documents
            if( !_.isUndefined(resp.msg) && !_.isNull(resp.msg) ) {
	            var config = {
	                'text': resp.msg,
	                'type': 'success'
	            };
	            _.extend( this.configAlert, config );
	            window.Misc.showAlertBox( this.configAlert );
	        }
        },

        /**
        * on complete fetch files
        * @param Array resp | object array
        * @param Boolean succcess
        */
        onCompleteFetchFiles: function (resp, success) {
            console.log('Response', success);
            var _this = this,
                count = 0;

            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( resp.uuid ) {
                var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', count);
                this.itemWasLoaded($itemFile, resp);
            }
        },

        /**
        *
        */
        itemWasLoaded: function ($itemFile, fileObj) {

            $itemFile.find('.preview-link').attr('href', fileObj.direccion_adjunto);

            if(!this.model.get('owner')){
                $itemFile.find(".qq-upload-delete").css('display', 'none');
            }

			// reload plugins function
	        this.ready();

            $itemFile.find('select').addClass('qq-hide')
					 .next('.select2-container').addClass('qq-hide');

            if( fileObj['codigo_documento'] !== undefined ){
                $itemFile.find('#codigo_documento option[value='+ fileObj.codigo_documento +']')
                         .attr('selected', true);

                $itemFile.find('.label-codigo-documento').text(fileObj.label_documento).removeClass('qq-hide');
            }

            if ( fileObj['codigo_privacidad_contenido'] !== undefined ){
                $itemFile.find('#codigo_privacidad_contenido option[value='+ fileObj['codigo_privacidad_contenido'] +']')
                         .attr('selected', true);

                $itemFile.find('.label-codigo_privacidad').text(fileObj.label_privacidad_contenido).removeClass('qq-hide');
            }
        }
    });

})(jQuery, this, this.document);

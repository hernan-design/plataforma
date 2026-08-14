/**
* Class MentorAttachments extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorAttachments = Backbone.View.extend({
        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#mentor-attachment-form-tpl').html() || '') ),
        events: {
           //
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onReadyFile', 'onCompleteLoadFile', 'onCompleteFetchFiles');

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
            // this.listenTo( this.model, 'change', this.render );
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
            this.$el.html( this.template(attributes) );

            // Initialize references
            this.$formEdit = this.$('#form-mentor-attachment');
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
                this.$el.foundation('abide');
            }

        	// reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

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
				template: 'qq-attachments-mentor-template',
				session: {
					endpoint: window.Misc.urlFull(Route.route('adjunto.usuario.index')),
					params: {
						'codigo_usuario': _this.model.get('codigo_usuario')
					},
					refreshOnRequest: false
				},
				request: {
					inputName: 'file',
					endpoint: window.Misc.urlFull(Route.route('adjunto.usuario.index')),
					customHeaders: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
						'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
					},
					params: {
						'_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_usuario': _this.model.get('codigo_usuario'),
                        'codigo_documento': window._tp.docAttached['curriculum'],
                        'codigo_privacidad_contenido': window._tp.typePrivacy['private']
					}
				},
				deleteFile: {
					enabled: true,
					endpoint: window.Misc.urlFull(Route.route('adjunto.usuario.index')),
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
				//     element: 'form-survey-base',
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
					allowedExtensions: ['pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'pps', 'ppt', 'pptx', 'png', 'jpg', 'jpeg', 'zip'],
					itemLimit: 0,
					stopOnFirstInvalidFile: false,
					sizeLimit: (12 * 1024) * 1024 // 50 kB = 50 * 1024 bytes
				},
				// Events handlers
				callbacks: {
					onSubmitted: _this.onReadyFile,
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
        * when the file is put over loader
        * @param Number id
        * @param String name
        */
        onReadyFile: function (id, name) {

            this.ready();
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {

            var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.uuid);
            this.itemWasLoaded($itemFile, resp);
        },

        /**
        * on complete fetch files
        * @param Array resp | object array
        * @param Boolean succcess
        */
        onCompleteFetchFiles: function (resp, success) {

            var _this = this,
                count = 0;

            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( success ) {
                _.each(resp, function(file) {

                    var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', count);
                    this.itemWasLoaded($itemFile, file);

                    count++;
                }, this);
            }
        },

        /**
        *
        */
        itemWasLoaded: function ($itemFile, fileObj) {
            $itemFile.find('.preview-link').attr('href', fileObj.direccion_adjunto);

            var $fieldFile = this.$('#direccion_adjunto');
            $fieldFile.val( fileObj.direccion_adjunto );

            this.onReadyFile();
        }
    });

})(jQuery, this, this.document);

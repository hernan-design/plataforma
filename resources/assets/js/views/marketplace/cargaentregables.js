/**
* Class CargaEntregables extends of Backbone View
* @author TuProyecto || Desarrollador : @ayn
* @link http://TuProyecto.com
*/



//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {
    //carga entregables, Rutan
    app.CargaEntregables = Backbone.View.extend({
        template: _.template( ($('#edit-upload-documents-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-upload-documents': 'onUploadFiles',
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(
                        this,
                        'beforeRender',
                        'render',
                        'afterRender',
                        'onReadyFile',
                        'onPrepareUpload',
                        'onCompleteLoadFile',
                        'onCompleteFetchFiles',
                        'onDeleteCompleteFile'
                    );

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

            this.codigo_adjunto = null;

            console.log(this.model);

            this.render();
        },

        /*
        * Render View Element
        */
        render: function() {
            this.$el.html( this.template(this.model.toJSON()) );
            // Initialize references
            this.$formEdit = this.$('#form-edit-upload-documents');
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
                template: 'qq-attachments-upload-entregable-template',
                // session: {
                //     endpoint: window.Misc.urlFull(Route.route('marketplace.entregables.compra')),
                //     params: {
                //         'codigo_compra': this.parameters.codigo_compra,
                //         'codigo_tipo_adjunto': 1 //documento
                //     },
                //     refreshOnRequest: false
                // },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull(Route.route('marketplace.entregables.compra.storeAdjuntoEntregables')),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        // 'codigo_usuario': $('#codigo_usuario').val()
                    }
                },
                // deleteFile: {
                //     enabled: true,
                //     endpoint: window.Misc.urlFull(Route.route('marketplace.entregables.compra.deleteEntregables')),
                //     customHeaders: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                //         'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                //     },
                //     params: {
                //         '_token': $('meta[name="csrf-token"]').attr('content'),
                //         'codigo_usuario': $('#codigo_usuario').val(),
                //     },
                //     forceConfirm: true,
                //     confirmMessage: window._tp.confirmMessage
                // },
                // form: {
                //     element: 'form-edit-upload-documents',
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
                    allowedExtensions: ['pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'png', 'jpg'],
                    itemLimit: 0,
                    sizeLimit: (100 * 1024) * 1024 // 50 kB = 50 * 1024 bytes
                },
                // Events handlers
                callbacks: {
                    onSubmitted: _this.onReadyFile,
					onUpload: _this.onPrepareUpload,
                    onComplete: _this.onCompleteLoadFile,
                    onSessionRequestComplete: _this.onCompleteFetchFiles,
                    onDeleteComplete: _this.onDeleteCompleteFile,
                },
                dragAndDrop: {
                    extraDropzones: []
                },
                text: window._tp.text,
                messages: window._tp.messages,
                showMessage: function (message) {
                    //return alertify.alert(message);
                   return window.Misc.showAlertBox({
                        text: message,
                        type: 'alert',
                        closeTime: 3000
                    });
                },
                showConfirm: function (message) {
                    var promise = new qq.Promise();

                  /* alertify.confirm(message, function(result) {

                        if (result) {
                            return promise.success(result);
                        } else {
                            return promise.failure();
                        }
                    });
                    return promise;*/
                    if( this.acceptConfirm instanceof Backbone.View ) {
                        this.acceptConfirm.stopListening();
                        this.acceptConfirm.undelegateEvents();
                    }
                    this.acceptConfirm = new app.ConfirmWindow({
                        //model: this.model,
                        parameters: {
                            template: '<p>' + message +'</p>',
                            titleConfirm: "Confirmación",
                            onConfirm: function (result) {
                                if (result) {
                                    return promise.success(result);
                                } else {
                                    return promise.failure();
                                }
                            }
                        }
                    });

                    this.acceptConfirm.render();

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

            var data = window.Misc.formToJson(e.target);
                data.codigo_adjunto = this.codigo_adjunto;
                data.codigo_compra  = this.parameters.codigo_compra;
                console.log(data);
                _this = this;
            console.log(this.codigo_adjunto);
                this.loadSpinner();

                $.post(document.url + Route.route('marketplace.entregables.compra.storeAdjuntoRutan') , data, function (resp) {

                }).success (function (response, textStatus, jqXHR ) {
                    const text = response.success ? response.message : response.errors;
                    const type = response.success ? 'success' : 'alert';

                    //clean view
                    // _this.codigo_adjunto = null;
                    // _this.render();

                    window.Misc.removeSpinner({
                        'wrap': _this.$el,
                        'direct': true
                    });
                    
                    var config = {
                        'text': text,
                        'type': type
                    };
                    
                    _.extend( _this.configAlert, config );
                    
                    window.Misc.showAlertBox( _this.configAlert );

                    window.location.reload();
                }).error (function ( XMLHttpRequest, textStatus, errorThrown ) {

                    const text = 'Contacte con el administrador';
                    const type = 'alert';

                    var config = {
                        'text': text,
                        'type': type
                    };

                    _.extend( _this.configAlert, config );

                    window.Misc.showAlertBox( _this.configAlert );
                });

			// this.$uploaderFile.fineUploader('uploadStoredFiles');
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
            console.log('onPrepareUpload', $itemFile);
			var params = {
				'_token': $('meta[name="csrf-token"]').attr('content'),
                'codigo_compra': this.parameters.codigo_compra

			};

            window.Misc.showAlertBox({
                text: 'Espera mientras se carga el archivo...',
                type: 'info',
                closeTime: 2000
            });

			this.$uploaderFile.fineUploader('setParams', params, id);
		},

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {
            var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            console.log('onCompleteLoadFile', resp);

            this.codigo_adjunto = resp.codigo_adjunto;

            this.$uploaderFile.fineUploader('setUuid', id, resp.uuid);
            this.itemWasLoaded($itemFile, resp);
			// Evaluate message success documents
            if( !_.isUndefined(resp.msg) && !_.isNull(resp.msg) ) {

                var success = !_.isUndefined(resp.success) ? resp.success : true;
                var text = resp.msg,
                type = success ? 'success' : 'alert';

                var config = {
                    'text': text,
                    'type': type
                };

	            _.extend( this.configAlert, config );
	            window.Misc.showAlertBox( this.configAlert );
	        }
        },

        onDeleteCompleteFile: function (id, xhr, isError) {
            var resp = JSON.parse(xhr.response);

			// Evaluate message success documents
            if( !_.isUndefined(resp.msg) && !_.isNull(resp.msg) ) {

                var success = !_.isUndefined(resp.success) ? resp.success : true;
                var text = resp.msg,
                    type = success ? 'success' : 'alert';

                var config = {
                    'text': text,
                    'type': type
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
            console.log(resp, success); 
            var _this = this,
                count = 0;
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' ){
                window.initComponent.chosenTrigger();
            }

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

            if(!fileObj.owner){
                $itemFile.find(".qq-upload-delete").css('display', 'none');
            }

            // if(fileObj.documento_unico){
            //     $itemFile.find(".qq-upload-delete").css('display', 'none');
            // }

			// reload plugins function
	        this.ready();

            // $itemFile.find('select').addClass('qq-hide')
			// 		.next('.select2-container').addClass('qq-hide');

            // if( fileObj['nombre_entregable'] !== undefined ){//fileObj.nombre_entregable
            //     $itemFile.find('#nombre_entregable')
            //                 .val(fileObj.nombre_entregable);

            //     $itemFile.find('#nombre_entregable').attr('disabled', true);

            // }

            // if( fileObj['observacion'] !== undefined ){
            //     $itemFile.find('#observacion')
            //             .val(fileObj.observacion);

            //     $itemFile.find('#observacion').attr('disabled', true);

            // }

            // if( fileObj['year'] !== undefined ){
            //     $itemFile.find('#year option[value='+ fileObj.year +']')
            //              .attr('selected', true);

            //     $itemFile.find('#year').attr('disabled', true);

                // $itemFile.find('.label-codigo-documento').text(fileObj.label_documento).removeClass('qq-hide');
            // }
        }
    });

})(jQuery, this, this.document);

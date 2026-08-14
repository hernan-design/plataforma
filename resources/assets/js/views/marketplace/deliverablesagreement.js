/**
* Class DelirablesAgreementView extends of Backbone View
* @author TuProyecto : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.DelirablesAgreementView = Backbone.View.extend({

		el: '#marketplace-content',
		template: _.template( ($('#marketplace-deliverables-agreement-tpl').html() || '') ),
		events: {
			'submit #form-create-deliverables-purchase': 'onStore',
            'click #btn-back': 'onBack',
            'click #refuseDeliverables': 'onRefuse',
            'click #send-deliverables': 'onSendDeliverables'
		},
		parameters: {
		   tab: ''
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
			_.bindAll(this, 'onReadyFile', 'onCompleteLoadFile', 'onCompleteFetchFiles', 'onCompleteDelete');

			//Init parameters
			if(!_.isUndefined(opts) && _.isObject(opts.parameters))
				this.parameters = $.extend({},this.parameters, opts.parameters);

			//Init parameters
			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 6000,
				'speedOpen': 500,
				'speedClose': 500
			};

			// Collections
            this.discussionList = new app.DiscussionList();
            this.discussionParticipantsList = new app.DiscussionParticipantsList();

			// Events Listener
			this.listenTo( this.model, 'change:codigo_compra', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
		},

		/*
		* Render View Element
		*/
		render: function() {

			var attributes = this.model.toJSON();
			attributes.tab = this.parameters.tab;

			this.$el.html( this.template(attributes) );
            this.$uploaderFile = this.$('.uploader-attachments');
            this.$uploaderCertificateFile = this.$('.uploader-certificate-attachments');
            this.$wrapperDiscussion = this.$('#wrapper-posts-discussion');
            this.$wrapperParticipants = this.$('#participant-discussion-deliverables');

            // reference to views
            this.discussionListView = new app.DiscussionListView({
                el: this.$wrapperDiscussion,
                collection: this.discussionList,
                parameters: {
                    formDiscussion: '#form-discussion-sale-deliverables',
                    dataFilter: {
                        'codigo_recurso_modulo' : this.model.get('codigo_acuerdo_compra'),
                        'codigo_modulo': window._tp.getModule('agreements')
                    }
                }
            });

            // instance of user participants discussion view
            this.discussionParticipantsListView = new app.DiscussionParticipantsListView({
                el: this.$wrapperParticipants,
                collection: this.discussionParticipantsList,
                parameters: {
                    'sale_agreement': this.model.get('codigo_acuerdo_compra')
                }
            });

			// fires plugins and functions
			this.ready();

			// render uploadaers
			this.renderUploaderFile();
			this.renderUploaderFinalReport();
            this.renderUploaderCertificate();



			return this;
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			// fires fuctions plugin
			if( _.has($.fn, 'foundation') ) {
				$(document).foundation('abide', 'reflow');
				$(document).foundation('dropdown', 'reflow');
				$(document).foundation('tooltip', 'reflow');
			}

			if( typeof window.initComponent.initConfigForm === 'function' )
				window.initComponent.initConfigForm();

             // Instance of Documents para carga de usuarios
			this.cargaEntregables = new app.CargaEntregables({
				el: this.$('#wrap-documents'),
				model: this.model,
				parameters: {
					'codigo_compra': this.model.get('codigo_compra'),
				}
			});
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
		* Event Items Evaluation Purchase
		*/
		onStore: function (e) {
            e.preventDefault();

			var _this = this,
                data  = {
    				'codigo_compra': this.model.get('codigo_compra'),
    				'state_purchase': this.model.get('state_purchase'),
    				'_token': $('meta[name="csrf-token"]').attr('content')
		        };

            if(this.parameters.tab ==='compras'){

               var hasAttachments =  _.every(this.model.get('acuerdos_adjuntos'), function(agreement) { return agreement.direccion_adjunto });

               if(hasAttachments){
                   this.model.save( data, {patch: true, wait:true,
                       success: function (model, resp, opts) {
                           if( ( model.get('purchaser') && !model.get('evaluation_purchase_seller') ) || ( model.get('seller') && !model.get('evaluation_purchase_purchaser') ) ){
                               _this.onEvaluation(e);
                           }else{
                               Backbone.history.navigate(model.get('seller') ? Route.route('marketplace.ventas.index') : Route.route('marketplace.compras.index'), { trigger:true })
                           }
                       }
                   } );
               }else{
                   alertify.alert('Faltan los adjuntos del entregable');
               }
            } else {
               if (this.model.get('codigo_adjunto') && !_.isNull(this.model.get('codigo_adjunto')) && this.model.get('state_agreement') !== window._tp.getState['rejection_of_deliverables']) {
                   this.model.save( data, {patch: true, wait:true,
                       success: function (model, resp, opts) {
                           if( ( model.get('purchaser') && !model.get('evaluation_purchase_seller') ) || ( model.get('seller') && !model.get('evaluation_purchase_purchaser') ) ){
                               _this.onEvaluation(e);
                           }else{
                               Backbone.history.navigate(model.get('seller') ? Route.route('marketplace.ventas.index') : Route.route('marketplace.compras.index'), { trigger:true })
                           }
                       }
                   } );
               } else if (!this.model.get('codigo_adjunto') && _.isNull(this.model.get('codigo_adjunto') )) {
                   alertify.alert('Falta el adjunto de informe final');
               } else {
                    data.rejection_of_deliverables = true;
                    this.model.save(data, {patch: true, wait: true,  success: function(model){
                            Backbone.history.navigate(model.get('seller') ? Route.route('marketplace.ventas.index') : Route.route('marketplace.compras.index'), { trigger:true })
                        }
                    });
               }
            }
		},

		/**
		* Envia estado para entregables, rutan
		*/
		onSendDeliverables: function (e) {
            e.preventDefault();

			var _this = this,
                data  = {
                    'codigo_compra': this.model.get('codigo_compra'),
                    'state_purchase': this.model.get('state_purchase'),
                    '_token': $('meta[name="csrf-token"]').attr('content')
		        };

                console.log(window.Misc.formToJson( e.target));
                console.log(data);
                var _this = this;

                this.acceptSendConfirm = new app.ConfirmWindow({
                    // model: _this.model,
                    parameters: {
                        template: '<p>¿Estas seguro de enviar los entregables? </p>',
                        titleConfirm: "¡Confirmación!",
                        onConfirm: function () {

                            $.ajax({
                                url: window.Misc.urlFull(Route.route('marketplace.entregables.compra.sendDeliverables')),
                                type: 'POST',
                                data: data,
                                // beforeSend: function() {
                                //     _this.$inputName.val('');
                                //     window.Misc.setSpinner( _this.$wraperConten );
                                // }
                            })
                            .success (function (data, textStatus, jqXHR ) {
            
                                const text = data.success ? data.message : data.errors;
                                const type = data.success ? 'success' : 'alert';
            
                                var config = {
                                    'text': text,
                                    'type': type
                                };
            
                                _.extend( _this.configAlert, config );
            
                                window.Misc.showAlertBox( _this.configAlert );
                                window.location.reload();
            
                            })
                            .error (function ( XMLHttpRequest, textStatus, errorThrown ) {
                                const text = 'Contacte con el administrador';
                                const type = 'alert';
            
                                var config = {
                                    'text': text,
                                    'type': type
                                };
            
                                _.extend( _this.configAlert, config );
            
                                window.Misc.showAlertBox( _this.configAlert );
                            });

                        }
                    }
                });

                this.acceptSendConfirm.render();



		},

        onEvaluation: function (e) {
            Backbone.history.navigate(this.model.get('part') == 'seller' ? Route.route('marketplace.evaluacion.purchase', {
                tab: this.parameters.tab, purchase: this.model.get('codigo_compra') } ) : Route.route('marketplace.evaluacion.purchase', {
                    tab: this.parameters.tab, purchase: this.model.get('codigo_compra') } ), { trigger:true })
        },

        onBack: function(e) {
		  e.preventDefault();

		  Backbone.history.navigate(this.model.get('seller') ? Route.route('marketplace.ventas.index') : Route.route('marketplace.compras.index'), { trigger:true })

        },

        onRefuse: function(e) {
            e.preventDefault();

            this.$textAreaCommentsDeliverables = $('#comentario_rechazo_entregables');
            var textAreaComments = this.$textAreaCommentsDeliverables.val();

            this.$textAreaCommentsDeliverables.attr("required", true);
            this.$textAreaCommentsDeliverables.focus();

            if (textAreaComments.trim() !== "") {
                var data  = {
                        'codigo_compra': this.model.get('codigo_compra'),
                        'state_purchase': this.model.get('state_purchase'),
                        'refuse_deliverables': true,
                        'comment_refuse': textAreaComments,
                        'codigo_modulo': window._tp.getModule('agreements')
                    };

               this.model.save(data, {patch: true, success: function() {
                       Backbone.history.navigate(Route.route('marketplace.compras.index'), { trigger:true })
                    }
                });
            } else {
                alertify.alert('Falta el commentario de rechazo de entregables');
            }
        },
		/**
        * render files uploader
        */
        renderUploaderFile: function () {

            var _this = this;

            this.$('.uploader-attachments-deliverables').each(function(index, element) {

                var $element = $(element),
                    dataDeliverable = _this.model.get('acuerdos_adjuntos')[index];

                $element.fineUploader({
                    debug: false,
                    template: 'qq-attachment-uploader-template',
                    request: {
                        inputName: 'file',
                        endpoint: window.Misc.urlFull(Route.route('adjunto.entregable.index')),
                        customHeaders: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                        },
                        params: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'codigo_entregable_acuerdo': dataDeliverable['codigo_entregable_acuerdo'],
                            'codigo_acuerdo_compra': _this.model.get('codigo_acuerdo_compra_decrypt'),
                        }
                    },
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
                        stopOnFirstInvalidFile: false,
                        sizeLimit: (12 * 1024) * 1024 // 50 kB = 50 * 1024 bytes
                    },
                    // Events handlers
                    callbacks: {
                        onSubmitted: _this.onReadyFile,
                        onComplete: function (id, name, resp) {

                            _.extend(dataDeliverable, resp);

                            var $itemFile = $element.fineUploader('getItemByFileId', id);

                            $element.fineUploader('setUuid', id, dataDeliverable.codigo_entregable_acuerdo);
                            $element.find('.qq-attachment-required').val(dataDeliverable.direccion_adjunto);

                            _this.itemWasLoaded($itemFile, resp);
                        },
                        onStatusChange: function (id, oldStatus, newStatus) {

                            if(newStatus == qq.status['UPLOAD_SUCCESSFUL']) {

                                if( _this.parameters.tab == 'compras') {
                                    $element.find('.qq-upload-button-selector').addClass('qq-hide');
                                    $element.find('.qq-download-button')
                                        .removeClass('qq-hide')
                                        .attr('href', dataDeliverable.direccion_adjunto);
                                }

                                $element.find('.qq-attachment-required').val(dataDeliverable.direccion_adjunto);
                                window.setTimeout(function () {
                                    var $itemFile = $element.fineUploader('getItemByFileId', id);
                                    _this.itemWasLoaded( $itemFile, dataDeliverable );
                                }, 500);
                            }
                        }
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

                if( _.isObject(dataDeliverable) && dataDeliverable.nombre_adjunto ) {

                    $element.fineUploader('addInitialFiles', [{
                        name: dataDeliverable.nombre_adjunto,
                        uuid: dataDeliverable.codigo_entregable_acuerdo
                    }]);

                }else if( _this.parameters.tab == 'compras' ) {
                    $element.find('.qq-upload-button-selector').addClass('qq-hide');
                    $element.find('.message-no-attachment').removeClass('qq-hide');
                    $element.find('.qq-attachment-required').removeAttr('required');
                }
            });
        },

        renderUploaderFinalReport: function() {
            var _this = this;
            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-attachments-final-report-template',
                session: {
                    endpoint: window.Misc.urlFull(Route.route('marketplace.ventas.informe.index')),
                    params: {
                        'codigo_compra': _this.model.get('codigo_compra')
                    },
                    refreshOnRequest: false
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull(Route.route('marketplace.ventas.informe.index')),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_compra': _this.model.get('codigo_compra')
                    }
                },
                autoUpload: true,
                multiple: false,
                // Events handlers
                callbacks: {
                    onSubmitted: _this.onReadyFile,
                    onComplete: _this.onCompleteLoadFile,
                    onDeleteComplete: _this.onCompleteDelete,
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

        renderUploaderCertificate: function() {
            var _this = this;
            this.$uploaderCertificateFile.fineUploader({
                debug: false,
                template: 'qq-attachments-final-report-template',
                session: {
                    endpoint: window.Misc.urlFull(Route.route('marketplace.ventas.informe.index')),
                    params: {
                        'codigo_compra': _this.model.get('codigo_compra'),
                        'certificate': true
                    },
                    refreshOnRequest: false
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull(Route.route('marketplace.ventas.informe.index')),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_compra': _this.model.get('codigo_compra'),
                        'certificate': true
                    }
                },
                autoUpload: true,
                multiple: false,
                // Events handlers
                callbacks: {
                    onSubmitted: _this.onReadyFile,
                    onComplete: _this.onCompleteLoadFile,
                    onDeleteComplete: _this.onCompleteDelete,
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

        onCompleteLoadFile: function (id, name, resp) {

            var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.uuid);
            this.model.set({codigo_adjunto: resp.codigo_adjunto});
            this.itemWasLoaded($itemFile, resp);
        },

        onCompleteDelete: function() {
           this.model.set({codigo_adjunto: null});
        },

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
		* call when item was loaded on list
		* @param $itemFile Element
		* @param fileObj Object
        */
        itemWasLoaded: function ($itemFile, fileObj) {
        	$itemFile.find('.preview-link').attr('href', fileObj.direccion_adjunto);

			if( this.parameters.tab == 'compras' ){
				$itemFile.find(".qq-upload-delete").css('display', 'none');
			}
        }
   });

})(jQuery, this, this.document);

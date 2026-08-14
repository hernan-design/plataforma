/**
* Class SurveyQuestionView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.SurveyQuestionView = Backbone.View.extend({
        className: 'item-question-survey panel-item',
        templateOpenQuestion: _.template( ($('#survey-open-question-tpl').html() || '') ),
        templateSingleQuestion: _.template( ($('#survey-single-answer-tpl').html() || '') ),
        templateMultipleQuestion: _.template( ($('#surver-multiple-answer-tpl').html() || '') ),
        templateUploadQuestion: _.template( ($('#survey-upload-question-tpl').html() || '') ),
        templateMatrizQuestion: _.template( ($('#survey-matriz-question-tpl').html() || '') ),
        // events: {
        //     //
        // },
        parameters: {
            codigo_encuesta: '',
            renderTemplate: 'templateOpenQuestion',
            review: false,
            'params': {}
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onReadyFile', 'onCompleteLoadFile', 'onCompleteFetchFiles');

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            }

            // Init Attributes
            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 8000,
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

            // Events Listeners
            this.listenTo(this.model, 'change', this.render);
            this.listenTo(this.model, 'remove', this.remove);
            this.listenTo(this.model, 'addAfter', this.addAfter);

            // Custom events
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /**
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            attributes.review = this.parameters.review;
            // console.log('Survey Question', attributes);
            this.$el.html( this[this.parameters['renderTemplate']](attributes) ).fadeIn('fast');

            // Initialize renference to elements

            // overwrite model id attribute
            if( this.model.attributes.codigo_pregunta_encuesta ) {

                this.model.idAttribute = 'codigo_pregunta_encuesta';
                this.model.set( {'codigo_pregunta_encuesta': this.model.get('codigo_pregunta_encuesta')}, {'silent':false} );
            }

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // code goes here
        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {
            // this.ready();
        },

        /*
        * Remove View Element
        */
        remove: function(model, collection, opts){

            var _this = this;

            if( opts.onAdd )
                return

            this.$el.fadeOut('fast', function (){
                _this.$el.remove();
            });
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // if the matriz fields are image uploader
            if(
                !this.parameters.review &&
                this.model.get('tipo_pregunta_encuesta') == window._tp.typeQuestionSurvey['matriz'] &&
                (this.model.get('tipo_campo_pregunta') == window._tp.typeQuestionField['image'] ||
                typeof _.findWhere(this.model.get('opciones'), {'tipo_campo_opcion': window._tp.typeQuestionField['image']}) !== 'undefined' ||
                typeof _.findWhere(this.model.get('campos_opciones'), {'tipo_campo_opcion': window._tp.typeQuestionField['image']}) !== 'undefined')
            ) {
                // render image uploader crop for each item
                this.$('.wrapper-image-survey').each(function(index, element) {
                    var dataStr = $(element).find(':input').data('field-data'),
                        respuesta = this.model.get('respuesta');

                    var fieldData = _.chain(dataStr.split('_')).groupBy(function(opt, index){
                        return Math.floor(index/2);
                    }).toArray().object().value();

                    // split question code and option code
                    var view = new app.ImageUploaderQuestionView({
                        el: element,
                        model: this.model,
                        parameters: {
                            respuesta: _.isObject(respuesta) ? respuesta[fieldData.opcion +'_'+ fieldData.campo] : ''
                        }
                    });
                    view.render();

                }.bind(this));

            // if type question is image uploder
            }else if(
                !this.parameters.review &&
                this.model.get('tipo_campo_pregunta') == window._tp.typeQuestionField['image']
            ) {
                // render image uploader crop for one item
                var view = new app.ImageUploaderQuestionView({
                    el: this.$('.wrapper-image-survey')[0],
                    model: this.model,
                    parameters: {
                        respuesta: this.model.get('respuesta')
                    }
                });
                view.render();
            }

            // if type question is attachment uploader
            if( !this.parameters.review && this.model.get('tipo_campo_pregunta') == window._tp.typeQuestionField['attachment'] ) {
                this.$uploaderFile = this.$('#attach-file-survey');

                // call file uploader
                this.renderUploaderFile();
            }
        },

        /**
        * add element after
        * @param Object|String addEl; Dom element or html strimg or element jQuery
        */
        addAfter: function (addEl) {

            if( addEl ) this.$el.after(addEl);
        },

        // ==============================================
        //           start attachment uploader
        // ==============================================
        /**
        * render files uploader
        */
        renderUploaderFile: function () {

            var _this = this
                data = {
                    'codigo_encuesta': this.parameters['codigo_encuesta'],
                    'codigo_pregunta_encuesta': this.model.get('codigo_pregunta_encuesta')
                };

            // send extra parameters
            _.extend(data, this.parameters.params);

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-attachments-survey-template',
                session: {
                    endpoint: window.Misc.urlFull(Route.route('adjunto.encuesta.index')),
                    params: data,
                    refreshOnRequest: false
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull(Route.route('adjunto.encuesta.index')),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                deleteFile: {
                    enabled: false,
                    endpoint: window.Misc.urlFull(Route.route('adjunto.encuesta.index')),
                    customHeaders: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
                    },
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_encuesta': this.parameters['codigo_encuesta'],
                        'codigo_pregunta_encuesta': _this.model.get('codigo_pregunta_encuesta')
                    },
                    forceConfirm: true
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
                    allowedExtensions: ['pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'xlsm', 'pps', 'ppt', 'pptx', 'png', 'jpg', 'jpeg', 'zip'],
                    itemLimit: 0,
                    stopOnFirstInvalidFile: false,
                    sizeLimit: (90 * 1024) * 1024 // 50 kB = 50 * 1024 bytes
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

            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();
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
        * when file was loaded, render it like an item
        * @param $itemFile {jQuery element}
        * @param fileObj {Object}
        */
        itemWasLoaded: function ($itemFile, fileObj) {

            $itemFile.find('.preview-link').attr('href', fileObj.direccion_adjunto);

            var $fieldFile = $('<input type="hidden" name="pregunta_'+ this.model.get('codigo_pregunta_encuesta') +'">');

            $fieldFile.val( fileObj.direccion_adjunto );

            if( !this.model.get('opcional_pregunta_encuesta') ) {

                $fieldFile.attr('data-abide-validator', 'oneDataMinimun');
                $fieldFile.attr('data-reldata', 'pregunta_'+ this.model.get('codigo_pregunta_encuesta'));
            }

            $fieldFile.appendTo($itemFile);
            $('#form-survey-base').foundation('abide');
            $fieldFile.trigger('change');
        }
    });

})(jQuery, this, this.document);

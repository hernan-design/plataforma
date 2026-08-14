/**
* Class MentoringTaskView extend of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringTaskView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#mentoring-task-tpl').html() || '') ),
        events: {
            'click .remove-task-mentoring': 'onHide'
        },

        /**
        * Constructor Method
        */
        initialize : function(){

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');
            //Init Attributes
            this.$taskForm = $('#remove-mentoring');
            this.confirmRemove = new app.MentoringTaskConfirmRemoveView({
                model:this.model,
                parameters: {
                   'titleConfirm' : '¿Estás seguro que quieres eliminar tarea?'
                }
            });
            this.$modalConfirm = $('#modal-base-confirm-tp');
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
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) )
                    .fadeIn('slow');
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

            var _this = this;
            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },
        /**
        * Event Remove Task Mentoring
        */
        onHide: function (e) {
            e.preventDefault();

            this.confirmRemove.render();
        },

        /*
        * Remove View Element
        */
        remove: function(){
            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$taskForm );
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
                'wrap': '#mentoring-content',
                'direct': false,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if( re.success ){
                            $( '#form-task-mentoring [name="descripcion_tarea_mentoria"]' ).val('');
                            return;
                        }
                        _this.remove();
                        window.Misc.showAlertBox( conf );
                    }
                })(this.configAlert, resp, this)
            });
        }
   });

})(jQuery, this, this.document);

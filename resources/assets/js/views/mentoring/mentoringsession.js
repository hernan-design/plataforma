/**
* Class MentoringSessionView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringSessionView = Backbone.View.extend({

        el: '#mentoring-sessions',
        template: _.template( ($('#mentoring-session-tpl').html() || '') ),
        events: {
            'submit #form-task-mentoring': 'onStore'
        },
        parameters: {
            rol: ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters)
            }

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            this.mentoringTaskList = new app.MentoringTaskList();

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.once( 'beforeRender', this.beforeRender );
            this.once( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.rol = this.parameters.rol;

            this.$el.html( this.template(attributes) );

            // redefine id attribute model
            // if( this.model.changed.codigo_sesion !== undefined ) {
            //     // Overwrite id attribute of the model
            //     this.model.idAttribute = 'codigo_sesion';
            //     this.model.set({'codigo_sesion': this.model.get('codigo_sesion')},{'silent':true});
            // }
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

            //get Tasks of mentoring
            this.getTask();

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
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
        *  Get task from mentoring
        */
        getTask: function () {

            var taskView = new app.MentoringTaskListView({
                collection: this.mentoringTaskList,
                attributes: {
                    'mentoring': this.model.get('codigo_mentoria')
                }
            });
        },

        /**
        * Event Create Task Mentoring
        */
        onStore: function (e) {
            e.preventDefault();
            this.mentoringTaskList.trigger( 'store', this.$(e.target) );
        }
   });

})(jQuery, this, this.document);

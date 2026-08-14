/**
* Class MentoringCalificationTaskView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringCalificationTaskView = Backbone.View.extend({
        
        el: '#mentoring-sessions',
        template: _.template( ($('#mentoring-calification-task-tpl').html() || '') ),
        events: {
            'submit #form-calification-task-mentoring': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            //Init Attributes
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            var _this = this; 
            this.render = _.wrap(this.render, function(render) { 

                _this.trigger('beforeRender');

                render(); 

                _this.trigger('afterRender');

                return _this; 
            });

            this.mentoringTaskList = new app.MentoringTaskList();

            this.mentoringCalificationTaskModel = new app.MentoringCalificationTaskModel();
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            this.$buttonRegistration = this.$('.register-calification');
            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.mentoringCalificationTaskModel, 'sync', this.responseServerRegistration );
            this.once( 'beforeRender', this.beforeRender );
            this.once( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

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

            var _this = this;
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
            
            var taskView = new app.MentoringCalificationTaskListView({
                collection: this.mentoringTaskList,
                attributes: {
                    'mentoring': this.model.get('codigo_mentoria')
                }
            });
        },

        /**
        * Event Calification Task Mentoring
        */
        onStore: function (e) {
            e.preventDefault();
            var data = window.Misc.formToJson( e.target );
            this.mentoringCalificationTaskModel.save( data, {patch: true, wait:true} );
        },

        /**
        * response of the server model calificationTask
        */
        responseServerRegistration: function ( model, resp, opts ) {
            // response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ? 
                    (resp.message !== undefined ? resp.message : '...')
                    : resp.errors;

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
            
            this.$buttonRegistration.removeClass('disabled');
            if( resp.success ){
                // Redirect to Content Session Mentoring
                url = Route.route('mentoria.{rol?}.sesiones.index', { 'rol' : 'mentor' }) ;
                Backbone.history.navigate(url, { trigger:true })
            }else{
                window.Misc.showAlertBox( this.configAlert );
            }
        }

    });

})(jQuery, this, this.document);
/**
* Class MentoringEvalSessionView extends of Backbone View
* @author TuProyecto || Desarrolladora : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringEvalSessionView = Backbone.View.extend({

        el: '#mentoring-sessions',
        template: _.template( ($('#mentoring-eval-session-tpl').html() || '') ),
        events: {
            'submit #form-create-eval': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            //Init Attributes
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            var _this = this; 
            this.render = _.wrap(this.render, function(render) { 

                _this.trigger('beforeRender');

                render(); 

                _this.trigger('afterRender');

                return _this; 
            });

            this.mentoringItemList = new app.MentoringItemList();

            this.mentoringEvaluationModel = new app.MentoringEvaluationModel();
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
            this.listenTo( this.mentoringEvaluationModel, 'sync', this.responseServerRegistration );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
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
            //get Items of mentoring
            this.getItems();

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
        *  Get Items from mentoring
        */
        getItems: function () {
            var itemsView = new app.MentoringEvalSessionListView({
                collection: this.mentoringItemList,
                attributes: {}
            });
        },

        /**
        * Event Items Mentoring
        */
        onStore: function (e) {
            e.preventDefault();
            var data = window.Misc.formToJson( e.target );
            this.mentoringEvaluationModel.save( data, {patch: true, wait:true} );
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
                url = Route.route('mentoria.{rol?}.sesiones.index', { 'rol' : 'emprendedor' }) ;
                Backbone.history.navigate(url, { trigger:true })
            }else{
                window.Misc.showAlertBox( this.configAlert );
            }
        }
   });

})(jQuery, this, this.document);

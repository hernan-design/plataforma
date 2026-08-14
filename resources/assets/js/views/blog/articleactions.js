/**
* Class ArticleActionsView extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ArticleActionsView = Backbone.View.extend({
        className: 'icons-connect',
        template: _.template( ($('#buttons-article-tpl').html() || '') ),
        events: {
            'click .cancel-request-article': 'onCancelRequest',
            'click .add-request-article': 'onAddRequest',
            'click .finish-article': 'onFinishRequest',
            'click .edit-article': 'onEdit'
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

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

            this.$modalBase = $('#modal-base-message-tp');

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

            this.render();
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') ) {
                $(document).foundation('dropdown', 'reflow');
            }

            return this;
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
        * Cancel request product
        */
        onCancelRequest: function (e) {
            e.preventDefault();

            var data = {
                'codigo_contenido': this.model.get('codigo_contenido'),
                'state_article': this.model.get('state_article'),
                'cancel_request': true,
                '_token': $('meta[name="csrf-token"]').attr('content')
            };

            this.model.save( data, {patch: true, wait:true} );
        },

        /**
        * Event for Add Request Product
        */
        onAddRequest: function (e) {
            e.preventDefault();

            var data = {
                'codigo_contenido': this.model.get('codigo_contenido'),
                'state_article': this.model.get('state_article'),
                'add_request': true,
                '_token': $('meta[name="csrf-token"]').attr('content')
            };

            this.model.save( data, {patch: true, wait:true} );
        },

        /**
        * Event for Finish Product
        */
        onFinishRequest: function (e) {

            e.preventDefault();

            var data = {
                'codigo_contenido': this.model.get('codigo_contenido'),
                'state_article': this.model.get('state_article'),
                'finish_request': true,
                '_token': $('meta[name="csrf-token"]').attr('content')
            };

            this.model.save( data, {patch: true, wait:true} );
        },

        onEdit: function(e){
            e.preventDefault();

            app.AppRouter.navigate( Route.route( 'blog.show', { blog: this.model.get('url_contenido') }), {trigger: true});
        }
    });

})(jQuery, this, this.document);

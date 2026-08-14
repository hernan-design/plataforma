/**
* Class UserEditLocation extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserEditLocation = Backbone.View.extend({

        tagName: 'div',
        id: 'container-form-location',
        className: 'edit-form',
        template: _.template( ($('#edit-user-location-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-user-location': 'onEditForm',
            'change .change-nickname-profile': 'onChangeNickname'
        },
        parameters: {
            'dropdown': false
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // Initialize attributes
            this.$usernameMessage = this.$('.nickname-field-message');
            this.$usernamePath = this.$('.nickname-field-path');

            return this;
        },

        onEditForm: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );

            this.model.save(data, {patch:true, wait:true});
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

                /**
        * change nickname validate
        */
        onChangeNickname: function (e) {
            e.preventDefault();

            var _this = this,
                data = { nickname: $(e.currentTarget).val() };

            $.get( window.Misc.urlFull(Route.route('usuario.usernameavailable')), data, function (resp) {
                $(e.currentTarget).data( 'available', resp.success );

                // Message
                _this.$usernameMessage.removeClass('success-text alert-text hidesoft');
                _this.$usernameMessage.addClass(resp.success ? 'success-text' : 'alert-text');
                _this.$usernameMessage.html(resp.message);

                // Path
                _this.$usernamePath.removeClass('success-text alert-text hidesoft');
                _this.$usernamePath.addClass(resp.success ? 'success-text' : 'alert-text');
                _this.$usernamePath.html(resp.path);
            });
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });

            if( this.parameters['dropdown'] !== false )
                $(document).foundation( 'dropdown', 'close', $(this.parameters['dropdown']) );
        }
    });

})(jQuery, this, this.document);

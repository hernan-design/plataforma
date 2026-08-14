/**
* Class CourseThemeAttachedView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CourseThemeAttachedView = Backbone.View.extend({
        tagName: 'li',
        className: '',
        events: {
            'click .change-viewed': 'onChangeStateAttached',
            'click .link-to-theme-article': 'onActivateStateAttached'
        },

        initialize: function () {
            //Init Attributes
            this.stateAttachedTheme = this.$('.state-attached-theme');

            // Events Listener
            this.listenTo( this.model, 'sync', this.responseServer );

        },

        /**
        *
        */
        onChangeStateAttached: function (e) {
            this.model.changeStateReview();
        },

        /**
         *
         */
        onActivateStateAttached: function (e) {

            if(this.model.get('state_review') != true && this.model.get('codigo_tipo_adjunto') != 9) {
                this.model.changeStateReview();
            }

        },

        responseServer: function (target, resp, opts) {

            if( resp.success ){

                // whenever change the review state
                if( this.model.changed['state_review'] ){
                    console.log('si lo cambia')
                    this.stateAttachedTheme.removeClass('gray-light')
                                           .addClass('success');
                }else{
                    this.stateAttachedTheme.removeClass('success')
                                           .addClass('gray-light');
                }
            }
        }
    });

})(jQuery, this, this.document);

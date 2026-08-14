/**
* Class EventParticipantsCallView extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EventParticipantsCallView = Backbone.View.extend({
        el: '#calendar-content',
        events: {
            'click .all-participants': 'onAllParticipants'
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            // Init attributes
            this.$modalBaseMaterial = $('#modal-base-material');

            // Init collection
            this.usersEventList = new app.UsersEventList();
        },

        /*
        * Render View Element
        */
        render: function () {
            //
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
                'direct': false
            });
        },

        // See all participants
        onAllParticipants: function (e) {
            e.preventDefault();

            if ( this.usersEventListView instanceof Backbone.View ){
                this.usersEventListView.stopListening();
                this.usersEventListView.undelegateEvents();
            }

            this.usersEventListView = new window.app.UsersEventListView({
                model: this.model,
                collection: this.usersEventList
            });

            this.$modalBaseMaterial.addClass('small');
            this.$modalBaseMaterial.find('.inner-title-modal').html( 'Participantes en este evento' );
            this.$modalBaseMaterial.find('.content-modal').html( this.usersEventListView.render().el );
            this.$modalBaseMaterial.find('.content-modal').append( this.usersEventListView.$wrapViewMore );

            this.$modalBaseMaterial.foundation('reveal','open');
        }
    });

})(jQuery, this, this.document);

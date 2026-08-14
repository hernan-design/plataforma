/**
* Class CallItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CallItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#item-call-list-tpl').html() || '') ),
        events: {
            'click .show-user-likes': 'onShowUserLikes',
            'click .show-participants-program-list': 'onShowParticipantsProgram'
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            //Init Attributes
            this.$modalBase = $('#modal-base-tp');
            this.$modalBaseMaterial = $('#modal-base-material');
            // this.$modalBase.find('.content-modal').addClass('reset-content');

            this.likeList = new app.LikeList();

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){


            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

            // reference to elements
            this.$countLikes = this.$('.data-count-likes');
            this.$likeLink = this.$('.data-post-share.TPlikelink');
            this.$modalBaseMaterial.find('.content-modal').addClass('scroll-user-likes');

            // Trigger plugins
            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

            // Trigger functions
            if( typeof window.initComponent.configScrollbar == 'function' )
                window.initComponent.configScrollbar();

            if( typeof window.initComponent.configEllipsis == 'function' && _.has($.fn, 'dotdotdot') )
                window.initComponent.configEllipsis();

            // likes
            if( this.model.get('tipo_convocatoria') === window._tp.typeProgram.internal) {
                //to render like link for post
                this.likeLinkView = new window.app.LikeView({
                    el: this.$likeLink,
                    collection: this.likeList,
                    attributes: {
                        'data-srcparams': this.model.get('srcparams')
                    }
                });

                this.likeLinkView.$countLikes = this.$countLikes;
            }

            return this;
        },

        /**
        * show participants Program
        */
        onShowParticipantsProgram: function (e) {

            e.preventDefault();

            if ( this.participantsProgramUserListView instanceof Backbone.View ){
                this.participantsProgramUserListView.stopListening();
                this.participantsProgramUserListView.undelegateEvents();

            }

            this.participantsProgramUserListView = new window.app.ParticipantsProgramUserListView({
                parameters: {
                    'program': this.model.get('url_convocatoria'),
                    'orientacion': this.model.get('codigo_orientacion_convocatoria')
                }
            });
            this.$modalBaseMaterial.addClass('small');
            this.$modalBaseMaterial.find('.inner-title-modal').html( 'Participantes en esta Convocatoria' );
            this.$modalBaseMaterial.find('.content-modal').html( this.participantsProgramUserListView.render().el );
            this.$modalBaseMaterial.find('.content-modal').append( this.participantsProgramUserListView.$wrapViewMore );

            this.$modalBaseMaterial.foundation('reveal','open');
        },

        /**
        * show user likes
        */
        onShowUserLikes: function (e) {

            e.preventDefault();

            // to render view user likes
            this.viewUserLikes = new window.app.UserLikesListView({
                attributes: {
                    'data-srcparams': this.model.get('srcparams')
                }
            });
            this.$modalBase.find('.content-modal').html( this.viewUserLikes.render().el );
            this.$modalBase.find('.content-modal').append( this.viewUserLikes.$wrapViewMore );

            this.$modalBase.foundation('reveal','open');
        },

    });

})(jQuery, this, this.document);

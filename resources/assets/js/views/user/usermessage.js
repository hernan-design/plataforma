/**
* Class UserMessageView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserMessageView = Backbone.View.extend({

        template: _.template( ($('#discussion-message-user-tpl').html() || '') ),
        events: {
            'submit #form-comment-discussion': 'onStoreComment'
        },
        parameters: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // this.setElement( this.el );

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes
            this.collectionComments = new window.app.DiscussionCommentsList();
            this.$spinnerPosts = $('<div>').attr('id','spinner-load-posts');

            this.$modalBase = $('#modal-base-tp');

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function () {

            var _this = this,
                attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );
            this.$formComment = this.$('#form-comment-discussion');
            this.$commentsList = this.$('.comments-discussion-list');

            //to render view of the comment list
            this.viewComments = new window.app.UserMessageListView({
                el: this.$commentsList,
                collection: this.collectionComments,
                parameters: {
                    'codigo_discucion': this.model.get('codigo_discucion'),
                    dataFilter: {'codigo_discucion': this.model.get('codigo_discucion')}
                }
            });

            this.viewComments.trigger('getdata');
            this.listenTo(this.viewComments, 'readyContent', this.readyComments);

            return this;
        },

        /**
        * run when
        */
        ready: function () {

            // reload plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

            // initialize functions
            if( typeof window.initComponent.configScrollbar == 'function' )
                window.initComponent.configScrollbar();
        },

        /**
        * run when comments have loaded
        * @param Object contentComments
        */
        readyComments: function (contentComments) {

            this.$commentsList.scrollTop(1000);
            this.$commentsList.perfectScrollbar('update');
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {

            // window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {
            // response success or error
        },

        /**
        * Event for store a comment
        */
        onStoreComment: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );

            data.texto_comentario_discucion = window.Misc.stripTags(data.texto_comentario_discucion, 'a');
            data.texto_comentario_discucion = data.texto_comentario_discucion.replace(/(\&nbsp;|<[a-z\?\!\/]([a-z0-9\_\:\.])*(\s[^>]*)?(>|$))/gi, ' $&');
            data.texto_comentario_discucion = window.Misc.urlWrapLink(data.texto_comentario_discucion);

            // to save new message
            this.viewComments.trigger('store', data, e.target);
        }
    });

})(jQuery, this, this.document);

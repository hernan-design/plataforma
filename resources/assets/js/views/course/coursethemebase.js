/**
* Class CourseThemeBase extend of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

    app.CourseThemeBase = Backbone.View.extend({
        className: 'dd',
        events: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(){
            //Init Attributes
            this.attachments = new app.CourseThemeAttachedList();

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'change:adjuntos', this.setAttachments );
            this.listenTo( this.attachments, 'add', this.addOneAttached );
            // this.listenTo( this.attachments, 'reset', this.addAllAttached );
        },

        /*
        * Render View Element
        */
        render: function(){

            // console.log( this.model );
        	var attributes = this.model.toJSON();
            if( _.isObject(this.attributes) && this.attributes.type !== undefined ){
                attributes.type = this.attributes.type;
            }

            this.$el.html( this.template(attributes) );

            //Init Attributes
            this.$attachedList = this.$('.attached-list-theme');

            // Set Attachments
            this.setAttachments();

            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('accordion', 'reflow');
            }

            return this;
        },

        /**
        * Create a new instance of collection ThemeAttached
        * @param Object model
        * @param mixed value
        * @param Object opts
        */
        setAttachments: function (model, value) {
            this.attachments.set( this.model.get('adjuntos') );
        },

        /**
        * to refresh view of attachments theme per model
        * @param Object attachedModel model instance
        */
        addOneAttached: function (attachedModel, attacheds) {
            var view = new app.CourseThemeAttachedView({
                el: this.$attachedList.find('> li:eq('+ this.attachments.indexOf(attachedModel) +')')[0],
                model:attachedModel
            });
        },

        /**
        * Render all view category of the collection
        */
        addAllAttached: function () {
            this.$attachedList.html('');
            this.collection.forEach( this.addOneAttached, this );
        }
    });

})(jQuery, this, this.document);

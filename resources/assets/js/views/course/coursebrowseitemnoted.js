/**
 * Class CourseBrowseItemView extends of Backbone View
 * @author TuProyecto || Desarrolladora : @xindykatalina
 * @link http://TuProyecto.com
 */

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {
    app.CourseBrowseItemNoted = Backbone.View.extend({
        tagName: 'li',
        template: _.template( ($('#browse-course-noted').html() || '') ),
        events: {
            //
        },
        parameters: {
            dataFilter: {},
            type: ''
        },
        /**
         * Constructor Method
         */
        initialize: function(opts){
            // Extend options parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);
            //Init Attributes
            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },
        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            attributes.dataFilter = this.parameters['dataFilter'];
            attributes.type = this.parameters['type'];
            this.$el.html( this.template(attributes));
            // trigger plugins
            if( typeof window.initComponent.configEllipsis == 'function' )
                window.initComponent.configEllipsis();
            return this;
        }
    });
})(jQuery, this, this.document);

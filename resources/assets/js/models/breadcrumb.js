/**
* Class BreadcrumbModel of Backbone Model
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.BreadcrumbModel = Backbone.Model.extend({

        url: function () {
            return window.Misc.urlFull( Route.route('breadcrumb') );
        },
        defaults: {
            'breadcrumbs': []
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){

        }
    });

})(this, this.document);

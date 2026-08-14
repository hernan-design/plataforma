/**
* Class MentoringItemModel extends of Backbone Model
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MentoringItemModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sesiones.item.index') );
        },
        idAttribute: 'codigo_item_general_mentoria',
        defaults: {
            'nombre_item_general_mentoria': '',
            'descripcion_item_general_mentoria': ''
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //Init attributes
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {
            var err = new Error();
            if( ! attrs.nombre_item_general_mentoria.length ){
                err.message = "No hay items.";
                return err;
            }
        },

         /**
        * reset attributes in default
        */
       resetAttrs: function (opts) {
        opts || (opts = {});

        var setAttrs = {};
        setAttrs[this.idAttribute] = null;

        this.clear({silent:true});
        _.extend(setAttrs, this.defaults);
        this.set( setAttrs, opts );
    }
    });

})(this, this.document);

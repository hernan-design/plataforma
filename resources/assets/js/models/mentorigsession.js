/**
* Class MentoringModel of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

     app.MentoringSessionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('mentoria.sessiones.index') );
        },
        idAttribute: 'codigo_mentoria',
        defaults: {
            owner: false
        },

        /**
        * Constructor Method
        * @param Object attrs, model attributes
        * @param Object opts, model Options
        */
        initialize: function(attrs, opts){
            //
            // console.log('modelo mentorin sesion')
        },

        /**
        * validate attributes model in the change
        * @param Object. modified attributes model
        */
        validate: function (attrs) {

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

/**
* Class UserEventModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserEventModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('calendario.evento.participar.index') );
        },
        idAttribute: 'codigo_usuario_evento',
        defaults: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(attrs, opts){
        	//
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

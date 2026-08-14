/**
* Class BaseModel extends of Backbone Model
* @author TuProyecto/Copo software || Desarrollador : @krobing
* @link https://coposoftware.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.BaseModel = Backbone.Model.extend({
        /**
        * JSON object to String
        */
        toStrJSON: function () {
            return JSON.stringify( this );
        },

        /**
        * reset attributes in default
        */
        resetAttrs: function (opts) {
            opts || (opts = {});

            var setAttrs = {};
            setAttrs[this.idAttribute] = null;

            this.clear({ silent:true });
            _.extend(setAttrs, this.defaults);
            this.set( setAttrs, opts );
        },

        /**
        * return to url initial
        */
        returnToUrlRoot: function () {
            // redefine the URI
            this.url = function () {
                var base =
                    _.result(this, 'urlRoot') ||
                    _.result(this.collection, 'url') ||
                    urlError();

                if (this.isNew()) return base;
                var id = this.get(this.idAttribute);
                return base.replace(/[^\/]$/, '$&/') + encodeURIComponent(id);
            };
        }
    });

})(this, this.document);

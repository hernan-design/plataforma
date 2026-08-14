/**
* Class EvalItemEntrepreneurModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EvalItemEntrepreneurModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('evaluacion.item.index') );
        },
        idAttribute: 'codigo_evaluacion_item',
        defaults: {
           'evaluation': false
        }
    });

})(this, this.document);
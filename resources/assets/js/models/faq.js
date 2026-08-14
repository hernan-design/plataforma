/**
* Class FaqModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FaqModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('faq.index') );
        },
        idAttribute: 'codigo_preguntas_frecuentes',
        defaults: {
            'codigo_estado': 0,
            'texto_preguntas_frecuentes': '',
            'respuesta_preguntas_frecuentes': ''
        }
    });

})(this, this.document);
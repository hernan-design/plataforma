/**
* Class DiscussionModel extends of Backbone Model/BaseModel
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DiscussionModel = app.BaseModel.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('discusion.index') );
        },
        idAttribute: 'codigo_discucion',
        defaults: {
            'id_discucion': 0,
            'codigo_estado': 0,
            'texto_discucion': '',
            'codigo_modulo': 0,
            'contador_comentarios_discucion': 0,
            'contador_like': 0,
            'codigo_usuario': 0,
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': '',
            'fecha_discusion': '',
            'srcparams': '',
            'url_profile': '',
            'url_discusion': '',
            'origin': '',
            'owner': false
        }
    });

})(this, this.document);

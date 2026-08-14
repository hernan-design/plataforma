/**
* Class UserNoteModel extend of Backbone Model
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserNoteModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('aprende.curso.notausuario.index') );
        },
        idAttribute: 'codigo_nota_usuario',
        defaults: {
            'codigo_estado': 0,
            'texto_nota_usuario': '',
            'codigo_usuario': '',
            'codigo_curso': '',
            'nickname_usuario': '',
            'imagen_usuario': '',
            'nombre_usuario': ''
        }
    });

})(this, this.document);
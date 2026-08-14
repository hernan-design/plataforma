/**
* Class MentoringSessionListItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @refo44
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentoringSessionListItemView = Backbone.View.extend({
        template: _.template( ($('#mentoring-session-process-item-list-tpl').html() || '') ),
        parameters: {
            'rol': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            this.confirmRemove = new app.ConfirmRemoveMentoringView({
                model:this.model,
                parameters: {
                   'titleConfirm' : '¿Estás seguro que quieres cancelar esta mentoría?'
                }
            });

            this.$modalConfirm = $('#modal-base-confirm-tp');
            this.$modalBase = $('#modal-base-material');

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'destroy', this.remove );

        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            // attributes.rol = this.parameters['rol'];
             console.log('Attributes Sessions', attributes);
            this.$el.html( this.template(attributes) );

            return this;
        },

        /**
        * Event confirm session
        */
        onConfirmSesion: function (e) {
            e.preventDefault();
            var data = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'action': 'confirm-mentoring'
            };
            this.model.save(data, {patch:true, wait:true});
        },



        /**
        * destroy Mentoring
        */
        onCancelSesion: function (e) {

            e.preventDefault();
            this.confirmRemove.render();
        },
        /*
        * Remove View Element
        */
        remove: function(){
            var _this = this;
            this.$el.fadeOut('slow', function (){
                $(this).remove();
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class ProjectEditMembers extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectEditMembers = Backbone.View.extend({

        tagName: 'div',
        className: 'edit-form',
        template: _.template( ($('#edit-project-members-form-tpl').html() || '') ),
        events: {
            'submit #form-edit-project-members': 'onEditForm',
            'blur #email': 'onValidateEmail'
        },
        parameters: {
            codigo_usuario: ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

        	 // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 15000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Init Attributes
            this.$fieldEditing = this.$('.field-editing');
            this.$wrapperData = this.$('.list-members-project');
            this.$fldEmail = this.$('#email:not([data-reveal] input)');

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

        },

        /*
        * Render View Element
        */
        render: function() {

            // var attributes = this.model.toJSON();
            var attributes = {},
                _this = this;
            this.$fieldEditing.html( this.template(attributes) );

            // Initialize references
            this.$formEdit = this.$('#form-edit-project-members');

            return this;
        },

        /**
        * update project fields
        */
        onEditForm: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( this.$formEdit );
            data.codigo_usuario = this.parameters['codigo_usuario'];

            this.collection.create(data, {patch:true, wait:true});
            this.$formEdit.find(':submit').addClass('disabled');

            return;

            this.clearForm( this.$formEdit );
        },

        /**
        * Render view theme by model
        * @param Object projectTeamModel Model instance
        */
        addOne: function (projectTeamModel) {

            var view = new app.ProjectMembersItemView( {
                model: projectTeamModel,
                parameters: { codigo_usuario: this.parameters['codigo_usuario'] }
            } );

        	if( projectTeamModel.isNew() && projectTeamModel.id  !== null){
                this.$wrapperData.append( '' );
            }else{
                this.$wrapperData.append( view.render().el );
            }

        },

        /**
        * Render all view theme of the collection
        */
        addAll: function () {

            this.$wrapperData.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            if( target instanceof Backbone.Collection )
                window.Misc.setSpinner( this.$wrapperData );
        },

        /**
        * response of server
        */
        responseServer: function ( target, resp, opts ) {

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });

            if(resp.requestPost) {
                // response success or error
                var type = resp.success ? 'success' : 'alert',
                    text = resp.success ?
                        (resp.message !== undefined ? resp.message : '...')
                        : resp.errors;


                if( _.isObject( resp.errors ) ){

                    var listError = '<ul>';

                    $.each(resp.errors, function(field, item) {
                         listError += '<li>'+ item[0] +'</li>';
                    });
                    listError += '</ul>';

                    text = listError;
                }

                var config = {
                    'text': text,
                    'type': type
                };
                _.extend( this.configAlert, config );

                //complete proccess
                if( resp.success !== undefined ){
                    if( resp.success ){
                		this.clearForm( this.$formEdit );
                    }
                }

                this.$formEdit.find(':submit').removeClass('disabled');
                window.Misc.showAlertBox( this.configAlert );
            }
        },

        /**
        * clean form
        * @param Object | jQuery $formReset
        */
        clearForm: function ($formReset) {

            $formReset[0].reset();
            $formReset.find('[class*=chosen-select]')
                      .trigger("chosen:updated");

        },

        /**
        * validate email login
        */
        onValidateEmail: function (e) {

            var _this = this,
                email = (e !== undefined && e.type != 'opened' && $(e.currentTarget).length) ?
                            $(e.currentTarget).val() :
                                (!this.$fldEmail.length && e !== undefined ) ?
                                        this.$('#email').val() : this.$fldEmail.val(),
                sendData = {
                    'email': email
                };

            this.validateEmail(sendData, function (respState, respAlert, resp) {

                window.Misc.removeSpinner({
                    'wrap': _this.$formEdit,
                    'direct': true
                });

                if( respState ){
                    _this.$formEdit.find('#nombre_usuario').val(resp.labelname);
                    _this.$formEdit.find('#primer_apellido_persona').val(resp.labellastname);
                    _this.$formEdit.find(':submit').removeClass('disabled');

                    // reload function
                    if( typeof window.initComponent.initConfigForm == 'function' )
                        window.initComponent.initConfigForm();

                }else{
                    respAlert.text = "El usuario no se encuentra registrado";
                    _this.$formEdit.find('.view-input').val('');
                    _this.$formEdit.find(':submit').addClass('disabled');

                    window.Misc.showAlertBox( _this.configAlert );
                }

            });
        },

        /**
        * validate E-mail of the team project
        * @param String email
        * @return Array | [Boolean, Object]
        */
        validateEmail: function (sendData, callback) {

            var _this = this,
                respReturn = true,
                configAlert = this.configAlert,
                _data = {
                    'email': ''
                };

            if( _.isObject(sendData) )
                _.extend(_data, sendData);


            if( window.Misc.isEmail(_data['email']) ) {

                window.Misc.setSpinner( _this.$formEdit);
                $.get(document.url + Route.route('usuario.valid.email'), _data, function (resp) {

                    if( resp.success !== undefined ){

                        var type = resp.success ? 'success' : 'alert',
                            text = resp.success ?
                                   (resp.message !== undefined ? resp.message : '')
                                   : resp.errors;

                        if( _.isObject(resp.errors) ){

                            var listError = '<ul>';

                            $.each(resp.errors, function(field, item) {
                                 listError += '<li>'+ item[0] +'</li>';
                            });
                            listError += '</ul>';

                            text = listError;
                        }

                        var conf = {
                            'text': text,
                            'type': type
                        };

                        _.extend(configAlert, conf);

                        if (!resp.success) {
                            !resp.vincular_contactos ?
                                respReturn = false :
                                respReturn = true
                        }
                    }

                    if( typeof callback == 'function' ){
                        callback.call(null, respReturn, configAlert, resp);
                    }
                });
            }
        }
    });

})(jQuery, this, this.document);

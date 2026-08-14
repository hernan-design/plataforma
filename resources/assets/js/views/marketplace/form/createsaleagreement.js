/**
* Class CreateSaleAgreementView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.CreateSaleAgreementView = Backbone.View.extend({

		el: '#marketplace-content',
		template: _.template( ($('#marketplace-sale-agreement-tpl').html() || '') ),
		events: {
			'click #add-agreement-activity': 'onAddActivity',
			'click #add-agreement-adviser': 'onAddAdviser',
			'click #add-agreement-deliverable': 'onAddDeliverable',
			'click #add-agreement-workteam': 'onAddWorkteam',
            'submit #form-create-sale-agreement': 'onStore',
			'click #send-agreement-confirm': 'onSendToConfirm',
			'click #confirm-sale-agreement': 'onConfirmAgreement',
            'change #fecha_inicial_actividad_acuerdo_nuevo': 'onDate',
            'change .fecha_inicial_actividad_acuerdo': 'onInitialDateActivityChange',
            'change .fecha_final_actividad_acuerdo': 'onFinalDateActivityChange',
            'change .fecha_inicial_actividad_producto': 'onInitialDateFixedActivityChange',
            'change .fecha_final_actividad_producto': 'onFinalDateFixedActivityChange',
        },
        parameters: {
           sale: null,
           tab: '',
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	_.bindAll(this, 'beforeRender', 'render', 'afterRender');

            // extend parameters
            if(!_.isUndefined(opts) && _.isObject(opts.parameters))
            	this.parameters = $.extend({}, this.parameters, opts.parameters);

            //Init attributes
            this.model = new app.MarketPlaceAgreementModel({codigo_compra: this.parameters.sale});
            this.modelSale = new app.PurchaseModel({codigo_compra: this.parameters.sale});
            this.discussionList = new app.DiscussionList();
            this.discussionParticipantsList = new app.DiscussionParticipantsList();

            this.activitiesList = new ( Backbone.Collection.extend({
            	model: Backbone.Model.extend({ idAttribute: 'codigo_actividad_acuerdo' })
            }) );

             this.fixedActivitiesList = new ( Backbone.Collection.extend({
            	model: Backbone.Model.extend({ idAttribute: 'codigo_actividad_servicio' })
            }) );

            this.fixedActivitiesArray = [];

       
         
                   
            this.advisorsList = new ( Backbone.Collection.extend({
            	model: Backbone.Model.extend({ idAttribute: 'codigo_grupo_usuario' })
            }) );
            this.deliverablesList = new ( Backbone.Collection.extend({
            	model: Backbone.Model.extend({ idAttribute: 'codigo_entregable_acuerdo' })
            }) );

            this.fixedDeliverablesList = new ( Backbone.Collection.extend({
            	model: Backbone.Model.extend({ idAttribute: 'codigo_entregable_servicio' })
            }) );

            this.fixedDeliverablesArray = [];
           

            this.workteamList = new ( Backbone.Collection.extend({
            	model: Backbone.Model.extend({ idAttribute: 'codigo_usuario_empresario' })
            }) );

            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var initDate = new Date();
            if($('.datepkactivityagree').length){
                $('.datepkactivityagree').each(function(i, obj) {
                    obj.datetimepicker({
                        startDate: initDate,
                        minDate: new Date(),
                        timepicker: false,
                        format: 'Y-m-d',
                        step: 30,
                        mask: '9999-19-39',
                        scrollInput: false,
                        value: initDate
                    });
                });
                
                
               

            }
           

            var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

            // Events Listener
            this.listenTo( this.model, 'change:codigo_acuerdo_compra', this.render );
            this.listenTo( this.model, 'change:codigo_compra', this.getSale );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.modelSale, 'change:codigo_compra', this.render );
            this.listenTo( this.activitiesList, 'add', this.addOneActivity );
            this.listenTo( this.activitiesList, 'remove', this.removeActivity );
            this.listenTo( this.advisorsList, 'add', this.addOneAdviser );
            this.listenTo( this.advisorsList, 'remove', this.removeAdviser );
            this.listenTo( this.deliverablesList, 'add', this.addOneDeliverable );
            this.listenTo( this.deliverablesList, 'remove', this.removeDeliverable );
			this.listenTo( this.workteamList, 'add', this.addOneWorkteamMember );
            this.listenTo( this.workteamList, 'remove', this.removeWorkteamMember );
 
            // Events customize
            this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );

			// fetch sale
			if( !_.isUndefined(this.modelSale.id) && !_.isNull(this.modelSale.id) ){
                this.modelSale.fetch({ success: function(){ 
                        var  $sale =  _this.modelSale.toJSON();
                        var fixedActivitiesList = _.map($sale['actividades_servicio'], 
                        function(activity){ 
                                if(activity['resp_proveedor_actividad']){
                                    activity['resp_actividad_acuerdo']  = "resp_proveedor_actividad";
                                }else if(activity['resp_comprador_actividad']){
                                    activity['resp_actividad_acuerdo'] = "resp_comprador_actividad";
                                }else{
                                    activity['resp_actividad_acuerdo'] = '';
                                }
                                
                                return activity; 
                            });

                        var fixedDeliverablesList = $sale['entregables_servicio'];
                         _this.fixedActivitiesArray = fixedActivitiesList;
                         _this.fixedDeliverablesArray = fixedDeliverablesList;
                        _this.render();
                } });
            }

         

        },

        /**
		* view render
        */
        render: function (model, value) {

        	var attributes = this.model.toJSON();
        	attributes['sale'] = this.modelSale.toJSON();
        	attributes['tab'] = this.parameters.tab;

        	this.$el.html( this.template(attributes) );

        	// Reference to elements
        	this.$formCreate = this.$('#form-create-sale-agreement');
        	this.$wrapperActivities = this.$('#sale-agreement-activities');
        	this.$wrapperAdvisors = this.$('#sale-agreement-advisors');
        	this.$wrapperDeliverables = this.$('#sale-agreement-deliverables');
        	this.$wrapperWorkteam = this.$('#sale-agreement-workteam');
        	this.$wrapperDiscussion = this.$('#wrapper-sale-agreement-discussion');
        	this.$wrapperParticipants = this.$('#participant-discussion');
       

        	// fill carts of sale agreement
        	if( this.model.hasChanged('actividad_acuerdo') || this.model.hasChanged('asesor_acuerdo') || this.model.hasChanged('entregable_acuerdo') ){
                this.fillCarts();
            }

            if(typeof this.modelSale.get('asesor_acuerdo') != 'undefined' && !this.model.get('asesor_acuerdo').length == 0){
                this.advisorsList.add(this.modelSale.get('asesor_acuerdo'));
                var countAdvisors = this.advisorsList.length;
			    this.$('#advisors_required').val( countAdvisors || '' );
            }

        	if( this.model.id !== undefined && this.modelSale._changing ) {

        		// reference to views
	        	this.discussionListView = new app.DiscussionListView({
					el: this.$wrapperDiscussion,
					collection: this.discussionList,
					parameters: {
						formDiscussion: '#form-discussion-sale-greement',
						dataFilter: {
							'codigo_recurso_modulo' : this.model.get('codigo_acuerdo_compra'),
                            'codigo_modulo': window._tp.getModule('agreements')
						}
					}
				});

				// instance of user participants discussion view
	            this.discussionParticipantsListView = new app.DiscussionParticipantsListView({
	                el: this.$wrapperParticipants,
	                collection: this.discussionParticipantsList,
	                parameters: {
	                    'sale_agreement': this.model.get('codigo_acuerdo_compra')
	                }
	            });
        	}

            if((this.parameters.tab.toLowerCase() == 'ventas') && typeof(attributes['sale']['acuerdo_compra']) !== 'undefined' 
            && !attributes['sale']['acuerdo_compra'] )
            {
                this.fixedActivitiesList.add(this.fixedActivitiesArray);
                this.fixedDeliverablesList.add(this.fixedDeliverablesArray);
                var countActivities = this.activitiesList.length +  this.fixedActivitiesList.length;
			    this.$('#activities_required').val( countActivities || '' );
                var countDeliverables = this.deliverablesList.length +  this.fixedDeliverablesList.length;
			    this.$('#deliverables_required').val( countDeliverables || '' );

                this.fixedActivitiesList.each(function(activity) {
                
                var view = new app.SaleAgreementCarView({
                    model: activity,
                    parameters: _.extend({
                        template: 'templateActivity'
                    }, this.parameters)
			    });

			        this.$wrapperActivities.append( view.render().el ); 
                }, this)

                this.fixedDeliverablesList.each(function(deliverable) {
             
                    var view = new app.SaleAgreementCarView({
                        model: deliverable,
                        parameters: _.extend({
                        template: 'templateDeliverable'
                        }, this.parameters)
                    });

                        this.$wrapperDeliverables.append( view.render().el ); 
                    }, this)
            }

             this.activitiesList.each(function(activity) {
                 this.activityDate(activity);   
                }, this)
            
             
          
        	return this;
        },

        /**
		* get data sale
        */
        getSale: function () {
        	this.modelSale.set('codigo_compra', this.model.get('codigo_compra'), {silent:true});
        	this.modelSale.fetch();
        },

        /**
		* fill sale agreement carts
        */
        fillCarts: function () {
        	this.activitiesList.reset({silent:true});
        	this.advisorsList.reset({silent:true});
        	this.deliverablesList.reset({silent:true});
			this.workteamList.reset({silent:true});
        	this.activitiesList.set( this.model.get('actividad_acuerdo') );
        	this.advisorsList.set( this.model.get('asesor_acuerdo') );
        	this.deliverablesList.set( this.model.get('entregable_acuerdo') );
			this.workteamList.set( this.model.get('equipo_trabajo_acuerdo') );
            this.activitiesList.each(function(activity) {
                 this.activityDate(activity);   
                }, this)    
            
        },

        /**
		* Fires before of run render function
		*/
		beforeRender: function() {
			//
		},

		/**
		* Fires after of run render function
		*/
		afterRender: function() {

			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				$(document).foundation('abide', 'reflow');
			}

			// reload plugins
			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();

			if( typeof window.initComponent.spinnerTrigger == 'function' && _.has($.fn, 'sspinner') )
				window.initComponent.spinnerTrigger();

			if( typeof window.initComponent.configInputMask == 'function' && _.has($.fn, 'inputmask') )
				window.initComponent.configInputMask();

			if( typeof window.initComponent.datepickerTrigger == 'function' && _.has($.fn, 'datetimepicker') )
				window.initComponent.datepickerTrigger();

            if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
                window.initComponent.select2Trigger();
		},

		/**
        * Load spinner on the request
        */
        loadSpinner: function () {

            window.Misc.setSpinner( this.$formCreate );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp ) {
            // response success or error
            var _this = this,
                type = resp.success ? 'success' : 'alert',
                text = resp.success ?
							(resp.message !== undefined ? resp.message : '')
							: resp.errors;

            if( _.isObject( resp.errors ) ) {

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
            window.Misc.removeSpinner({
                'wrap': _this.$el,
                'direct': false
            });

            if(resp.success !== undefined) {
                if( resp.success ){
                    if(resp.message) {
                        window.Misc.showAlertBox( this.configAlert );
                    }

                    if( resp.toedit ) {
                        window.Misc.redirect( window.Misc.urlFull(Route.route('marketplace.ventas.acuerdo.edit', {acuerdo: _this.model.get('codigo_acuerdo_compra')}) ));
                    }else if( resp.toconfirm ) {
                        window.app.AppRouter.navigate( Route.route('marketplace.ventas.index'), { trigger: true } );

                    }

                    // return;
                }else{

                    window.Misc.showAlertBox( this.configAlert );
                }
            }
        },

		/**
		* add one activity
		* @param Object activity model
		*/
		addOneActivity: function (activity) {

			var view = new app.SaleAgreementCarView({
				model: activity,
				parameters: _.extend({
					template: 'templateActivity'
				}, this.parameters)
			});

			this.$wrapperActivities.append( view.render().el );
            var countActivities = this.activitiesList.length +  this.fixedActivitiesList.length;
			this.$('#activities_required').val( countActivities || '' );

           

			// reset fieldset inputs
			this.resetFields( this.$formCreate.find('[name="fields_agreement_activities"]') );
		},


        /**
		* run when it's removed an activity 
		*/
		removeActivity: function () {
            var countActivities = this.activitiesList.length +  this.fixedActivitiesList.length;
			this.$('#activities_required').val( countActivities || '' );
		},


		/**
		* add new development activity
		*/
		onAddActivity: function (e) {
			e.preventDefault();

			var data = window.Misc.formToJson(this.$formCreate),
				newData = _.pick(data, 'desc_actividad_acuerdo', 'sesiones_presencial', 'sesiones_virtual', 'resp_actividad_acuerdo', 'fecha_inicial_actividad_acuerdo_nuevo', 'fecha_final_actividad_acuerdo_nuevo', 'sesiones_presencial_horas', 'sesiones_virtual_horas');

            if(data.sesiones_presencial == 0 && data.sesiones_virtual == 0){
                var config = {
                    'text': 'Debes seleccionar al menos una sesión virtual o una sesión presencial',
                    'type': 'alert'
                };
                _.extend( this.configAlert, config );
                window.Misc.showAlertBox( config );
            }else {

                if(data.sesiones_presencial > 0 && data.sesiones_presencial_horas == 0 ){
                    var config = {
                        'text': 'Debes seleccionar al menos una hora para la sesión presencial',
                        'type': 'alert'
                    };
                    _.extend( this.configAlert, config );
                    window.Misc.showAlertBox( config );
                    return ;
                }

                if(data.sesiones_virtual > 0 && data.sesiones_virtual_horas == 0 ){
                    var config = {
                        'text': 'Debes seleccionar al menos una hora para la sesión virtual',
                        'type': 'alert'
                    };
                    _.extend( this.configAlert, config );
                    window.Misc.showAlertBox( config );
                    return ;
                }

                // add responsible
                newData[data['resp_actividad_acuerdo']] = true;

                // set parameter as an aditional activity
                newData['actividad_acuerdo_fija'] = false;

                // add date
                newData['fecha_inicial_actividad_acuerdo'] = data['fecha_inicial_actividad_acuerdo_nuevo'];
                newData['fecha_final_actividad_acuerdo'] = data['fecha_final_actividad_acuerdo_nuevo'];

                // validate fieldset inputs
                if( this.validateFields('[name="fields_agreement_activities"]') )
                	this.activitiesList.add(newData);

                 
                 this.activitiesList.each(function(activity) {
                        this.activityDate(activity);   
                }, this)

                 this.fixedActivitiesList.each(function(activity) {
                        this.activityDate(activity);   
                }, this)
  
            }
		},

		/**
		* add one adviser
		* @param Object advider model
		*/
		addOneAdviser: function (adviser) {
			var view = new app.SaleAgreementCarView({
				model: adviser,
				parameters: _.extend({
					template: 'templateAdviser',
                    codigo_usuario_entidad: this.modelSale.get('codigo_usuario_entidad')
				}, this.parameters)
			});

			this.$wrapperAdvisors.append( view.render().el );
            var countAdvisors = this.advisorsList.length;
			this.$('#advisors_required').val( countAdvisors || '' );

			// reset fieldset inputs
			this.resetFields( this.$formCreate.find('[name="fields_agreement_advisors"]') );
		},

         /**
		* run when it's removed an adviser 
		*/
		removeAdviser: function () {
            var countAdvisors = this.advisorsList.length;
			this.$('#advisors_required').val( countAdvisors || '' );
		},

		/**
		* add new development adviser
		*/
		onAddAdviser: function (e) {
			e.preventDefault();

            var _this = this,
                data = window.Misc.formToJson(this.$formCreate),
                url = window.Misc.urlFull(Route.route('usuario.equipo.show', { equipo: data.codigo_grupo_usuario }));

            // validate fieldset inputs
            if( this.validateFields('[name="fields_agreement_advisors"]') ){
                window.Misc.setSpinner( e.currentTarget );
                $.get(url, function(resp, textStatus, xhr) {
                    _this.advisorsList.find( function (o) { return o.codigo_grupo_usuario == resp.codigo_grupo_usuario; })
                    _this.advisorsList.add(resp);
                }).always(function () {
                    window.Misc.removeSpinner({
                        'wrap': e.currentTarget,
                        'direct': true
                    });
                });
            }
		},

		/**
		* add one deliverable
		* @param Object deliverable model
		*/
		addOneDeliverable: function (deliverable) {
			var view = new app.SaleAgreementCarView({
				model: deliverable,
				parameters: _.extend({
					template: 'templateDeliverable'
				}, this.parameters)
			});

            this.$wrapperDeliverables.append( view.render().el ); 
            var countDeliverables = this.deliverablesList.length +  this.fixedDeliverablesList.length;
			this.$('#deliverables_required').val( countDeliverables || '' );

			// reset fieldset inputs
			this.resetFields( this.$formCreate.find('[name="fields_agreement_deliverables"]') );
		},

		/**
		* run when it's remove a deliverable
		*/
		removeDeliverable: function () {
            var countDeliverables = this.deliverablesList.length +  this.fixedDeliverablesList.length;
			this.$('#deliverables_required').val( countDeliverables || '' );
		},

		/**
		* add new development deliverable
		*/
		onAddDeliverable: function (e) {
			e.preventDefault();

			var data = window.Misc.formToJson(this.$formCreate),
				newData = _.pick(data, 'descripcion_entregable');

                // set parameter as an aditional activity
                newData['entregable_acuerdo_fijo'] = false;

			// validate fieldset inputs
			if( this.validateFields('[name="fields_agreement_deliverables"]') )
                this.deliverablesList.add(newData);
                
  
		},

		/**
		* add one member to work team
		* @param Object deliverable model
		*/
		addOneWorkteamMember: function (workteamMember) {
			var view = new app.SaleAgreementCarView({
				model: workteamMember,
				parameters: _.extend({
					template: 'templateWorkteam'
				}, this.parameters)
			});

			this.$wrapperWorkteam.append( view.render().el );
            var countWorkTeam = this.workteamList.length;
            this.$('#workteam_required').val( countWorkTeam || '' );

			// reset fieldset inputs
			this.resetFields( this.$formCreate.find('[name="fields_agreement_workteam"]') );
		},

        /**
		* run when it's remove a workteam member
		*/
		removeWorkteamMember: function () {
            var countWorkTeam = this.workteamList.length;
            this.$('#workteam_required').val( countWorkTeam || '' );
		},

		/**
		* add new member to work team
		*/
		onAddWorkteam: function (e) {
			e.preventDefault();

			var data = window.Misc.formToJson(this.$formCreate),
				newData = _.pick(data, 'nombre_usuario_empresario', 'cargo_usuario_empresario', 'correo_usuario_empresario');

			// validate fieldset inputs
			if( this.validateFields('[name="fields_agreement_workteam"]') )
				this.workteamList.add(newData);
		},

		/**
		* reset form fields
		* @param parentForm Element
		*/
		resetFields: function (parentForm) {
			// reset inputs
			$(document).foundation('abide', 'reset', parentForm);
			$(':input', parentForm).not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('').removeAttr(Foundation.libs.abide.invalid_attr);

			// reload plugins
			this.ready();
		},

		/**
		* @param fieldSet String|Element
		* @param e Event|Object with property type
		*/
		validateFields: function (fieldSet, e) {
			return Foundation.libs.abide.validate($(fieldSet, this.$formCreate).find('input[data-abide-ignore], textarea[data-abide-ignore], select[data-abide-ignore]').get(), {type:'submit'}, false);
		},

		/**
		* store sale agreement
		*/
		onStore: function (e) {
			e.preventDefault();

            if(e.which == 13) {
                return false;
            }
            
			var data = window.Misc.formToJson(this.$formCreate),
				storeData = _.pick(data, 'alcance_acuerdo_compra', 'resultados_acuerdo_compra', '_token');

            this.model.get('codigo_compra') || (storeData['codigo_compra'] = this.parameters['sale']);

        
            var _this = this;
            var initDateRequired = false;
            var endDateRequired = false;       
            if(this.fixedActivitiesList.length){

                var initDateRequired = _.every(_this.fixedActivitiesList.toJSON(), function(item) {
                        var initDate = typeof(item.fecha_inicial_actividad_acuerdo)  !== 'undefined' ? item.fecha_inicial_actividad_acuerdo : '';
                        return _this.isValidDate(new Date( initDate)) ;
                });

                 var endDateRequired = _.every(_this.fixedActivitiesList.toJSON(), function(item) {
                        var endDate = typeof(item.fecha_final_actividad_acuerdo)  !== 'undefined' ? item.fecha_final_actividad_acuerdo : '';
                        return _this.isValidDate(new Date( endDate)) ;
                });

            } else {

                var initDateRequired = true;
                var endDateRequired = true;
            }

                if(initDateRequired && endDateRequired ){

                    if(this.fixedDeliverablesList.length){
                        this.deliverablesList.set(this.fixedDeliverablesList.toJSON(),{remove: false}); 
                        this.fixedDeliverablesList.reset(); 
                        this.fixedDeliverablesArray = [];                 
                    }    
                    this.activitiesList.set(this.fixedActivitiesList.toJSON(),{ remove: false}); 
                    this.fixedActivitiesList.reset();
                    this.fixedActivitiesArray = [];
                
                    storeData['actividad_acuerdo'] = this.activitiesList.toJSON();
			        storeData['asesor_acuerdo'] = this.advisorsList.toJSON();
			        storeData['entregable_acuerdo'] = this.deliverablesList.toJSON();
                    storeData['equipo_trabajo_acuerdo'] = this.workteamList.toJSON();
            

			        this.model.save(storeData, {patch: true, wait:true});
                
                } else {
                        var config = {
                            'text': 'Todas las actividades deben tener fecha inicial y final',
                            'type': 'alert'
                        };
                        _.extend( this.configAlert, config );
                        window.Misc.showAlertBox( this.configAlert );
                }
                         		
		},

		/**
		* send to confirm sale agreement
		*/
		onSendToConfirm: function (e) {
			e.preventDefault();

			var _this = this;

            if( this.acceptSendConfirm instanceof Backbone.View ) {
				this.acceptSendConfirm.stopListening();
				this.acceptSendConfirm.undelegateEvents();
			}

            var initDateRequired = false;
            var endDateRequired = false;       
            if(this.fixedActivitiesList.length){

                var initDateRequired = _.every(_this.fixedActivitiesList.toJSON(), function(item) {
                        var initDate = typeof(item.fecha_inicial_actividad_acuerdo)  !== 'undefined' ? item.fecha_inicial_actividad_acuerdo : '';
                        return _this.isValidDate(new Date( initDate)) ;
                });

                 var endDateRequired = _.every(_this.fixedActivitiesList.toJSON(), function(item) {
                        var endDate = typeof(item.fecha_final_actividad_acuerdo)  !== 'undefined' ? item.fecha_final_actividad_acuerdo : '';
                        return _this.isValidDate(new Date( endDate)) ;
                });

            } else if(this.activitiesList.length){
  
                var initDateRequired = _.every(_this.activitiesList.toJSON(), function(item) {
                        var initDate = typeof(item.fecha_inicial_actividad_acuerdo)  !== 'undefined' ? item.fecha_inicial_actividad_acuerdo : '';
                        return _this.isValidDate(new Date( initDate)) ;
                });

                 var endDateRequired = _.every(_this.activitiesList.toJSON(), function(item) {
                        var endDate = typeof(item.fecha_final_actividad_acuerdo)  !== 'undefined' ? item.fecha_final_actividad_acuerdo : '';
                        return _this.isValidDate(new Date( endDate)) ;
                });

            } else {

                var initDateRequired = false;

                var endDateRequired = false;
            }

            if(initDateRequired && endDateRequired ){

                this.acceptSendConfirm = new app.ConfirmWindow({
                    model: _this.model,
                    parameters: {
                        template: _.template($("#agreement-send-to-confirm-tpl").html() || ""),
                        titleConfirm: "¡Enviar acuerdo de negociación!",
                        onConfirm: function () {
                          
                            var data = window.Misc.formToJson(_this.$formCreate),
                            
                            storeData = _.pick(data, 'alcance_acuerdo_compra', 'resultados_acuerdo_compra', '_token');

                            _this.model.get('codigo_compra') || (storeData['codigo_compra'] = _this.parameters['sale']);
                            if(_this.fixedActivitiesList.length){
                                _this.activitiesList.set(_this.fixedActivitiesList.toJSON(),{remove: false});
                                _this.fixedActivitiesList.reset();       
                            }
                            
                            if(_this.fixedDeliverablesList.length){
                                _this.deliverablesList.set(_this.fixedDeliverablesList.toJSON(),{remove: false}); 
                                _this.fixedDeliverablesList.reset();           
                            }

                            storeData['actividad_acuerdo'] = _this.activitiesList.toJSON();
                            storeData['asesor_acuerdo'] = _this.advisorsList.toJSON();
                            storeData['entregable_acuerdo'] = _this.deliverablesList.toJSON();
                            storeData['equipo_trabajo_acuerdo'] = _this.workteamList.toJSON();
                            storeData['send_confirm'] = true;  
                            _this.model.save(storeData, {patch: true, wait:true});
                        }
                    }
                });

                this.acceptSendConfirm.render();
            } else {
                    var config = {
                        'text': 'Todas las actividades deben tener fecha inicial y final',
                        'type': 'alert'
                    };
                    _.extend( this.configAlert, config );
                    window.Misc.showAlertBox( this.configAlert );
                }
		},

		/**
		* confirm sale agreement
		*/
		onConfirmAgreement: function (e) {
			e.preventDefault();

			var _this = this;

			if( this.acceptConfirm instanceof Backbone.View ) {
				this.acceptConfirm.stopListening();
				this.acceptConfirm.undelegateEvents();
			}

			this.acceptConfirm = new app.ConfirmWindow({
        		model: this.model,
                parameters: {
                    template: _.template($("#sale-agreement-confirm-tpl").html() || ""),
                    titleConfirm: "Confirmar acuerdo de negociación",
	                onConfirm: function () {
						var data = {
							'codigo_acuerdo_compra': _this.model.get('codigo_acuerdo_compra'),
							'_token': $('meta[name="csrf-token"]').attr('content')
						};
                      
						window.Misc.setSpinner( e.currentTarget );
						$.post(window.Misc.urlFull(Route.route('marketplace.compras.acuerdo.confirmar')), data, function(resp, textStatus, xhr) {

							if( resp.success !== undefined ) {
								_this.model.trigger('sync', _this.model, resp);

								if( resp.success ) {
									app.AppRouter.navigate( Route.route('marketplace.compras.index'), { trigger: true } );
								}
							}

						}).always(function () {
							window.Misc.removeSpinner({
								'wrap': e.currentTarget,
								'direct': true
							});
						});
	                }
                }
            });

            this.acceptConfirm.render();
		},

         activityDate: function (activity) {
            var today = new Date();
            today.setHours(0,0,0,0);
            var initDate = activity.get('fecha_inicial_actividad_acuerdo');                     
            var endDate = activity.get('fecha_final_actividad_acuerdo'); 
            var minDate = today;    
            if( (new Date(endDate)) <= (new Date(initDate)) )
            {
                endDate = initDate;
            }

            if( (new Date(initDate)) <= (new Date(today)) )
            {
                minDate = initDate;
            }

             if(activity.get('codigo_actividad_acuerdo')>0)
             {
                    if($('#fecha_inicial_actividad_acuerdo-'+activity.id).length){
                        $('#fecha_inicial_actividad_acuerdo-'+activity.id).datetimepicker({
                            startDate: initDate,
                            minDate: minDate,
                            timepicker: false,
                            format: 'Y-m-d',
                            step: 30,
                            mask: '9999-19-39',
                            scrollInput: false,
                            value: initDate
                        });
                    }
                        
                    if($('#fecha_final_actividad_acuerdo-'+activity.id).length){    
                        $('#fecha_final_actividad_acuerdo-'+activity.id).datetimepicker({
                            minDate: minDate,
                            timepicker: false,
                            format: 'Y-m-d',
                            step: 30,
                            mask: '9999-19-39',
                            scrollInput: false,
                            startDate: endDate,
                            value: endDate
                        });
                    }

             }else if( activity.get('codigo_actividad_servicio')>0 ){

                    if($('#fecha_inicial_actividad_producto-'+activity.id).length){         
                        $('#fecha_inicial_actividad_producto-'+activity.id).datetimepicker({
                            startDate: initDate,
                            minDate: minDate,
                            timepicker: false,
                            format: 'Y-m-d',
                            step: 30,
                            mask: '9999-19-39',
                            scrollInput: false,
                            value: initDate
                        });
                    }
                    if($('#fecha_final_actividad_producto-'+activity.id).length){
                        $('#fecha_final_actividad_producto-'+activity.id).datetimepicker({
                            startDate: endDate,
                            minDate: minDate,
                            timepicker: false,
                            format: 'Y-m-d',
                            step: 30,
                            mask: '9999-19-39',
                            scrollInput: false,
                            value: endDate
                        });

                    }    
             }            
        },

        onInitialDateActivityChange: function (e) {
            e.preventDefault();
            var initDate = $(e.target).val();
            var id = $(e.target).data('id');
            var activityModel = this.activitiesList.get(id);

            if((typeof(activityModel) !== 'undefined') && (this.isValidDate(new Date(initDate))) ){         
                activityModel.set('fecha_inicial_actividad_acuerdo',initDate);           
                this.activitiesList.set(activityModel,{remove: false})
            }    
            this.activitiesList.each(function(activity) {
                 this.activityDate(activity);   
                }, this) 

                if(this.model.get('codigo_estado') === window._tp.getState['progress']){
                    $('#send-agreement-confirm').attr("disabled", true);
                }
            
        },

         onFinalDateActivityChange: function (e) {
            e.preventDefault();
            var endDate = $(e.target).val();
            var id = $(e.target).data('id');
            var activityModel = this.activitiesList.get(id);

           
            
            if((typeof(activityModel) !== 'undefined') && (this.isValidDate(new Date(endDate))) ){       
                activityModel.set('fecha_final_actividad_acuerdo',endDate);         
                this.activitiesList.set(activityModel,{remove: false})
            }
            this.activitiesList.each(function(activity) {
                 this.activityDate(activity);   
                }, this)  

                   
            if(this.model.get('codigo_estado') === window._tp.getState['progress']){
                $('#send-agreement-confirm').attr("disabled", true);
            }       
            
        },

        onInitialDateFixedActivityChange: function (e) {
            e.preventDefault();
            var initDate = $(e.target).val();
            var id = $(e.target).data('id');
            var fixedActivityModel = this.fixedActivitiesList.get(id);

       
            if( (typeof(fixedActivityModel) !== 'undefined') && (this.isValidDate(new Date(initDate))) ){ 
               fixedActivityModel.set('fecha_inicial_actividad_acuerdo',initDate);         
                this.fixedActivitiesList.set(fixedActivityModel,{remove: false});     
            }

            this.fixedActivitiesList.each(function(activity) {
                 this.activityDate(activity);   
                }, this);         
            
        },

         onFinalDateFixedActivityChange: function (e) {
            e.preventDefault();
            var endDate = $(e.target).val();
            var id = $(e.target).data('id');
            var fixedActivityModel = this.fixedActivitiesList.get(id);
            if( (typeof(fixedActivityModel) !== 'undefined') && (this.isValidDate(new Date(endDate))) ){  
               fixedActivityModel.set('fecha_final_actividad_acuerdo',endDate);         
                this.fixedActivitiesList.set(fixedActivityModel,{remove: false});    
            }
            
            this.fixedActivitiesList.each(function(activity) {
                 this.activityDate(activity);   
                }, this);            
            
        },

        isValidDate: function(d) {

            return d instanceof Date && !isNaN(d);
        },

        onDate: function (e) {
            e.preventDefault();
           
            var today = new Date();
            today.setHours(0,0,0,0);
            var initDate =  $('#fecha_inicial_actividad_acuerdo_nuevo').val();
            var endDate = $('#fecha_final_actividad_acuerdo_nuevo').val();
               
            
             
              if( !this.isValidDate(new Date(initDate)) || ( (new Date(initDate)) < (new Date(today)) ) )
            {
                initDate = today;
            }

            if( !this.isValidDate(new Date(endDate) )|| ( (new Date(endDate)) <= (new Date(initDate)) ) )
            {
                endDate = initDate;
            }


            if($('#fecha_inicial_actividad_acuerdo_nuevo').length){
                $('#fecha_inicial_actividad_acuerdo_nuevo').datetimepicker({
                    startDate: initDate,
                    minDate: today,
                    timepicker: false,
                    format: 'Y-m-d',
                    step: 30,
                    mask: '9999-19-39',
                    scrollInput: false,
                    value: initDate
                });
            }  
            if($('#fecha_final_actividad_acuerdo_nuevo').length){
                $('#fecha_final_actividad_acuerdo_nuevo').datetimepicker({
                    startDate: endDate,
                    minDate: initDate,
                    timepicker: false,
                    format: 'Y-m-d',
                    step: 30,
                    mask: '9999-19-39',
                    scrollInput: false,
                    value: endDate
                });
            }
        }
	});

})(jQuery, this, this.document)

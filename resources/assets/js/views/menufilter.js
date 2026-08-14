/**
* Class MenuFilterView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MenuFilterView = Backbone.View.extend({

		el: '#side-menu-filter',
		templateMarketplace: _.template( ($('#marketplace-sidemenu-filter-tpl').html() || '') ),
		templateLearn: _.template( ($('#learn-sidemenu-filter-tpl').html() || '') ),
		templateBlog: _.template( ($('#blog-sidemenu-filter-tpl').html() || '') ),
		templateSearch: _.template( ($('#search-sidemenu-filter-tpl').html() || '') ),
        templateStageFilter: _.template( ($('#filtro-etapa-tpl').html() || '') ),
        templateEntityFilter: _.template( ($('#filtro-entidad-tpl').html() || '') ),
        templateCategoryFilter: _.template( ($('#filtro-categoria-tpl').html() || '') ),
		templatePrograms: _.template( ($('#programs-sidemenu-filter-tpl').html() || '') ),
		templateProjects: _.template( ($('#project-sidemenu-filter-tpl').html() || '') ),
		templateGroups: _.template( ($('#group-sidemenu-filter-tpl').html() || '') ),
		templateEvaluationProject: _.template( ($('#evaluation-sidemenu-filter-tpl').html() || '') ),
		events: {
            'change select.change-choice': 'onChoice',
           // 'checked input[name=hasSpouse]': 'onFields',
		},
		parameters: {
			section: '',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({},this.parameters, opts.parameters);

        },

		/*
		* Render View Element
		*/
		render: function(){
			// module exceptions
			if( /^aprende\//.test(this.parameters['section']) ){
				section = 'aprende';
			}else if( /^blog\//.test(this.parameters['section']) ) {
				section = 'blog';
			}else if( /^proyecto\/(empresas|proyectos|micontenido)?/.test(this.parameters['section']) ) {
				section = 'proyecto';
			}else if( /^marketplace\/(misproductos|favoritos)?/.test(this.parameters['section']) ) {
				section = 'marketplace';
			}else {
				section = this.parameters['section'];
			}
			this.switchSection( section );
            if($("#type-programs").prop("checked")){
                var filterType= $("#type-programs").val();
                this.fieldsShow(filterType);
            }



			// reload plugins
			if( typeof window.initComponent.configSticky == 'function' && _.has($.fn, 'sticky') )
				window.initComponent.configSticky();

			if( typeof window.initComponent.configScrollbar == 'function' && _.has($.fn, 'perfectScrollbar') )
				window.initComponent.configScrollbar();

            if( typeof window.initComponent.chosenTrigger == 'function' && _.has($.fn, 'chosen') )
                window.initComponent.chosenTrigger();

            if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.configInputMask == 'function' && _.has($.fn, 'inputmask') )
                window.initComponent.configInputMask();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            if( typeof window.initComponent.configUiSlider == 'function' && noUiSlider )
                window.initComponent.configUiSlider();

            // set the position of side navigation button collapse
            $(".button-collapse").sideNav( {edge: 'left'} );


			return this;
		},

		/**
		* Switch section
		* @param section String
		*/
		switchSection: function (section) {

			section || (section = 'default');
			var _this = this;

			toSection = {
				'marketplace': function () {
					_this.switchAction('marketplace');
				},
				'aprende': function () {
					_this.switchAction('aprende');
				},
				'blog': function () {
					_this.switchAction('blog');
				},
				'search': function () {
					_this.switchAction('search');
				},
				'convocatoria': function () {
					 _this.switchAction('convocatoria');
				},
				'proyecto': function () {
					_this.switchAction('proyecto');
				},
				'grupo': function () {
					_this.switchAction('grupo');
				},
				'evaluacion': function () {
					_this.switchAction('evaluacion');
				},
				'default' : function() {
					//
				}
			};

			if (toSection[section]) {
				toSection[section]();
			} else {
				toSection['default']();
			}
		},


        /**
         * change options on selects
         */
        onChoice: function (e) {

            var $formFilter = $(e.currentTarget).closest('form');

            //console.log(e);
            $formFilter.submit();
        },


        // Render section identification type and number
        fieldsShow: function (param) {
            // console.log(param);
            var attributes = {
                type: '',
                category: ''
            };

            _.extend(attributes, this.parameters.dataFilter);

            var stageFilter= this.$el.find('#filtro-etapa');
            var categoryFilter= this.$el.find('#filtro-categoria');
            var entityFilter= this.$el.find('#filtro-entidad');

            // render stage sub filter on this selected options
            $includeStageFilter = ['program','mentor'];

            // render category sub filter on this selected options
            $includeCategoryFilter = ['program'];

            // render entity sub filter on this selected options
            $includeEntityFilter = ['program'];

            if( _.contains($includeStageFilter, param) ){

                stageFilter.html( this.templateStageFilter(attributes) );

            }else{
                $('#filtro-etapa-section').remove();
            }

            if( _.contains($includeCategoryFilter, param) ){

               categoryFilter.html( this.templateCategoryFilter(attributes) );

            }else{
                $('#filtro-category-section').remove();
            }

            if( _.contains($includeEntityFilter, param) ){

                entityFilter.html( this.templateEntityFilter(attributes) );

            }else{
                $('#filtro-entidad-section').remove();
            }

        },

		/**
		* Switch action
		* @param action String
		*/
		switchAction: function (action) {

			action || (action = 'default');

			var _this = this;

			var toRenderView = {
				'marketplace' : function() {
					var attributes = {
						type : '',
						category: '',
						class_product: '',
						name: '',
						provider: '',
						modality: '',
                        stage:'',
                        entity:''
					};

					_.extend(attributes, _this.parameters.dataFilter);

					_this.$el.html( _this.templateMarketplace(attributes) );
				},
				'aprende' : function(){

					var attributes = {
						type : _.isString(_this.parameters.params[0]) ? _this.parameters.params[0] : 'cursos',
						category: _.isString(_this.parameters.params[1]) ? _this.parameters.params[1] : ''
					};

					_.extend(attributes, _this.parameters.dataFilter);

					_this.$el.html( _this.templateLearn(attributes) );

				},
				'blog': function () {

					var attributes = {
						category: _.isString(_this.parameters.params[0]) ? _this.parameters.params[0] : '',
						article: _.isString(_this.parameters.params[1]) ? _this.parameters.params[1] : ''
					};

					_.extend(attributes, _this.parameters.dataFilter);

					_this.$el.html( _this.templateBlog(attributes) );
				},
				'search': function () {
					var attributes = {
						search: '',
						type: '',
                        stage:'',
                        entity:''
					};

					_.extend(attributes, _this.parameters.dataFilter);


					_this.$el.html( _this.templateSearch(attributes) );
                   var filterType= 	$('input[name=type]').val();
                    _this.fieldsShow(filterType);

				},
				'convocatoria': function () {
					var attributes = {
						type: '',
						category: ''
					};

					_.extend(attributes, _this.parameters.dataFilter);
					_this.$el.html( _this.templatePrograms(attributes) );
				},
				'proyecto' : function() {
					var attributes = {
						type : '',
						category: '',
						grade: '',
						name: '',
						identification: '',
						dataFilter: ''
					};

					_.extend(attributes, _this.parameters.dataFilter);
					_this.$el.html( _this.templateProjects(attributes) );
				},
				'grupo' : function() {
					var attributes = {
						type : '',
						category: '',
						grade: '',
						dataFilter: ''
					};

					_.extend(attributes, _this.parameters.dataFilter);
					_this.$el.html( _this.templateGroups(attributes) );
				},
				evaluacion: function () {
					var attributes = {
						state: '',
						industry: '',
						program: '',
						entrepreneurship: '',
						code: '',
						dataFilter: ''
					};

					_.extend(attributes, _this.parameters.dataFilter);
					_this.$el.html( _this.templateEvaluationProject(attributes) );
				},
				'default' : function() {
					//
				}
			};



			if (toRenderView[action]) {
				toRenderView[action]();
			} else {
				toRenderView['default']();
			}
		}
	});


})(jQuery, this, this.document);

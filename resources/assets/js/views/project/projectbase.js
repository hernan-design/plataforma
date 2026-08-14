/**
* Class BaseProjectView extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

	app.BaseProjectView = Backbone.View.extend({

		el: '#project-content',
		template: _.template( ($('#project-content-tpl').html() || '') ),
		events: {
            'click #onBack': 'onBack'
		},
		parameters: {
            tab: '',
            action: '',
            project: '',
			type: 'default',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize: function ( opts ) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
            }

			// Init Attributes
            this.projectList = new app.ProjectList();

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listeners
			this.on('beforeRender', this.beforeRender);
			this.on('afterRender', this.afterRender);
		},

		/*
		* Render View Element
		*/
		render: function () {
			// Initialize Attributes
            var attributes = {};
            attributes = _.extend(attributes, this.parameters);

            this.$el.html( this.template(attributes) );

			$( window ).off("scroll");
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function() {
			// code goes here
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function() {
			// get section
			this.stuffType( this.parameters.type, this.parameters.action );
		},

		/**
		* switch types mentoring
		*/
		stuffType: function ( type, action ) {
			action = (action = '');
			console.log(type);
			var _this = this,
				stuffType = {
					'principal' : function() {
						_.each(['principal'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'micontenido': function () {
						_.each(['micontenido'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'detail': function () {
						_.each(['detail'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'default': function () {
						_.each(['principal', 'micontenido'], function (value, index) {
							_this.stuffAction(value);
						});
					}
				};

			if (stuffType[type]) {
				stuffType[type]();
			} else {
				stuffType['default']();
			}

			// runs actions
			if( action.length ){
				 if( _.isArray(action) ) {
					_.each(action, function (value, index) {
						_this.stuffAction(value);
					});
				}else {
					this.stuffAction(action);
				}
			}
		},

		/**
		* switch actions mentoring
		*/
		stuffAction: function ( action ) {
			var _this = this,
				stuffAction = {
					'principal' : function() {
						_this.getPrincipal();
					},
					'micontenido' : function() {
						_this.getPrincipal();
					},
					'detail' : function() {
						_this.getDetail();
					},
					'default': function () {
						//
					}
				};

			if (stuffAction[action]) {
				stuffAction[action]();
			} else {
				stuffAction['default']();
			}
		},

		/**
		* get results of project principal
		*/
		getPrincipal: function () {
            if ( this.projectListView instanceof Backbone.View ){
                this.projectListView.stopListening();
                this.projectListView.undelegateEvents();
            }

            this.projectListView = new app.ProjectListView({ collection: this.projectList, parameters: this.parameters });
            this.projectListView.render();
            this.projectListView.trigger('getdata');
		},

		/**
		* get results of project detail
		*/
		getDetail: function () {
            if ( this.projectView instanceof Backbone.View ){
                this.projectView.stopListening();
                this.projectView.undelegateEvents();
            }

            this.projectView = new app.ProjectView({ model: this.parameters.project, parameters: this.parameters });
            this.parameters.project.fetch();
		},

        onBack: function(e) {
		    e.preventDefault();
            history.go(-1);
        }
	});

})(jQuery, this, this.document);

/**
* Class MentorEditSpecialities extends of Backbone View
* @author TuProyecto || Desarrolladores : @xindykatalina, @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MentorEditSpecialities = Backbone.View.extend({

		el: '#mentor-specialities-container',
		events: {
			'change #codigo_especialidad': 'onChangeSpecialty'
        },
		parameters: {
			codigo_usuario: '',
            owner: ''
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onAccept');

			 // Extend options parameters
			if( _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
			}

			// Init Attributes
			this.$noResults = this.$('.no-results-filter');
			this.$fieldEditing = this.$('.select-specialities-mentor');
			this.$wrapperData = this.$('.list-specialities-mentor');
            this.$modalOtherSpecialty = $('#modal-mentor-other-specialty-tp');

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner );
			this.listenTo( this.collection, 'sync', this.responseServer );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );

            // custom event handler
            $('#form-mentor-other-specialty').off('submit', this.onAccept);
            $('#form-mentor-other-specialty').on('submit', this.onAccept);
		},

		/*
		* Render View Element
		*/
		render: function() {

			if( this.collection.length )
				this.$noResults.css('display', 'none');

			return this;
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();

			if( typeof(window.initComponent.initConfigForm) == 'function' )
				window.initComponent.initConfigForm();
		},

        onChangeSpecialty: function (e) {
            e.preventDefault();
            if( $(e.currentTarget).val() == window._tp.getTypeSpecialty['other'] ){
                this.$modalOtherSpecialty.foundation('reveal', 'open');
            }else{
                this.onEditForm();
            }
        },

        onAccept: function (e) {
            e.preventDefault();
            var descriptionSpecialty = $(e.currentTarget).find('#descripcion_especialidad').val();
            this.onEditForm( descriptionSpecialty );
        },

		/**
		* update specialities
		*/
		onEditForm: function (data) {
            data || (data = null);

			attributes = {
                'codigo_especialidad': this.$('#codigo_especialidad').find('option:selected').val(),
                'descripcion_especialidad': !_.isNull(data) ? data : '',
                'codigo_usuario': this.parameters['codigo_usuario'],
                '_token': $('meta[name="csrf-token"]').attr('content')
            }

			if( _.isUndefined(this.collection.findWhere( {'codigo_especialidad': parseInt(attributes['codigo_especialidad']) } )) ){

				this.loadSpinnerAdd();
				this.collection.create(attributes, {patch:true, wait:true});

				return;
			}

			this.render();
		},

		/**
		* Render view theme by model
		* @param Object specialitiesModel Model instance
		*/
		addOne: function (specialitiesModel) {
			var view = new app.MentorSpecialitiesItemView( {
				model: specialitiesModel,
				parameters: {
					codigo_usuario: this.parameters['codigo_usuario'],
                    owner: this.parameters['owner']
				}
			} );
			this.$wrapperData.append( view.render().el );
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

			this.$noResults.css('display', 'none');

			if( target instanceof Backbone.Collection )
				window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinnerAdd: function ( target, xhr, opts ) {

			window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* response of server
		*/
		responseServer: function ( target, resp, opts ) {

			if( target instanceof Backbone.Collection && !target.length )
				this.$noResults.fadeIn('fast');

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});

            this.$modalOtherSpecialty.foundation('reveal', 'close');
            this.$modalOtherSpecialty.find('#descripcion_especialidad').val('');
		}
	});

})(jQuery, this, this.document);

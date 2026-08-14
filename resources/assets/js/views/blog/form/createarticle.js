/**
* Class BlogCreateView extends of Backbone View
* @author TuProyecto || Desarrolladores : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.BlogCreateView = Backbone.View.extend({
        el: '#create-article',
		template: _.template( ($('#blog-create-tpl').html() || '') ),
        events:{
			'submit #form-create-article': 'onStore'
		},

        /**
		* Constructor Method
		*/
		initialize : function() {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			//Init Attributes
            this.model = new app.BlogArticleModel();

			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 6000,
				'speedOpen': 500,
				'speedClose': 500
			};

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			//Events Listener
			this.listenTo( this.model, 'change:codigo_contenido', this.fetchOne );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );

			// Events customize
		},

        /*
		* Render View Element
		*/
		render: function(){

			var attributes = {};

			this.$el.html( this.template(attributes) );

			// Initialize attributes
			this.$formCreate = this.$('#form-create-article');
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function() {
			//
		},

		/**
		* Fires before of run render function
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
			if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();

			if( typeof window.initComponent.initLightBox == 'function' && _.has($.fn, 'imageLightbox') )
				window.initComponent.initLightBox();

			if( typeof window.initComponent.configInputMask == 'function' && _.has($.fn, 'inputmask') )
				window.initComponent.configInputMask();
		},

        /**
		* fetch category of the foro theme and reload on collection view
		* @param Object forumModel model instance
		* @param Object options object hash
		*/
		fetchOne: function (blogModel) {

			if (this.model.changed.codigo_contenido === undefined){
                return;
            }

			app.AppRouter.navigate( Route.route( 'blog.categoria.articulo', { category: blogModel.get('url_tipo_contenido'), article: blogModel.get('url_contenido') }), {trigger: true});
		},

        /**
		* Event Create Forum Post
		*/
		onStore: function (e) {
			e.preventDefault();

			var data = window.Misc.formToJson( e.target );

            if(data.texto_contenido){
                data.texto_contenido = window.Misc.stripTags( data.texto_contenido, 'a' );
                data.texto_contenido = data.texto_contenido.replace(/(\&nbsp;|<[a-z\?\!\/]([a-z0-9\_\:\.])*(\s[^>]*)?(>|$))/gi, ' $&');
                data.texto_contenido = window.Misc.urlWrapLink( data.texto_contenido );
            }

			this.model.save( data, {patch:true, wait:true} );
		},

        /**
		* Load spinner on the request
		*/
		loadSpinner: function (model, xhr, opts) {

			window.Misc.setSpinner( this.$el );
		},

		/**
		* response of the server
		*/
		responseServer: function ( model, resp, opts ) {

			// response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ?
                        (resp.message !== undefined ? resp.message : '...')
                            : resp.errors;

            if( _.isObject( resp.errors ) ) {

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
            _.extend(this.configAlert, conf);

			//complete proccess
			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false,
				'callback': (function (conf, re, $formReset) {
					return function () {

						window.Misc.showAlertBox( conf );
						if( re.success ){

							$formReset[0].reset()
							$formReset.find('.chosen-select')
									  .trigger("chosen:updated");
						}
					}
				})(this.configAlert, resp, this.$formCreate)
			});
		}
    });

 })(jQuery, this, this.document);

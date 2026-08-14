/**
* Class BasesArticleView extend of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

    app.BasesArticleView = Backbone.View.extend({

    	el: '#blog-content',
        template: _.template( ($('#blog-list-tpl').html() || '') ),
        templateLastArticle: _.template( ($('#last-article-blog-tpl').html() || '') ),
        events: {

        },
        dataArticle: {},
        parameters: {
			tab: 'default',
			action: '',
			dataFilter: {}
		},

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				_.extend(this.parameters, opts.parameters);

            // Init Attributes
            this.blogArticleList = new app.BlogArticlesList();
            this.mostViewedArticlesList = new app.MostViewedArticlesList();

            var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

            //Events Listener
            this.listenTo(this.blogArticleList, 'reset', this.renderLastArticle);
            this.on('beforeRender', this.beforeRender);
			this.on('afterRender', this.afterRender);
        },

        /*
        * Render View Element
        */
        render: function () {
            // Initialize Attributes
			var attributes = {};
			attributes.tab = this.parameters.tab;
			attributes.action = this.parameters.action;

        	this.$el.html( this.template(attributes) );

        	// Initialize Attributes
        	this.$articlesList = this.$('#article-list');
        	this.$mostViewedArticleList = this.$('#most-viewed-articles');
            this.$lastArticle = this.$('.last-article-blog');

            // Intance and get Data of Article list view
            this.blogArticleListView = new app.ArticleListView( {collection: this.blogArticleList} );
            _.extend( this.blogArticleListView.dataFilter, this.dataArticle );
            this.blogArticleListView.render();
            this.blogArticleListView.trigger('getdata');

            // Intance and get Data of Most Viewed Article list view
            this.mostViewedArticleListView = new app.MostViewedArticleListView({
                collection: this.mostViewedArticlesList,
                parameters: {
                    'mostView': 'MostViewedArticleItemView',
                    'category': this.dataArticle.category
                }
            } );
            _.extend( this.blogArticleListView.dataFilter, this.dataArticle );
            this.mostViewedArticleListView.render();
            this.mostViewedArticleListView.trigger('getdata');

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

			// this.ready();

			// get section
			this.stuffTab( this.parameters.tab, this.parameters.action );
		},

        /**
		* switch tabs mentoring
		*/
		stuffTab: function ( tab, action ) {
			action = (action = '');

			var _this = this,
				stuffTab = {
					'createArticle': function () {
						_.each(['createArticle'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'default': function () {
						_.each(['articles'], function (value, index) {
							_this.stuffAction(value);
						});
					}
				};

			if (stuffTab[tab]) {
				stuffTab[tab]();
			} else {
				stuffTab['default']();
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
					'createArticle': function () {
						_this.getCreateArticle();
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
        * render last article view
        * @param Object collection
        */
        renderLastArticle: function (collection) {

            if ( this.blogArticleList.length > 0 ) {

                var lastArticle = this.blogArticleList.first(),
                	viewUserLikes = null,
                	$modalBase = $('#modal-base-material');

                this.$lastArticle.html( this.templateLastArticle(lastArticle.toJSON()) );

                this.$lastArticle.off('click', '.show-user-likes');
                this.$lastArticle.on('click', '.show-user-likes', function (e) {

		            e.preventDefault();

		            // to render view user likes
		            viewUserLikes = new window.app.UserLikesListView({
		                parameters: {
		                    'data-srcparams': lastArticle.get('srcparams')
		                }
		            });
		            $modalBase.find('.content-modal').html( viewUserLikes.render().el );
		            $modalBase.find('.content-modal').append( viewUserLikes.$wrapViewMore );

		            $modalBase.foundation('reveal','open');
		        });
            }
        },

        getCreateArticle: function () {

            // Instance create article
            this.blogCreateView = new app.BlogCreateView();
            this.blogCreateView.render();
        }
    });

})(jQuery, this, this.document);

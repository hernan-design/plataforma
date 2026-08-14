/**
* Class BaseCourseView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

	app.BaseCourseView = Backbone.View.extend({

		el: '#course-content',
		template: _.template( ($('#course-main-tpl').html() || '') ),
        template_navbar: _.template( ($('#learn-navbar').html() || '') ),
		events: {
            'change #form-filter-courses': 'clickFilter1',
            'click #onback':'onback',
            // 'change #name-courses': 'nameFilterCourse'
		},
		parameters: {
			type: 'default',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize: function ( opts ) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = _.extend({}, this.parameters, opts.parameters);

			// Init Attributes
			this.callListNoted = new app.CourseList();
			this.callListCourse = new app.CourseList();
			this.callListWebinar = new app.CourseList();
			this.callListLecture = new app.CourseList();


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
			attributes.type = this.parameters.type;
			this.$wrapperCourse = this.$('#contentnav-course-list');
			this.$wrapperNoted = this.$('#contentnav-noted-list');
			this.$wrapperWebinar = this.$('#contentnav-webinar-list');
			this.$wrapperLecture = this.$('#contentnav-lecture-list');
            this.$el.html( this.template_navbar(attributes));
			this.$el.append( this.template(attributes) );


			$( window ).off("scroll");
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function() {
			// code goes here
		},

		/**
		* Fires after of run render function
		*/
		afterRender: function() {

			this.ready();

			// get section
			this.stuffTab(this.parameters.type);
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				$(document).foundation('tab', 'reflow');
			}
		},

		/**
		* switch type section
		* @param String type
		*/
		stuffTab: function ( type ) {
			var _this = this,
				stuffTab = {
					'principal' : function() {
						_this.onGetBrowse();
					},
					'cursos' : function() {
					    var paramsNoted = {
                            el: _this.$('#content-section-courses'),
                            collection: _this.callListNoted,
                            parameters: {
                                type: 'coursesNoted',
                                action: '',
                                dataFilter: {typeCourse: 'coursesNoted', limit: 3},
                                'ul-view': _this.$('#course-content-noted-courses')
                            }
                        };
						var params = {
							el: _this.$('#content-section-courses'),
							collection: _this.callListCourse,
							parameters: {
								type: 'cursos',
								action: '',
								dataFilter: { typeCourse: 'course' },
								'ul-view': _this.$('#browse-list-courses')
							}
						};
						_this.renderViewLearnNoted(paramsNoted);
						_this.renderViewLearn(params);
					},
					'cursosColaboradores' : function() {
					    var paramsNoted = {
                            el: _this.$('#content-section-courses-colaborators'),
                            collection: _this.callListNoted,
                            parameters: {
                                type: 'coursescolaboratorsNoted',
                                action: '',
                                dataFilter: {typeCourse: 'coursescolaboratorsNoted', limit: 3},
                                'ul-view': _this.$('#course-content-noted-courses-colaborators')
                            }
                        };
						var params = {
							el: _this.$('#content-section-courses-colaborators'),
							collection: _this.callListCourse,
							parameters: {
								type: 'cursosColaboradores',
								action: '',
								dataFilter: { typeCourse: 'coursescolaborators' },
								'ul-view': _this.$('#browse-list-courses-colaborators')
							}
						};
						_this.renderViewLearnNoted(paramsNoted);
						_this.renderViewLearn(params);
					},
					'bienestar' : function() {
					    var paramsNoted = {
                            el: _this.$('#content-section-courses-bienestar'),
                            collection: _this.callListNoted,
                            parameters: {
                                type: 'bienestarNoted',
                                action: '',
                                dataFilter: {typeCourse: 'bienestarNoted', limit: 3},
                                'ul-view': _this.$('#course-content-noted-courses-bienestar')
                            }
                        };
						var params = {
							el: _this.$('#content-section-courses-bienestar'),
							collection: _this.callListCourse,
							parameters: {
								type: 'bienestar',
								action: '',
								dataFilter: { typeCourse: 'bienestar' },
								'ul-view': _this.$('#browse-list-courses-bienestar')
							}
						};
						_this.renderViewLearnNoted(paramsNoted);
						_this.renderViewLearn(params);
					},
					'webinars' : function() {
                        var paramsNoted = {
                            el: _this.$('#content-section-webinars'),
                            collection: _this.callListNoted,
                            parameters: {
                                type: 'webinarsNoted',
                                action: '',
                                dataFilter: {typeCourse: 'webinarsNoted', limit: 3},
                                'ul-view': _this.$('#course-content-noted-webinars')
                            }
                        };
						var params = {
							el: _this.$('#content-section-webinars'),
							collection: _this.callListCourse,
							parameters: {
								type: 'webinars',
								action: '',
								dataFilter: { typeCourse: 'webinar' },
								'ul-view': _this.$('#browse-list-webinars')
							}
						};
                        _this.renderViewLearnNoted(paramsNoted);
						_this.renderViewLearn(params);
					},
					'conferencias' : function() {
                        var paramsNoted = {
                            el: _this.$('#content-section-lectures'),
                            collection: _this.callListNoted,
                            parameters: {
                                type: 'lecturesNoted',
                                action: '',
                                dataFilter: {typeCourse: 'lecturesNoted', limit: 3},
                                'ul-view': _this.$('#course-content-noted-lectures')
                            }
                        };
						var params = {
							el: _this.$('#content-section-lectures'),
							collection: _this.callListCourse,
							parameters: {
								type: 'conferencias',
								action: '',
								dataFilter: { typeCourse: 'lecture' },
								'ul-view': _this.$('#browse-list-conferencias')
							}
						};
                        _this.renderViewLearnNoted(paramsNoted);
						_this.renderViewLearn(params);
					},
					'micontenido' : function() {
						var params = {
							el: _this.$('#content-section-mycourses'),
							collection: _this.callListCourse,
							parameters: {
								type: 'micontenido',
								action: '',
								dataFilter: { typeCourse: 'micontenido' },
								'ul-view': _this.$('#browse-list-mycourses')
							}
						};

						_this.renderViewLearn(params);
					},
					'default': function () {
						_this.onGetBrowse();
					}
				};

			if (stuffTab[type]) {
				stuffTab[type]();
				this.isDefault = false;

			} else {
				stuffTab['default']();
				this.isDefault = true;
			}
		},

		/**
		* get results of course browse
		*/
		onGetBrowse: function () {

            if( this.courseNotedListView instanceof Backbone.View ) {
                this.courseNotedListView.stopListening();
                this.courseNotedListView.undelegateEvents();
            }

            // Intance and get Data of Course list view
            this.courseNotedListView = new app.CourseBrowseListView( {
                el: this.$wrapperNoted,
                collection: this.callListCourse,
                parameters: {
                    dataFilter: {
                        typeCourse: 'noted',
                        limit: 3
                    },
                    'ul-view': this.$('#course-content-noted')
                }
            } );
            this.courseNotedListView.render();
            this.courseNotedListView.trigger('getdata');

			// Collection Browse filter for course


			if( this.courseBrowseListView instanceof Backbone.View ) {
				this.courseBrowseListView.stopListening();
				this.courseBrowseListView.undelegateEvents();
			}

			// Intance and get Data of Course list view
			this.courseBrowseListView = new app.CourseBrowseListView( {
				el: this.$wrapperCourse,
				collection: this.callListCourse,
				parameters: {
					dataFilter: {
						typeCourse: 'course',
                        limit: 5
					},
					'ul-view': this.$('#course-content-list')
				}
			} );
			this.courseBrowseListView.render();
			this.courseBrowseListView.trigger('getdata');

			// Collection Browse filter for webinar

			if( this.webinarBrowseListView instanceof Backbone.View ) {
				this.webinarBrowseListView.stopListening();
				this.webinarBrowseListView.undelegateEvents();
			}

			// Intance and get Data of webinar list view
			this.webinarBrowseListView = new app.CourseBrowseListView( {
				el: this.$wrapperWebinar,
				collection: this.callListWebinar,
				parameters: {
					dataFilter: {
						typeCourse: 'webinar',
						limit: 5
					},
					'ul-view': this.$('#webinar-content-list')
			    }
			} );

			this.webinarBrowseListView.render();
			this.webinarBrowseListView.trigger('getdata');


			// Collection Browse filter for lecture

			if( this.lectureBrowseListView instanceof Backbone.View ) {
				this.lectureBrowseListView.stopListening();
				this.lectureBrowseListView.undelegateEvents();
			}

			// Intance and get Data of lecture list view
			this.lectureBrowseListView = new app.CourseBrowseListView( {
				el: this.$wrapperLecture,
				collection: this.callListLecture,
				parameters: {
					dataFilter: {
						typeCourse: 'lecture',
						limit: 5
					},
					'ul-view': this.$('#lecture-content-list')
			    }
			} );

			this.lectureBrowseListView.render();
			this.lectureBrowseListView.trigger('getdata');
		},

		/**
		* to render view learn view
		* @param Object params
		*/
		renderViewLearn: function (params) {

			params || (params = {});

			if( this.courseListView instanceof Backbone.View ) {
				this.courseListView.stopListening();
				this.courseListView.undelegateEvents();
			}

			this.courseListView = new app.CourseBrowseListView( params );
			this.courseListView.render();
			this.courseListView.trigger('getdata');
		},
        renderViewLearnNoted: function (paramsNoted) {

            paramsNoted || (paramsNoted = {});

            if( this.courseNotedView instanceof Backbone.View ) {
                this.courseNotedView.stopListening();
                this.courseNotedView.undelegateEvents();
            }
            this.courseNotedView = new app.CourseNotedListView( paramsNoted );
            this.courseNotedView.render();
            this.courseNotedView.trigger('getdata');

        },
        clickFilter1: function(e){
		    e.preventDefault();
		    var ul, container, type, check1, check2, nameCourse;
            var _this = this;
		    var typeurl = this.parameters.type;
            switch (typeurl) {
                case "cursos":
                    ul = _this.$('#browse-list-courses');
                    container =  _this.$('#content-section-courses');
                    type = "course";
                    check1 = $('#payment-courses').prop("checked");
                    check2 = $('#free-courses').prop("checked");
                    nameCourse = $('#name-courses').val();
                    break;
				case "cursosColaboradores":
					ul = _this.$('#browse-list-courses-colaborators');
					container =  _this.$('#content-section-courses-colaborators');
					type = "coursescolaborators";
					check1 = $('#payment-courses-colaborators').prop("checked");
					check2 = $('#free-courses-colaborators').prop("checked");
                    nameCourse = $('#name-courses').val();
					break;
				case "bienestar":
					ul = _this.$('#browse-list-courses-bienestar');
					container =  _this.$('#content-section-courses-bienestar');
					type = "bienestar";
					check1 = $('#payment-courses-bienestar').prop("checked");
					check2 = $('#free-courses-bienestar').prop("checked");
                    nameCourse = $('#name-courses').val();
					break;
                case "webinars":
                    ul = _this.$('#browse-list-webinars');
                    container =  _this.$('#content-section-webinars');
                    type = "webinar";
                    check1 = $('#payment-webinars').prop("checked");
                    check2 = $('#free-webinars').prop("checked");
                    nameCourse = $('#name-courses').val();
                    break;
                case "conferencias":
                    ul = _this.$('#browse-list-conferencias');
                    container =  _this.$('#content-section-conferencias');
                    type = "lecture";
                    check1 = $('#payment-lectures').prop("checked");
                    check2 = $('#free-lectures').prop("checked");
                    nameCourse = $('#name-courses').val();
                    break;
                case "micontenido":
                    ul = _this.$('#browse-list-mycourses');
                    container =  _this.$('#content-section-mycourses');
                    type = "micontenido";
                    check1 = $('#payment-mycourses').prop("checked");
                    check2 = $('#free-mycourses').prop("checked");
                    nameCourse = $('#name-courses').val();
                    break;
                default:
                    console.log("No hay resultados");
                    break;
            }
            var params = {
                el: container,
                collection: _this.callListCourse,
                parameters: {
                    type: type,
                    action: '',
                    dataFilter: {},
                    'ul-view': ul
                }
            };
            if(check1 && check2){
                if(nameCourse != ""){
                    params.parameters.dataFilter = {typeCourse: type,payment: '',name:nameCourse};
                    _this.renderViewLearn(params);
                } else{
                    params.parameters.dataFilter = {typeCourse: type,payment: '',name:''};
                    _this.renderViewLearn(params);
                }
            }else if (check1 && !check2){
                if(nameCourse != ""){
                    params.parameters.dataFilter = {typeCourse: type,payment: 'pago',name:nameCourse};
                    _this.renderViewLearn(params);
                } else {
                    params.parameters.dataFilter = {typeCourse: type,payment: 'pago',name:''};
                    _this.renderViewLearn(params);
                }
            }else if(check2 && !check1){
                if(nameCourse != ""){
                    params.parameters.dataFilter = {typeCourse: type,payment: 'gratis',name:nameCourse};
                    _this.renderViewLearn(params);
                } else {
                    params.parameters.dataFilter = {typeCourse: type,payment: 'gratis',name:''};
                    _this.renderViewLearn(params);
                }
            }else{
                if(nameCourse != ""){
                    params.parameters.dataFilter = {typeCourse: type,payment: '',name:nameCourse};
                    _this.renderViewLearn(params);
                } else {
                    params.parameters.dataFilter = {typeCourse: type,payment: '',name:''};
                    _this.renderViewLearn(params);
                }
            }
        },

        onback: function (e) {
			e.preventDefault();

            history.back(1);
        }
	});

})(jQuery, this, this.document);

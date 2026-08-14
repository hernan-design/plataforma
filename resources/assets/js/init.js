/**
* Init Class
*/

/*global*/
var app = app || {};

(function ($, window, document, undefined) {

    var InitComponent = function(){
        var csrf = window.Misc.getCsrf();

        //Init Attributes
        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    InitComponent.prototype = {

        /**
        * Constructor or Initializer Method
        */
        initialize: function () {
            // fix error about getAttribute method for comment object dom
            Object.getPrototypeOf(document.createComment('')).getAttribute = function() {}

            this.initApp();
            this.backboneSync();
            this.disabledButton();
            this.controlToolNav();
            this.initConfigForm();
            this.chosenTrigger();
            this.tagCloudTrigger();
            this.datepickerTrigger();
            this.configSlick();
            this.configDateFormatter();
            this.calendarTrigger();
            this.initAnchor();
            this.configSticky();
            this.configScrollbar();
            // this.validateFormForEdit();
            this.autoOpenModal();
            this.noCloseModal();
            this.noScrollModal();
            this.initModalForm();
            this.configModalJq();
            // this.linkShowMore();
            // this.swfObjectYoutube();
            this.embedYoutube();
            this.showBoxContent();
            this.animatedAccordion();
            this.editingForm();
            this.initTabs();
            // this.spinnerTrigger();
            this.initLightBox();
            this.select2Trigger();
            this.configEllipsis();
            this.openSocialWindow();
            this.configInputMask();
            this.copyingText();
            this.configUiSlider();

            // Chart global options
            Chart.defaults.global.defaultFontFamily = '"San Francisco", "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif';
            Chart.defaults.global.defaultFontSize = 13;

            // tell the embed parent frame the height of the content
            if (window.parent && window.parent.parent){
                window.parent.parent.postMessage(["resultsFrame", {
                    height: document.body.getBoundingClientRect().height,
                    slug: "MY7fY"
                }], "*")
            }
            // override Materialize forms default validation
            window.validate_field = function () {};
        },

        /**
        * Init Backbone Application
        */
        initApp: function () {
            window.app.AppRouter.start();
        },

        /**
        * Init backboneSync
        * Handling status codes in Backbone
        */
        backboneSync: function () {
            // Store a version of Backbone.sync to call
            var backboneSync = Backbone.sync;

            Backbone.sync = function(method, model, options) {

                // Set options to error to the new error function
                options.error = function (xhr, text_status, error_thrown) {
                    // Handling status codes
                    if(xhr.status == 400) {
                        window.Misc.redirect( );
                    }else if(xhr.status == 401) {
                        window.Misc.redirect( window.Misc.urlFull(Route.route('login')) );
                    }else if(xhr.status == 402) {
                        window.Misc.redirect( window.Misc.urlFull(Route.route('precios')) );
                    }
                }

                // Call the stored original Backbone.sync method with the new settings
                backboneSync(method, model, options);
            };
        },


        /**
        * disabled button
        */
        disabledButton: function () {
            $(document).on('click focus click.fndtn.tab focus.fndtn.tab', 'button.disabled, .button.disabled, a.disabled', null, function(e) {

                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                return false;
            });

            // disabled tabs
            $(document).on('click.fndtn.tab focus.fndtn.tab', '[data-tab].disabled dd > a, [data-tab].disabled .tab-title > a', null, function(event) {

                event.preventDefault();
                event.stopPropagation();
                event.stopImmediatePropagation();

                return false;
            });
        },

        /*
        * initialize form validate
        */
        initConfigForm: function () {

            // Show maxLength
            $('[data-maxlen]').each(function(index, el) {
                var $el = $(el),
                    textFld = $el.val(),
                    maxLength = parseInt( $el.data('maxlen') ),
                    typeLength = $el.data('abide-validator'),
                    hasLength = 0,
                    textLen = '',
                    $elCounter = $el.next('span.count-field-char').length ? $el.next('span.count-field-char') : $('<span>').addClass('count-field-char');

                switch(typeLength){
                    case 'maxLength':
                        hasLength = textFld.length;
                        textLen = ' Caracteres';
                    break;

                    case 'maxWords':
                        hasLength = textFld.length ? window.Misc.trim(textFld.replace(/\s{2,}|\t/g,' ')).split(' ').length : 0;
                        textLen = ' Palabras';
                    break;

                    default:
                        hasLength = textFld.length; textLen = ' Caracteres';
                    break;
                }

                $elCounter.text( (maxLength-hasLength) + textLen );
                $elCounter.insertAfter($el);
            });

            // Initialize Materialize form fields
            Materialize.updateTextFields();
            $('select').material_select();
            $('textarea.materialize-textarea').trigger('autoresize');
            $('input[data-abide-validator*=maxLength], textarea[data-abide-validator*=maxLength], input[length], textarea[length]').characterCounter();
            $('.button-collapse').each(function(index, el) {
                if( typeof $(el).data('activates') === 'undefined' ) {
                    $(el).sideNav();
                }
            });

            // reload plugins
            $('select').trigger('change.select2');

            $(document).off('focus blur', '.tagsinput input');
            $(document).on('focus', '.tagsinput input', function (e) {

                var $inputEl = $(e.target);

                $inputEl.parents('.tagsinput').addClass('is-focused').prev('input').triggerHandler('focus');
            });
            $(document).on('blur', '.tagsinput input', function (e) {

                var $inputEl = $(e.target);

                $inputEl.parents('.tagsinput').removeClass('is-focused');
            });
        },

        /**
        * Trigger chosen plugin config
        */
        chosenTrigger: function () {
            var _this = this,
                config = {
                    'select.chosen-select': {width:'100%', no_results_text:"No se encontrarón resultados", placeholder_text_single:' '},
                    'select.chosen-select-nosearch': {width:'100%', no_results_text:"No se encontrarón resultados", placeholder_text_single:' ', disable_search: true},
                    'select.chosen-select-deselect': {width:'100%', no_results_text:"No se encontrarón resultados", placeholder_text_single:' ', allow_single_deselect: true},
                    'select.chosen-select-deselect-nosearch': {width:'100%', no_results_text:"No se encontrarón resultados", placeholder_text_single:' ', allow_single_deselect: true, disable_search: true},
                    'select.chosen-select-no-single': {disable_search_threshold:10},
                    'select.chosen-select-multiple': {
                        max_selected_options: 6,
                        display_selected_options: false,
                        no_results_text:'¡No se encontrarón resultados! de:'
                    }
                };

            // chosen events listener
            $(document).off('chosen:ready', 'select[data-chosenopts]', this.getItemsChosen);
            $(document).on('chosen:ready', 'select[data-chosenopts]', this.getItemsChosen);
            $(document).on('chosen:ready', 'select[class*=chosen-select]', function (event, params) {
                var chosen = params.chosen,
                    $chosenResults = chosen.search_results;

                $chosenResults.addClass('scroll-chosen');
                _this.configScrollbar();
            });

            // Instance selects to chosen plugin
            for (var selector in config) {

                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( $el.data('chosen') == undefined ){
                        $el.chosen(config[selector]);
                    }
                });
            }

        },

        /**
        * event handler chosen:ready by get select items
        * @param Object e - Event
        * @param Object params
        */
        getItemsChosen: function (e, params) {
            var $chosenSel = $(e.target),
                chosen = params.chosen,
                $searchField = chosen.search_field,
                $searchResults = chosen.search_results,
                $selectedItem = chosen.selected_item,
                dataChosen = $chosenSel.data('chosenopts');

            if( ({}).toString.call(dataChosen).slice(8,-1) !== 'String' && !dataChosen.length )
                return false;

            var optsChosen = window.Misc.jsonToObject(dataChosen),
                urlChosen = optsChosen.url,
                typeSet = optsChosen.type,
                defaultsAjax = {
                    url: urlChosen,
                    type: 'GET',
                    dataType: 'json',
                    cache: true
                };

            optsChosen.setvalue || (optsChosen.setvalue = '');

            var stuffToItem = {
                'setitems': function () {

                    var optionsAjax = {
                        data: optsChosen.data,
                        complete: function (jqXHR, status) {

                            if(jqXHR.status != 200)
                                return;

                            var res = jqXHR.responseJSON,
                                htmlOpts = !optsChosen.noempty ? '<option value=""></option>' : '';

                            $.each(res, function(key, item) {
                                 htmlOpts += '<option';
                                 htmlOpts += optsChosen.setvalue == item.key ? ' selected' : '';
                                 htmlOpts += ' value="'+ item.key +'">'+ item.value +'</option>';
                            });

                            $chosenSel.html( htmlOpts );
                            $chosenSel.trigger('chosen:updated');
                        }
                    };
                    var settingsAjax = $.extend( {}, defaultsAjax, optionsAjax );

                    $.ajax(settingsAjax);
                },
                'autocomplete': function () {

                    $searchField.on('keyup', function (e) {
                        var valorTxt = $searchField.val(),
                            data = {},
                            dataTxt = {
                                q: valorTxt,
                                page: 0
                            };
                        $.extend( data, dataTxt );

                        var optionsAjax = {
                            data: data,
                            beforeSend: function (jqXHR) {
                                $chosenSel.trigger('chosen:close');
                            },
                            complete: function (jqXHR, status) {

                                if(jqXHR.status != 200)
                                    return;

                                var res = jqXHR.responseJSON,
                                    htmlOpts = !optsChosen.noempty ? '<option value=""></option>' : '',
                                    arrayResults = [{
                                        array_index: 0,
                                        empty: true,
                                        options_index: 0,
                                        search_match: false
                                    }];

                                $.each(res, function(key, item) {
                                    htmlOpts += '<option';
                                    htmlOpts += optsChosen.setvalue == item.key ? ' selected' : '';
                                    htmlOpts += ' value="'+ item.key +'">'+ item.value +'</option>';
                                    arrayResults.push({
                                        array_index: (key+1),
                                        classes: '',
                                        disabled: false,
                                        html: item.value,
                                        options_index: (key+1),
                                        selected: optsChosen.setvalue == item.key ? true : false,
                                        style: "",
                                        text: item.value,
                                        title: undefined,
                                        value: item.key
                                    });
                                });

                                $chosenSel.html( htmlOpts );
                                chosen.form_field = $chosenSel[0];
                                chosen.results_data = arrayResults;

                                // chosen.form_field_jq.trigger('chosen:hiding_dropdown');
                                // chosen.form_field_jq.trigger('chosen:showing_dropdown');
                                // chosen.form_field_jq.trigger('chosen:close');
                                // chosen.form_field_jq.trigger('chosen:open');
                                chosen.form_field_jq.trigger('chosen:updated');
                                chosen.search_field.val(valorTxt);
                                // chosen.form_field_jq.trigger('chosen:activate');
                                // chosen.form_field_jq.trigger('change');
                            }
                        };

                        var settingsAjax = $.extend( {}, defaultsAjax, optionsAjax );
                        $.ajax(settingsAjax);
                    });
                },
                default: function () {
                    // body...
                }
            };

            if (stuffToItem[typeSet]) {
                stuffToItem[typeSet]();
            } else {
                stuffToItem['default']();
            }
        },

        /**
        * Trigger Tag Cloud plugin
        */
        tagCloudTrigger: function () {

            $(document).ready(function() {
                var config = {
                  '.tagcloud-forum' : {
                        classPattern: 'tag-filter w{n}',
                        autoResize: true,
                        delay: 10,
                        steps: 5,
                        colors: ["#734C0B", "#0D4322", "#627A49", "#665B22", "#BEAC60", "#322713", "#96AA0B", "#CAC2A7", "#C7C1C5", "#F9FECB"]
                    }
                }, words = [];

                for (var selector in config)
                    $(selector).jQCloud( words, config[selector] );

            });
        },

        /**
        * Trigger foundation datepicker plugin
        */
        datepickerTrigger: function () {
            $.datetimepicker.setLocale('es');

            // var config = {
            //     '.fdatepicker' : {
            //         language: 'es',
            //         format: 'yyyy-mm-dd'
            //     }
            // };

            var configTp = {
                '.datetimepk': {
                    startDate: new Date(),
                    minDate: new Date(),
                    timepicker: true,
                    format: 'Y-m-d H:i',
                    step: 30,
                    mask: '9999-19-39 29:59',
                    scrollInput: false,
                    singleDatePicker: true,
                    autoUpdateInput: false
                },
                '.datepk': {
                    timepicker: false,
                    format: 'Y-m-d',
                    step: 30,
                    mask: '9999-19-39',
                    scrollInput: false
                },
                '.datebeforepk': {
                    timepicker: false,
                    format: 'Y-m-d',
                    step: 30,
                    mask: '9999-19-39',
                    scrollInput: false,
                    maxDate: new Date()
                },
                '.dateafterpk': {
                    timepicker: false,
                    format: 'Y-m-d',
                    step: 30,
                    mask: '9999-19-39',
                    scrollInput: false,
                    startDate: new Date(),
                    allowBlank: true,
                    maxDate: new Date()
                },
                '.datetimeafterpk': {
                    timepicker: true,
                    format: 'Y-m-d H:i',
                    step: 30,
                    mask: '9999-19-39 29:59',
                    scrollInput: false,
                    startDate: new Date(),
                    allowBlank: true,
                    minDate: new Date()
                }
            }

            // set foundation datapicker
            // for (var selector in config){
            //     $(selector).each(function(index, el) {
            //         var $el = $(el);

            //         if( $el.data('datepicker') === undefined )
            //             $el.fdatepicker(config[selector]);
            //     });
            // }

            // set jQuery datetimepicker
            for (var selector in configTp){
                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( $el.data('xdsoft_datetimepicker') === undefined )
                        $el.datetimepicker(configTp[selector]);
                });
            }
        },

        /**
        * Trigger Slick plugin config
        */
        configSlick: function () {
            var _this = this,
                config = {
                '.slick-aside': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: true,
                    autoplaySpeed: 8000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },
                '.slick-form': {
                    dots: false,
                    lazyLoad: 'ondemand',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    draggable: false,
                    adaptiveHeight: true,
                    accessibility: false
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },
                '.slick-medals': {
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: true
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },
                '.slick-browse': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: false,
                    adaptiveHeight: true,
                    verticalSwiping: false
                    // pauseOnDotsHover: true
                },
                '.slick-browse-events': {
                    dots: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    // pauseOnDotsHover: true
										responsive: [
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerPadding: '20px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '20px'
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '20px'
                            }
                        }
                    ]
                },
                '.slick-browse-project': {
                    dots: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>'
                    // pauseOnDotsHover: true
                },
                '.slick-gallery': {
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    centerMode: true,
                    centerPadding: '25px',
                    focusOnSelect: true,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    swipeToSlide: true,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    // pauseOnDotsHover: true
                    responsive: [
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 4,
                                centerPadding: '20px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 3,
                                centerPadding: '20px'
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '20px'
                            }
                        }
                    ]
                },
                '.slick-survey': {
                    dots: false,
                    lazyLoad: 'ondemand',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'linear',
                    arrows: true,
                    centerPadding: '0px',
                    draggable: false,
                    adaptiveHeight: true,
                    accessibility: false,
                    prevArrow: '<button type="button" class="slick-prev button xmedium white-skyblue btn-shadow radius">Anterior</button>',
                    nextArrow: '<button type="button" class="slick-next button xmedium sky-blue btn-shadow radius">Siguiente</button>'
                },

                '.slick-tabs': {
                    dots: false,
                    // slidesToShow: 5,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 5
                        //  }
                        // },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerPadding: '0px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                },

                '.slick-tabs-programs': {
                    dots: false,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    centerPadding: '0px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    arrows: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                arrows: true,
                                width: '1000px'

                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '0px',
                                arrows: true
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerMode: true,
                                centerPadding: '0px',
                                arrows: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // prevArrow: '<a href="#" style="background: red"><i class="fa fa-angle-left"></i></a>',
                    // nextArrow: '<a href="#" style="background: red"><i class="fa fa-angle-right"></i></a>'
                    // pauseOnDotsHover: true
                }
            };

            for (var selector in config){
                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( !$el.hasClass('slick-initialized') ){
                        $el.slick(config[selector]);

                        if( $el.length ){
                            switch(selector){
                                case '.slick-form': _this.getNavSlick($el); break;
                            }
                        }

                        // assign events to tabs
                        if( $el.data('tab') !== undefined ) {

                            $el.on('.focus.fndtn.tab click.fndtn.tab', '.tab-title > a', function (event) {
                                var settingsTab = Foundation.libs.tab.S(this).closest('[data-tab]').data('tab-init');

                                if (!settingsTab.is_hover || Modernizr.touch) {
                                    event.preventDefault();
                                    event.stopPropagation();

                                    $(document).foundation('tab', 'toggle_active_tab', Foundation.libs.tab.S(this).parent());
                                }
                            });

                            $el.on('mouseenter.fndtn.tab', '.tab-title > a', function (event) {
                                var settingsTab = Foundation.libs.tab.S(this).closest('[data-tab]').data('tab-init');

                                if (settingsTab.is_hover) $(document).foundation('tab', 'toggle_active_tab', Foundation.libs.tab.S(this).parent());
                            });
                        }
                    }
                });
            }

            // Materialize carousel
            // $('.carousel').carousel();
            // $('.carousel.carousel-items').carousel({
            //  full_width: false,
            //  no_wrap: true
            // });
        },

        /**
        * config moment.js
        */
        configDateFormatter: function () {
            // redefine moment locale
            var monthsShortDot = 'Ene._Feb._Mar._Abr._May._Jun._Jul._Ago._Sep._Oct._Nov._Dic.'.split('_'),
                monthsShort = 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic'.split('_');

            if( moment !== undefined && moment !== null ){
                moment.updateLocale('es', {
                    months : 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
                    monthsShort : function (m, format) {
                        if (/-MMM-/.test(format)) {
                            return monthsShort[m.month()];
                        } else {
                            return monthsShortDot[m.month()];
                        }
                    },
                    weekdays : 'Domingo_Lunes_Martes_Miércoles_Jueves_Viernes_Sábado'.split('_'),
                    weekdaysShort : 'Dom._Lun._Mar._Mié._Jue._Vie._Sáb.'.split('_'),
                    weekdaysMin : 'Do_Lu_Ma_Mi_Ju_Vi_Sá'.split('_')
                });
            }
        },

        /**
        * nav's slick
        * @param Object slick
        */
        getNavSlick: function ($slick) {

            var slickObj = $slick.slick('getSlick');

            // On before slide change
            $slick.on('setPosition', function(event, slick){
                // console.log('Cambio Slick::', slick, event.currentTarget);
                $('.menu-carousel-form .to-pos-carousel').removeClass('active')
                                                         .filter('[href="#'+ slick.currentSlide +'"]')
                                                         .addClass('active');
            });

            $slick.parents('.reveal-modal-form').find('.menu-carousel-form .to-pos-carousel').on('click', function (e) {
                e.preventDefault();

                var posIndx = $(e.currentTarget).attr('href').replace(/^#/,'');
                slickObj.slickGoTo( posIndx );
            });
        },

        /**
        * Trigger fullcalendar plugin config
        */
        calendarTrigger: function () {
            //
        },

        /**
        * control it to Sub navigation Tool
        */
        controlToolNav: function () {
            $('#main-wrap').on('click', '[class*="sub-nav"] > li > a, [class*="sub-nav"] > dd > a', function (e) {
                $(e.currentTarget).parent( 'dd, li' )
                                  .siblings().removeClass('active')
                                  .end().addClass('active');
            });
        },

        /**
        *  Init interactive anchor
        */
        initAnchor: function () {
            var config = {
              'anchor-to' : {
                    'parentDelegate': '#main-wrap',
                    'anchorLink': '.anchor-to',
                    'duration': 1000,
                    'gutter': -80
                }
            };

            for (var selector in config)
                window.Misc.anchorJumpTo( config[selector] );
        },

        /**
        * Init sticky plugin
        */
        configSticky: function () {
            var config = {
                '.sticky-aside-general': {
                    wrapperClassName: 'sticky-wrapper-general',
                    topSpacing: 85
                },
                '.sticky-aside': {
                    wrapperClassName: 'sticky-wrapper-aside',
                    topSpacing: 85,
                    getWidthFrom: $('.data-aside-right')
                },
                '.sticky-aside-left': {
                    wrapperClassName: 'sticky-wrapper-aside',
                    topSpacing: 85,
                    getWidthFrom: $('.data-aside-left')
                },
                '.sticky-social-btns': {
                    wrapperClassName: 'sticky-wrapper-social-btns',
                    topSpacing: 90
                    // getWidthFrom: $('.v-share-buttons')
                },
                '.sticky-side-nav': {
                    wrapperClassName: 'sticky-wrapper-side-nav',
                    responsiveWidth: true,
                    topSpacing: 79,
                    getWidthFrom: $('.content-filters-sidemenu')
                },
                '.sticky-side-menu': {
                    wrapperClassName: 'sticky-wrapper-side-menu',
                    responsiveWidth: true,
                    topSpacing: 59,
                    getWidthFrom: $('.left-off-canvas-menu')
                },

                '.sticky-filter-top': {
                    wrapperClassName: 'sticky-wrapper-filter-top',
                    responsiveWidth: true,
                    topSpacing: 59,
                    getWidthFrom: $('#wrapper-filter-bar')
                }
            }
            for (var selector in config){
                $(selector).each(function(index, el) {
                    var $el = $(el),
                        defaults = {},
                        settings = {};

                    // set limit scroll
                    if( $el.is('[data-limitscroll]') ){
                        defaults['bottomSpacing'] = $el.data('limitscroll');
                    }

                    // defaults parent
                    if( !config[selector]['getWidthFrom'] || config[selector]['getWidthFrom'].length <= 0 ){

                        defaults['getWidthFrom'] = $el.parent();
                    }

                    settings = $.extend({}, config[selector], defaults);

                    if( !$el.parent('[class*="sticky-wrapper"]').length ){
                        $el.sticky( settings );
                    }else {
                        $el.sticky('update');
                    }

                });
            }
        },

        /**
        * Init Scrollbar plugin
        */
        configScrollbar: function () {
            var config = {
                '.scroll-general': {
                    minScrollbarLength: 25
                },
                '.scroll-general-h': {
                    suppressScrollY: true,
                    minScrollbarLength: 25
                },
                '.scroll-general-v': {
                    suppressScrollX: true,
                    minScrollbarLength: 25
                },
                '.scroll-chosen': {
                    suppressScrollX: false,
                    minScrollbarLength: 25
                },
                '.scroll-aside': {
                    suppressScrollX: false,
                    useBothWheelAxes: true
                },
                '.scroll-user-likes': {
                    suppressScrollX: true
                }
            }
            for (var selector in config){
                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( !$el.hasClass('ps-container') )
                        $el.perfectScrollbar( config[selector] );
                });
            }
        },

        /**
        * to validate forms with Editor
        */
        validateFormForEdit: function () {

            var _this = this;

            Foundation.libs.abide['init'] = function (scope, method, options) {
                this.bindings(method, options);

                // delegate custome events
                _this.validateFormEvents(scope);
            };

            // overwrite validate method for abide foundation library
            Foundation.libs.abide['validate'] = function (els, e, is_ajax) {
                var validations = this.parse_patterns(els),
                    validation_count = validations.length,
                    form = this.S(els[0]).closest('form'),
                    submit_event = /submit/.test(e.type),
                    elsAdd = [].concat(els);

                // add additional index for each validation
                for (var i = 0; i < elsAdd.length; i++) {
                    var validators = [];

                    if( elsAdd[i].getAttribute(this.add_namespace('data-abide-validator')) ) {
                        validators = elsAdd[i].getAttribute(this.add_namespace('data-abide-validator')).split(' ');
                    }

                    for (var iv = 1; iv < validators.length; iv++) {
                        elsAdd.splice(i+iv, 0, elsAdd[i]);
                        i = i+iv;
                    }
                };

                // Has to count up to make sure the focus gets applied to the top error
                for (var i = 0; i < validation_count; i++) {
                    if (!validations[i] && (submit_event || is_ajax)) {
                        if (this.settings.focus_on_invalid) {
                            elsAdd[i].focus();
                        }
                        form.trigger('invalid.fndtn.abide');
                        this.S(elsAdd[i]).closest('form').attr(this.invalid_attr, '');
                        return false;
                    }
                }

                if (submit_event || is_ajax) {
                    form.trigger('valid.fndtn.abide');
                }

                form.removeAttr(this.invalid_attr);

                if (is_ajax) {
                    return false;
                }

                return true;
            };

            Foundation.libs.abide['reflow'] = function(scope, options) {
                (({}).toString.call(scope).slice(8, -1) === 'HTMLFormElement') || (scope = '[' + this.attr_name() + ']');

                var self = this,
                form = self.S(scope).attr('novalidate', 'novalidate');
                self.S(form).each(function (idx, el) {
                    // self.events(el);
                    // delegate customize events
                    _this.validateFormEvents(el);
                });
            };
        },

        /**
        * validate fields
        * @param $invalid_fields collection or element
        */
        validateFields: function ($invalid_fields) {

            $invalid_fields = $($invalid_fields);

            if( !$invalid_fields || !$invalid_fields.length ){
                return;
            }

            var _return = true;

            $invalid_fields.each(function(index, el) {

                var $fieldValid = $(el);
                var invalidClass = typeof $fieldValid.attr('data-invalid') !== 'undefined' ? true : false;
                $fieldValid.parents('.textarea-post').toggleClass('error', invalidClass);

                if( !$fieldValid.is(':checkbox,:radio') ) {
                    $fieldValid.toggleClass('valid', !invalidClass);
                    $fieldValid.toggleClass('invalid', invalidClass);
                }

                invalidClass || (_return = invalidClass);
            });

            return _return;
        },
        validateFieldOne: function(form, originalSelf, e) {
            var _this = this,
                settings = form.data(Foundation.libs.abide.attr_name(true) + '-init') || {};

            // clearTimeout(Foundation.libs.abide.timer);
            setTimeout(function () {
                Foundation.libs.abide.validate([originalSelf], e);
                // customize validation
                _this.validateFields(originalSelf);
            }.bind(originalSelf), settings.timeout);
        },

        /**
        * validate form events
        */
        validateFormEvents: function (formScope) {
            (({}).toString.call(formScope).slice(8, -1) === 'HTMLFormElement') || (formScope = 'form[data-abide]');

            var _this = this;

            // customize validations
            $(formScope)
            .off('submit.fndtn.abide')
            .on('submit.fndtn.abide', function(e) {

                var is_ajax = /ajax/i.test( Foundation.libs.abide.S(e.target).attr(Foundation.libs.abide.attr_name()) );
                return Foundation.libs.abide.validate( Foundation.libs.abide.S(e.target).find('input, textarea, select').not("[data-abide-ignore]").get(), e, is_ajax );
            });

            $(formScope).off('validate.fndtn.abide', 'form[data-abide]');
            $(formScope).on('validate.fndtn.abide', 'form[data-abide]', function (e) {

                var settings = $(this).data(Foundation.libs.abide.attr_name(true) + '-init') || {};
                var $invalid_fields = $(this).find('[data-invalid]:not([type="submit"]), .invalid:not([type="submit"])');

                // validate fields
                _this.validateFields($invalid_fields);

                // focus and scroll to fields that they are invalid
                if(e.type == 'invalid' && settings.focus_on_invalid) _this.invalidFocusField(this);
            })
            .off('blur.fndtn.abide change.fndtn.abide', 'input:not([data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])')
            .on('blur.fndtn.abide change.fndtn.abide', 'input:not([data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])', function (e) {

                // overwrite foundation validation
                var form = Foundation.libs.abide.S($(e.target).closest('form[data-abide]')[0]).attr('novalidate', 'novalidate'),
                    settings = form.data(Foundation.libs.abide.attr_name(true) + '-init') || {};

                var id = this.getAttribute('id'),
                    eqTo = form.find('[data-equalto="'+ id +'"]');

                // old settings fallback
                // will be deprecated with F6 release
                if (settings.validate_on_blur && settings.validate_on_blur === true) {
                  _this.validateFieldOne(form, this, e);
                }
                // checks if there is an equalTo equivalent related by id
                if(typeof eqTo.get(0) !== "undefined" && eqTo.val().length){
                  _this.validateFieldOne(form, eqTo.get(0), e);
                }
                // new settings combining validate options into one setting
                if (settings.validate_on === 'change') {
                  _this.validateFieldOne(form, this, e);
                }
            })
            .off('keydown.fndtn.abide', 'input:not(:radio,:checkbox,[data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])')
            .on('keydown.fndtn.abide', 'input:not(:radio,:checkbox,[data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])', function (e) {

                // overwrite foundation validation
                var form = Foundation.libs.abide.S($(e.target).closest('form[data-abide]')[0]).attr('novalidate', 'novalidate'),
                    settings = form.data(Foundation.libs.abide.attr_name(true) + '-init') || {};

                var id = this.getAttribute('id'),
                    eqTo = form.find('[data-equalto="'+ id +'"]');

                // old settings fallback
                // will be deprecated with F6 release
                if (settings.live_validate && settings.live_validate === true && e.which != 9) {
                  _this.validateFieldOne(form, this, e);
                }
                // checks if there is an equalTo equivalent related by id
                if(typeof eqTo.get(0) !== "undefined" && eqTo.val().length){
                  _this.validateFieldOne(form, eqTo.get(0), e);
                }
                // new settings combining validate options into one setting
                if (settings.validate_on === 'tab' && e.which === 9) {
                  _this.validateFieldOne(form, this, e);
                }
                else if (settings.validate_on === 'change') {
                  _this.validateFieldOne(form, this, e);
                }
            });
        },

        /**
        * focus scroll in invalid inputs
        * @parem Element formInvalid
        */
        invalidFocusField: function (formInvalid) {
            var $target = $(formInvalid).find(':input[data-invalid]:eq(0)').parent();

            var $parentScroll = $target.parents().filter(function () {
                    return ( _.contains(['fixed','relative'], $(this).css('position')) && _.contains(['auto','scroll'], $(this).css('overflow')) ) || $(this).is('body');
                }).eq(0);

            if( $parentScroll.is('body') ) {

                $parentScroll.animate({
                    scrollTop: ( $target.offset().top - 85 ) + 'px'
                }, {
                    duration: 1000,
                    easing: 'swing',
                    complete: null
                });

            }else {
                $parentScroll.animate({
                    scrollTop: '+=' + ( $target.offset().top - 85 ) + 'px'
                }, {
                    duration: 1000,
                    easing: 'swing',
                    complete: null
                });
            }
        },

        /**
        * show more link
        */
        linkShowMore: function () {
            window.Misc.showMore();
        },

        /**
        * auto open modal
        */
        autoOpenModal: function () {
            $('[data-reveal]').filter('[data-openauto]').each(function(index, el) {
                var $el = $(el);
                $el.foundation('reveal','open');
            });
        },

        /**
        * doesn't allow to close modal
        */
        noCloseModal: function () {
            $('[data-reveal]').filter('[data-noclose]').each(function(index, el) {
                var $el = $(el);
                $el.foundation('reveal', {close_on_background_click:false, close_on_esc:false});
            });
        },

        /**
        * doesn't allow scroll to window, when modal is open
        */
        noScrollModal: function () {
            var selector = '[data-reveal][data-noscroll]';

            var noScrolling = function(event) {
                if(event.namespace != 'fndtn.reveal') return;

                document.body.style.overflow = 'hidden';
            }
            var scrolling = function(event) {
                if(event.namespace != 'fndtn.reveal') return;

                document.body.style.overflow = 'auto';
            }

            $(document).off('open.fndtn.reveal', selector, noScrolling);
            $(document).on('open.fndtn.reveal', selector, noScrolling);

            $(document).off('closed.fndtn.reveal', selector, scrolling);
            $(document).on('closed.fndtn.reveal', selector, scrolling);
        },

        /**
        * Init settings forms modal
        */
        initModalForm: function  () {
            $(document).on('open.fndtn.reveal', '[data-reveal].reveal-modal-form', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this);
                $modal.foundation('reveal', {bg_class:'reveal-modal-bgform', bg:$('.reveal-modal-bgform')});

                if( $modal.hasClass('full') ){
                    $('body').css('overflow', 'hidden');
                }
            });

            $(document).on('closed.fndtn.reveal', '[data-reveal].reveal-modal-form', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this);
                $('.reveal-modal-bgform').css('display', 'none');
                $modal.foundation('reveal', {bg_class:'reveal-modal-bg', bg:$('.reveal-modal-bg')});

                if( $modal.hasClass('full') ){
                    $('body').css('overflow', 'auto');
                }
            });
        },

        /**
        * swfObjectYoutube
        */
        swfObjectYoutube: function () {

            $(document).on('opened.fndtn.reveal', '[data-reveal]', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this);
                var $videoSwfobjs = $modal.find('.video-swfobject');

                $videoSwfobjs.each(function(index, el) {

                    var urlVideo = $(el).data('urlvideo');
                    // var player = el;

                    urlVideo = window.Misc.convertVideoEmbed( urlVideo, 'swfobject' );

                    var params = { allowScriptAccess: "always" };
                    var atts = { id: $(el).attr('id') };

                    swfobject.embedSWF( urlVideo +"&enablejsapi=1&playerapiid="+ atts.id +"&autoplay=1", atts.id, "560", "400", "8", null, null, params, atts);
                });
            });

            window.onYouTubePlayerReady = function (playerId) {
                var player = document.getElementById( playerId );
                player.setVolume(50);
                player.setPlaybackQuality('large');
            }
        },

        /**
        * embedYoutube
        */
        embedYoutube: function () {

            var player = null;
            var closedModal = false;
            $(document).on('opened.fndtn.reveal', '[data-reveal]', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this),
                    $videoObjs = $modal.find('.video-swfobject');
                    // player = null;
                closedModal = false;

                var tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                window.onYouTubeIframeAPIReady = function () {

                    $videoObjs.each(function(index, el) {
                        var urlVideo = $(el).data('urlvideo'),
                            idPlayer = $(el).attr('id'),
                            videoId = window.Misc.convertVideoEmbed( urlVideo, 'videoid' );

                        player = new YT.Player(idPlayer, {
                            //Add the player
                            width: '800',
                            videoId: videoId,
                            playerVars: {
                                rel            : 0,
                                theme          : 'dark',
                                showinfo       : 0,
                                showsearch     : 0,
                                autoplay       : 1,
                                autohide       : 1,
                                modestbranding : 1
                            },
                            events: {
                                'onReady': function (event) {
                                    event.target.playVideo();
                                    event.target.setVolume(50);
                                    event.target.setPlaybackQuality('large');
                                    if( closedModal ){
                                        event.target.pauseVideo();
                                    }
                                },
                                'onStateChange': function (event) {
                                    if (event.data == YT.PlayerState.PLAYING && closedModal) {
                                        event.target.pauseVideo();
                                    }
                                }
                            }
                        });
                    });
                }
            });

            $(document).on('close.fndtn.reveal', '[data-reveal]', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                closedModal = true;
            });
        },

        /**
        * Modal config jquery
        */
        configModalJq: function () {
            var config = {
                '.modal-img-crop' : {
                    title: 'selección un área de la imagen',
                    modal: true,
                    dialogClass: 'modal-basic-jq',
                    autoOpen: false,
                    width: 570,
                    height: 'auto',
                    draggable: false,
                    resizable: false,
                    closeOnEscape: false,
                    position: { my: "center center", at: "center center", of: window }
                },
                '.modal-adviser-schedule': {
                    title: 'Descripción del Evento',
                    modal: true,
                    dialogClass: 'modal-basic-jq',
                    autoOpen: false,
                    width: 570,
                    height: 'auto',
                    draggable: false,
                    resizable: false,
                    closeOnEscape: true,
                    position: { my: "center center", at: "center center", of: window }
                },
                '.modal-event-calendar': {
                    title: 'Crear evento',
                    modal: true,
                    dialogClass: 'modal-basic-jq',
                    autoOpen: false,
                    width: 570,
                    height: 'auto',
                    draggable: false,
                    resizable: false,
                    closeOnEscape: true,
                    position: { my: "center center", at: "center center", of: window }
                },
                '.modal-request-mentoring': {
                    title: 'Crear evento de mentoría',
                    modal: true,
                    dialogClass: 'modal-basic-jq',
                    autoOpen: false,
                    width: 570,
                    height: 'auto',
                    draggable: false,
                    resizable: false,
                    closeOnEscape: true,
                    position: { my: "center center", at: "center center", of: window }
                }
            };

            for (var selector in config)
                $(selector).dialog( config[selector] );
        },

        /**
        * show box content with event click
        */
        showBoxContent: function () {
            $(document).on('click', '.link-showbox', function (e) {
                e.preventDefault();

                var $linkEl = $(e.currentTarget),
                    strRef = $linkEl.attr('href'),
                    patt = new RegExp(/^#/);

                if( patt.test(strRef) ){

                    $(strRef).slideToggle();
                    $linkEl.toggleClass( 'close-box' );
                }

                // body...
            })
        },

        /**
        * animate accordion
        */
        animatedAccordion: function () {
            $(document).on('click.fndtn.accordion', '.accordion-theme > dd > a, .accordion-theme-alt > dd > a, .accordion-pricing-plans > li > a', function (event) {
                var $link = $(event.currentTarget),
                    $dd_parent = $link.parent(),
                    $content = $dd_parent.find('.content-theme, .accordion-pricing-content');

                $dd_parent.siblings().find('.content-theme, .accordion-pricing-content').slideUp(250);

                if( $content.hasClass('active') ){

                    $content.removeClass('active');
                    $content.slideDown(250, function () {
                         $content.addClass('active');
                    });

                }else{
                    $content.slideUp(250);
                }
            });
        },

        /**
        * functionality of editable form
        */
        editingForm: function () {

            $(document).on('dblclick', '.editable-item .field-for-edit > p, .editable-item .field-for-edit .prepared-to-edit', function (event) {
                event.preventDefault();

                var $fieldEditing = $(event.currentTarget);
                $fieldEditing.parents('.editable-item').addClass('editing');
                $fieldEditing.parents('.editable-item').find('.edit-field-text').focus();
            });

            $(document).on('click', '.editable-item .edit-field-button', function(event) {
                event.preventDefault();

                var $fieldButton = $(event.currentTarget);
                $fieldButton.parents('.editable-item').addClass('editing');
                $fieldButton.parents('.editable-item').find('.edit-field-text').focus();
            });

            $(document).on('keydown', '.field-editing .edit-field-text', function(event) {

                if (event.which === 27 || event.type == 'focusout' ) {

                    var $fieldOut = $(event.target);
                    $fieldOut.parents('.editable-item').removeClass('editing');
                }
            });

            $(document).on('click', '.editable-item .close-editing', function (event) {
                event.preventDefault();

                var $fieldOut = $(event.currentTarget);
                $fieldOut.parents('.editable-item').removeClass('editing');
            });
        },

        /**
        * init tab config
        */
        initTabs: function () {
            $('[data-tab].tabs-route, [data-tab].tabs-progress-bar, [data-tab].slick-tabs').off('toggled');
            $('[data-tab].tabs-route').on('toggled', function(event, tab) {
                var $elTab = $(event.currentTarget),
                    $linkActive = $elTab.find('dd.active a, .tab-title.active a'),
                    refTab = $linkActive.attr('aria-controls');

                var settings = $elTab.data(Foundation.libs.tab.attr_name(true) + '-init') || {};

                // if it's url to go there
                if( settings.is_hover && Modernizr.touch && window.Misc.isUrl($linkActive.attr('href')) ) {

                    window.Misc.redirect($linkActive.attr('href'));

                    if( refTab != '' ) {
                        $('#'+refTab).addClass('active')
                                     .siblings('.content').removeClass('active');
                    }

                }else if( window.Misc.isUrl($linkActive.attr('href')) && $elTab.hasClass('tabs-redirect') ) {
                    window.Misc.redirect($linkActive.attr('href'));

                }else {
                    if( refTab != '' ) {
                        $('#'+refTab).addClass('active')
                                     .siblings('.content').removeClass('active');
                    }
                }
            });

            $('[data-tab].table-of-contents').off('toggled');
            $('[data-tab].table-of-contents').on('toggled', function(event, tab) {
                var $elTab = $(event.currentTarget),
                    $linkActive = $elTab.find('dd.active a, .tab-title.active a');

                $elTab.find('dd a, .tab-title a').removeClass('active');
                $linkActive.addClass('active');
            });

            // event close tabs
            $(document).on('click', '.tabs-content .content > .close', function (event) {
                event.preventDefault();

                var idContent = $(event.currentTarget).parents('.content')
                                                        .removeClass('active').attr('id');

                $('[aria-controls="'+ idContent +'"]').attr('aria-selected', false)
                                                         .parent().removeClass('active');
            });

            // event progress bar completed
            $('[data-tab].tabs-progress-bar').on('toggled', function (event, tab) {

                var $elTab = $(event.currentTarget),
                    $tabChildren = $elTab.find('dd, .tab-title'),
                    $barProgress = $elTab.find('.bar__fill');

                // calculate percentage of progress bar
                var percentageBar =  ($tabChildren.index($tabChildren.filter('.active'))) / ($tabChildren.length - 1) * 100;
                $barProgress.css({'width': percentageBar + '%' });
            });

            window.setTimeout(function () {
                $('[data-tab].tabs-progress-bar').trigger('toggled');
            }, 1500);

            // init materialize tabs
            // $('ul.tabs-sub-nav').tabs();
        },

        /**
        * spinner for text fields
        */
        spinnerTrigger: function () {
            var config = {
                '.spinner-currency' : {
                    step: 5,
                    start: 1000,
                    min: 0,
                    numberFormat: "C",
                    culture: 'es-CO',
                    currency: 'COP'
                },
                '.spinner-quantity': {
                    step: 1,
                    start: 1,
                    min: 0,
                    numberFormat: "n"
                }
            };

            for (var selector in config) {

                $(selector).each(function(index, el) {
                    var $el = $(el);
                    var spinner = {};

                    if( !$el.sspinner( "instance" ) ) {
                        spinner = $el.sspinner(config[selector]);

                        if( $el.val() == '' )
                            spinner.sspinner( "value", 0 );

                        // set currency mask to spinner
                        if( $el.hasClass('spinner-currency') && _.has($.fn, 'inputmask') ) {
                            $el.inputmask({
                                radixPoint: ",",
                                alias: 'currencySubmit'
                            })
                        }
                    }else if( $el.val() == '' ) {
                        $el.sspinner( "value", 0 );
                    }

                    // if no change
                    if( $el.hasClass('no-change') ) {

                        $el.focus(function () {
                            // $(this).blur();
                        });

                        $el.on("keydown", function (event) {
                            event.preventDefault();
                        });
                    }
                });
            }
        },

        /**
        * init lightbox
        */
        initLightBox: function () {

            // actions for settings lightbox
            var activityIndicatorOn = function () {
                    $('<div id="imagelightbox-loading"><div></div></div>').appendTo('body');
                },
                activityIndicatorOff = function () {
                    $('#imagelightbox-loading').remove();
                },

                overlayOn = function () {
                    $('<div id="imagelightbox-overlay"></div>').appendTo('body');
                },
                overlayOff = function () {
                    $('#imagelightbox-overlay').remove();
                },

                closeButtonOn = function (instance) {
                    $('<a href="#" id="imagelightbox-close"></a>').appendTo('body').on('click', function () {
                        $(this).remove();
                        instance.quitImageLightbox();
                        return false;
                    });
                },
                closeButtonOff = function () {
                    $('#imagelightbox-close').remove();
                },

                captionOn = function () {
                    var description = $('a[href="' + $('#imagelightbox').attr('src') + '"] img').attr('alt');
                    if (description.length > 0)
                        $('<div id="imagelightbox-caption">' + description + '</div>').appendTo('body');
                },
                captionOff = function () {
                    $('#imagelightbox-caption').remove();
                },

                navigationOn = function (instance, selector) {
                    var images = $(selector);
                    if (images.length) {
                        var nav = $('<div id="imagelightbox-nav"></div>');
                        for (var i = 0; i < images.length; i++)
                            nav.append('<a href="#"></a>');

                        nav.appendTo('body');
                        nav.on('click touchend', function () {
                            return false;
                        });

                        var navItems = nav.find('a');
                        navItems.on('click touchend', function () {
                            var $this = $(this);
                            if (images.eq($this.index()).attr('href') != $('#imagelightbox').attr('src'))
                                instance.switchImageLightbox($this.index());

                            navItems.removeClass('active');
                            navItems.eq($this.index()).addClass('active');

                            return false;
                        })
                                .on('touchend', function () {
                                    return false;
                                });
                    }
                },
                navigationUpdate = function (selector) {
                    var items = $('#imagelightbox-nav').find('a');
                    items.removeClass('active');
                    items.eq($(selector).filter('[href="' + $('#imagelightbox').attr('src') + '"]').index(selector)).addClass('active');
                },
                navigationOff = function () {
                    $('#imagelightbox-nav').remove();
                },
                arrowsOn = function( instance, selector ) {
                    var $arrows = $( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button>' +
                                     '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );
                    $arrows.appendTo( 'body' );
                    $arrows.on( 'click touchend', function( e ) {
                        e.preventDefault();

                        var $this = $( this );

                        if( $this.hasClass('imagelightbox-arrow-left')) {
                            instance.loadPreviousImage();
                        } else {
                            instance.loadNextImage();
                        }

                        return false;
                    });
                },
                arrowsOff = function() {
                    $('.imagelightbox-arrow').remove();
                };

            var config = {
                '.light-preview-image': {
                    // selector:       'id="imagelightbox"',   // string;
                    allowedTypes:   'png|jpg|jpeg|gif',     // string;
                    animationSpeed: 250,                    // integer;
                    preloadNext:    true,                   // bool;            silently preload the next image
                    enableKeyboard: true,                   // bool;            enable keyboard shortcuts (arrows Left/Right and Esc)
                    quitOnEnd:      false,                  // bool;            quit after viewing the last image
                    quitOnImgClick: false,                  // bool;            quit when the viewed image is clicked
                    quitOnDocClick: true,
                    onEnd: function () {
                        overlayOff();
                        closeButtonOff();
                        activityIndicatorOff();
                        arrowsOff();
                        // navigationOff();
                    },
                    onLoadStart: function () {
                        activityIndicatorOn();
                    },
                    onLoadEnd: function () {
                        $( '.imagelightbox-arrow' ).css( 'display', 'block' );
                        activityIndicatorOff();
                    }
                }
            };

            for (var selector in config) {

                var instance = $(selector).imageLightbox( _.extend({
                    onStart: function () {
                        overlayOn();
                        closeButtonOn(instance);
                        arrowsOn( instance, selector );
                        // navigationOn(instance, selector);
                    }
                }, config[selector]) );
            }
        },

        /**
        * init select2 plugin
        */
        select2Trigger: function () {
            var _this = this,
                config = {
                  '.choice-select' : {
                      language:"es",
                      placeholder:'Seleccione una opción',
                      allowClear: true
                  },
                  '.choice-select-deselect'  : {language:"es", placeholder:'Seleccione una opción', allowClear: true},
                  '.choice-select-nosearch' : {language:"es", placeholder:'Seleccione una opción', minimumResultsForSearch: Infinity},
                  '.choice-select-deselect-nosearch' : {
                      language:"es",
                      placeholder:'Seleccione una opción',
                      allowClear: true,
                      minimumResultsForSearch: Infinity
                  },
                  '.choice-select-no-single' : {},
                  '.choice-select-multiple': {},
                  '.choice-select-autocomplete': {
                    language: "es",
                    allowClear: true,
                    placeholder:'Seleccione una opción',
                    ajax: {
                        delay: 250,
                        data: function (params) {

                            return {
                                q: params.term,
                                page: params.page,
                                list: $(this).data('list'),
                                data: $(this).data('param'),
                                dep: $(this).data('department'),
                                department: $($(this).data('val')).find(":selected").val()
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        escapeMarkup: function (markup) { return markup; },
                        cache: false,
                        minimumInputLength: 1
                    }
                  }
                };

            // Instance selects to choice plugin
            for (var selector in config){

                $(selector).each(function(index, el) {
                    var $el = $(el),
                        parent = $el.closest('.ui-dialog');

                    if (parent.length) {
                        config[selector].dropdownParent = parent;
                    }

                    if( $el.data('select2') == undefined ){
                        $el.select2(config[selector]);

                        $el.on('select2:open', function (evt) {
                            var elSelect = $(evt.target);
                            var w = elSelect.next('.select2-container').css('width');

                            $('.select2-dropdown').css('min-width', w);
                        });

                        // set default option
                        if(selector == '.choice-select-autocomplete') {
                            var initialId = $el.data('initial-value');
                            var $option = null;
                            var $loadOption = null;

                            if(initialId) {
                                var ajaxOptions = $el.data('select2').dataAdapter.ajaxOptions;

                                $loadOption = $('<option selected>Loading...</option>').val(initialId);
                                $el.append($loadOption).trigger('change.select2');

                                $.get( ajaxOptions.url, {dataId:initialId}, function(data) {
                                    $loadOption.remove();
                                    $option = $('<option selected>'+ data[0].text +'</option>').val(data[0].id);
                                    $el.append($option).trigger('change.select2');
                                });
                            }

                            $el.off('select2:unselect')
                            $el.on('select2:unselect', function (event) {
                                var $option = $('<option value="" selected></option>');
                                var $selected = $(event.target);

                                $selected.find('option:selected')
                                .remove()
                                .end()
                                .append($option)
                                .trigger('change.select2');
                            });
                        }
                    }
                });
            }
        },

        /**
        * Trigger Ellipsis plugin config
        */
        configEllipsis: function () {
            var config = {
                '.ellipsis': {}
            };

            for (var selector in config) {
                 $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( $el.data('dotdotdot') == undefined ){
                        $el.dotdotdot(config[selector]);
                    }
                });
            }
        },

        /**
        * Delegate event for open social window
        */
        openSocialWindow: function () {

            $(document).on('click', '.tp_facebook_share, .tp_twitter_share, .tp_linkedin_share', function(a) {
                if (a.preventDefault(), "mobile" == jQuery(this).data("facebook")) FB.ui({
                    method: "share",
                    mobile_iframe: !0,
                    href: jQuery(this).data("href")
                }, function(a) {});
                else if ("email" == jQuery(this).data("site") || "print" == jQuery(this).data("site") || "pinterest" == jQuery(this).data("site")) window.location.href = jQuery(this).attr("href");
                else {
                    var b = 575,
                      c = 520,
                      d = (jQuery(window).width() - b) / 2,
                      e = (jQuery(window).height() - c) / 2,
                      f = "status=1,width=" + b + ",height=" + c + ",top=" + e + ",left=" + d;
                    window.open(jQuery(this).attr("href"), "share", f)
                }
            });
        },

        /**
        * Trigger jquery.inputmask plugin config
        */
        configInputMask: function () {
            Inputmask.extendAliases({
                'currencySubmit': {
                    alias: 'currency',
                    autoUnmask: true,
                    unmaskAsNumber: true,
                    removeMaskOnSubmit: true,
                    allowMinus: false,
                    min: 0,
                    onBeforeMask: function (value, opts) {
                        var processedValue = value || 0;

                        return processedValue;
                    },
                    oncleared: function  (event) {
                        var $input = $(this);

                        if( this.inputmask.unmaskedvalue() == null || isNaN(parseFloat(this.inputmask.unmaskedvalue())) ) {
                            $input.inputmask('setvalue', 0);
                        }
                    },
                    onUnMask: function (maskedValue, unmaskedValue, opts) {
                        if (unmaskedValue === '' && opts.nullable === true) {
                            return unmaskedValue;
                        }

                        var processValue = maskedValue.replace(opts.prefix, "");
                        processValue = processValue.replace(opts.suffix, "");
                        processValue = processValue.replace(new RegExp(Inputmask.escapeRegex(opts.groupSeparator), "g"), "");
                        if (opts.radixPoint !== "" && processValue.indexOf(opts.radixPoint) !== -1) {
                            processValue = processValue.replace(Inputmask.escapeRegex.call(this, opts.radixPoint), ".");
                        }

                        return processValue;
                    }
                }
            });

            var config = {
                '.currency-mask-cop': {
                    radixPoint: ",",
                    groupSeparator: ".",
                    alias: 'currencySubmit',
                    digits: 0
                },
                '.currency-mask-usd': {
                    prefix: "USD ",
                    alias: 'currencySubmit'
                },
                '.ncurrency-mask-cop': {
                    radixPoint: ",",
                    groupSeparator: ".",
                    alias: 'currencySubmit',
                    digits: 0,
                    allowMinus: true,
                    min: null
                },
                '.ncurrency-mask-usd': {
                    prefix: "USD ",
                    alias: 'currencySubmit',
                    allowMinus: true,
                    min: null
                },
                '.phone-mask-co': {
                    // url: window.Misc.urlFull('js/vendor/phone-codes/phone-codes.js'),
                    // alias: 'phone',
                    // countrycode: '57',
                    placeholder: '(___)___-____',
                    mask: '(999)999-9999',
                    clearMaskOnLostFocus: true,
                    removeMaskOnSubmit: true
                },
                '.percentage-mask': {
                    alias: 'percentage',
                    placeholder: '',
                    min: 0,
                    max: null,
                    unmaskAsNumber: true,
                    removeMaskOnSubmit: true,
                    clearMaskOnLostFocus: false,
                    oncleared: function  (event) {
                        var $input = $(this);

                        if( this.inputmask.unmaskedvalue() == null || isNaN(parseFloat(this.inputmask.unmaskedvalue())) ) {
                            $input.inputmask('setvalue', 0);
                        }
                    }
                },
                '.number-mask': {
                    alias: 'decimal',
                    autoGroup: true,
                    radixPoint: ',',
                    groupSeparator: ".",
                    placeholder: '',
                    min: 0,
                    unmaskAsNumber: true,
                    removeMaskOnSubmit: true,
                    clearMaskOnLostFocus: false,
                    oncleared: function  (event) {
                        var $input = $(this);

                        if( this.inputmask.unmaskedvalue() == null || isNaN(parseFloat(this.inputmask.unmaskedvalue())) ) {
                            $input.inputmask('setvalue', 0);
                        }
                    },
                    onUnMask: function (maskedValue, unmaskedValue, opts) {
                        if (unmaskedValue === "" && opts.nullable === true) {
                            return unmaskedValue;
                        }
                        var processValue = maskedValue.replace(opts.prefix, "");
                        processValue = processValue.replace(opts.suffix, "");
                        processValue = processValue.replace(new RegExp(Inputmask.escapeRegex(opts.groupSeparator), "g"), "");
                        if (opts.radixPoint !== "" && processValue.indexOf(opts.radixPoint) !== -1)
                            processValue = processValue.replace(Inputmask.escapeRegex.call(this, opts.radixPoint), ".");

                        return processValue;
                    }
                },
                '.integer-mask': {
                    alias: 'integer',
                    placeholder: '0',
                    autoUnmask: true,
                    min: 0,
                    allowMinus: false,
                    unmaskAsNumber: true,
                    removeMaskOnSubmit: true,
                    clearMaskOnLostFocus: false,
                    oncleared: function  (event) {
                        var $input = $(this);

                        if( this.inputmask.unmaskedvalue() == null || isNaN(parseFloat(this.inputmask.unmaskedvalue())) ) {
                            $input.inputmask('setvalue', 0);
                        }
                    },
                    onUnMask: function (maskedValue, unmaskedValue, opts) {
                        if (unmaskedValue === "" && opts.nullable === true) {
                            return unmaskedValue;
                        }
                        var processValue = maskedValue.replace(opts.prefix, "");
                        processValue = processValue.replace(opts.suffix, "");
                        processValue = processValue.replace(new RegExp(Inputmask.escapeRegex(opts.groupSeparator), "g"), "");
                        if (opts.radixPoint !== "" && processValue.indexOf(opts.radixPoint) !== -1)
                            processValue = processValue.replace(Inputmask.escapeRegex.call(this, opts.radixPoint), ".");

                        return processValue;
                    }
                },
                '.indetification-mask': {
                    alias: 'numeric',
                    autoGroup: true,
                    digits: 0,
                    groupSeparator: "",
                    placeholder: '',
                    min: null,
                    allowMinus: false,
                    allowPlus: false,
                    unmaskAsNumber: true,
                    removeMaskOnSubmit: true
                },
                '.full_year': {
                    mask: '9999',
                    placeholder: 'YYYY',
                    clearMaskOnLostFocus: false
                }
            };

            for (var selector in config){
                $(selector).each(function(index, el) {
                    var $el = $(el);

                    $el.inputmask( config[selector] );
                });
            }
        },

        /**
        * delegate event for copy text
        */
        copyingText: function () {

            var _this = this;

            $(document).on('click', '.activator-selection', function(event) {

                var $activator = $(this);
                var copyTextarea = $activator.next();

                // execute copying text
                _this.selectElementContents( copyTextarea[0], function () {

                    if( $activator.data('tooltip') !== undefined && $activator.data('selector') !== undefined && $activator.hasClass('open') ) {

                        var $elTooltip = $('#'+ $activator.data('selector')),
                            oldTitle = $elTooltip.text();

                        $elTooltip.html('Vínculo copiado al portapapeles<span class="nub"></span>')
                                  .addClass('was-copied');

                        $activator.one('mouseleave.fndtn.tooltip', function (e) {

                            $(this).attr('title', oldTitle);

                            // remove previous tooltip element
                            Foundation.libs.tooltip.getTip($(this)).remove();

                            // create again the tooltip element
                            Foundation.libs.tooltip.create(Foundation.libs.tooltip.S(this));
                        });
                    }
                });
            });
        },

        /**
        * method for select text for a element
        * @param Object|element el
        */
        selectElementContents: function(el, callback) {
            // Copy textarea, pre, div, etc.
            if (document.body.createTextRange) {
                // IE
                var textRange = document.body.createTextRange();
                textRange.moveToElementText(el);
                textRange.select();
                textRange.execCommand("Copy");

                // run callback
                if( typeof callback == 'function' )
                        callback.call();

            }else if (window.getSelection && document.createRange) {
                // non-IE
                var range = document.createRange();
                range.selectNodeContents(el);
                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    console.log('Copy command was ' + msg);

                    // run callback
                    if( typeof callback == 'function' )
                        callback.call();

                } catch(err) {
                    console.log('Oops, unable to copy');
                }
            }
        },

        configUiSlider: function () {

            var _this = this,
                priceFormat = wNumb({
                    mark: ',',
                    thousand: '.',
                    decimals: 0,
                    prefix: '$'
                }),
                pointFormat = wNumb({
                    thousand: '.',
                    decimals: 0,
                    postfix: '/pts.'
                });

            var config = {
                '.range-price': {
                    start: [0, 50000000],
                    connect: true,
                    tooltips: false,
                    step: 100,
                    range: {
                        'min': 0,
                        'max': 50000000
                    },
                    behaviour: 'tap-drag',
                    tooltips: true,
                    format: priceFormat
                },

                '.range-points': {
                    start: [0, 50000000],
                    connect: true,
                    tooltips: false,
                    step: 1,
                    range: {
                        'min': 0,
                        'max': 50000000
                    },
                    behaviour: 'tap-drag',
                    tooltips: true,
                    format: pointFormat
                }
            }

            for (var selector in config){
                $(selector).each(function(index, elRange) {
                    var $elRange = $(elRange);

                    if( !$elRange.hasClass('noUi-target') ) {
                        noUiSlider.create(elRange, config[selector]);

                        // refrest the values for range price
                        if( selector == '.range-price' || selector == '.range-points' ) {

                            $elRange.css('margin-bottom', '25px');

                            var inputsRange = $elRange.data('inputrange').split(',');

                            // get update event to range
                            elRange.noUiSlider.on('slide', function( values, handle ) {

                                if( inputsRange.length > handle ) {

                                    if( $('#'+ inputsRange[handle]).inputmask('hasMaskedValue') ) {
                                        $('#'+ inputsRange[handle]).inputmask('setvalue', priceFormat.from(values[handle]));
                                    }else {
                                        $('#'+ inputsRange[handle]).val( priceFormat.from(values[handle]) );
                                    }

                                    _this.initConfigForm();
                                }
                            });

                            // get change event to inputs
                            if( inputsRange.length ) {

                                var $inputsRange = $( inputsRange.map(function (selectInput) {
                                    return '#'+ selectInput;
                                }).join(',') ).on('keyup input', function (e) {
                                    var setRangeVal = [null, null];

                                    setRangeVal[ inputsRange.indexOf($(this).attr('id')) ] = $(this).inputmask('hasMaskedValue') ? $(this).inputmask('unmaskedvalue') : $(this).val();

                                    elRange.noUiSlider.set(setRangeVal);
                                });

                                // slider reset
                                $inputsRange.closest('form').on('reset', function(event) {

                                    elRange.noUiSlider.set(config[selector].start, false);
                                });
                            }
                        }
                    }
                });
            }
        }
    };

    // Initialize methods immediately
    // ------------------------------
    !(function () {
        var locale = 'es-CO';

        // globalize for internationalization and localization
        // --------------------------------------------------------
        // initialize globalize settings
        // -----------------------------
        Globalize.locale( locale );

        // functions to format by type currency
        window.copCurrency = Globalize.currencyFormatter('COP', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
        window.dolarCurrency = Globalize.currencyFormatter('USD', { minimumFractionDigits: 0, maximumFractionDigits: 2 });

        // extend spinner widget jquery
        extendSpinnerWidget();

        /**
         * format message for institution
         * @param message String
         * @param data Object
         * @param _locale String
         * @return formated message String
         */
        window.formatMessage = function(message, data, _locale) {
            var _Globalize = _locale ? Globalize(_locale) : Globalize;
            var slugInstitution = window.SLUG_INSTITUTION;
            var msgPath = (slugInstitution ? slugInstitution+'/' : '') + message;

            try {
                return _Globalize.formatMessage(msgPath, data);
            }catch(e) {
                return _Globalize.formatMessage(message, data);
            }
        };

        // format with wNumb library
        // -------------------------
        window.copCurrencyF = wNumb({
            mark: ',',
            thousand: '.',
            decimals: 2,
            prefix: '$',
            negativeBefore: '- '
        });
        window.dolarCurrencyF = wNumb({
            mark: '.',
            thousand: ',',
            decimals: 0,
            prefix: 'USD ',
            negativeBefore: '- '
        });
    })();

    /**
    * extends of spinner widget jQuery.ui
    */
    function extendSpinnerWidget() {
        $.widget( "ui.sspinner", $.ui.spinner, {
            options: { culture: window.Globalize ? window.Globalize.cldr.locale : null },

            _create: function(){

                this.hidden = $('<input type="hidden" value="'+ this.element.val() +'" name="'+ this.element.attr('name') +'">'); // Create a hidden input with the same name and value
                this.element.removeAttr('name'); // remove the name of the original element
                this.element.before(this.hidden); // insert the hidden element before the original element
                return this._super();
            },

            _refresh: function() {

                this.hidden.val( this._parse(this.element.val()) );

                return this._super();
            },

            _parse: function( val ) {
                if ( typeof val === "string" && val !== "" ) {
                    val = window.Globalize && this.options.numberFormat ?
                            Globalize(this.options.culture).numberParser()(val) : +val;
                }

                return val === "" || isNaN( val ) ? null : val;
            },

            _format: function( value ) {
                if ( value === "" ) {
                    return "";
                }

                if( window.Globalize && this.options.numberFormat ){

                    this.options.currency || ( this.options.currency = 'COP' );

                    switch( this.options.numberFormat ) {
                        case 'C': return Globalize(this.options.culture).formatCurrency( value, this.options.currency, {minimumFractionDigits: 0, maximumFractionDigits: 10 } ); break;

                        default: return Globalize(this.options.culture).formatNumber( value ); break;
                    }
                }else {
                    return value;
                }
            }
        });

        InitComponent.prototype.spinnerTrigger.call(null);
    }

    // Stop preloader screen
    function stopPreloaderScreen () {
        setTimeout(function(){
            $('body').addClass('loaded');
        }, 100);
    }

    InitComponent.prototype.validateFormForEdit.call(new InitComponent);
    //Init Foundation Plugins
    //-----------------------
    $(document).foundation({
        abide: {
            timeout: 100,
            error_labels: false,
            patterns: {
                'max_char_textarea': /[^\s](.[\n\r]*?){10,}/,
                'min_char_textarea': /[^\s](.[\n\r]*?){10,}/,
                'alpha_numeric_esp': /^[\s\wá-źÁ-Ź]+$/,
                'alpha_dash': /^[a-zA-Z_-]+$/,
                'alpha_num_dash': /^[a-zA-Z0-9_-]+$/,
                'greater_than_zero': /^[1-9]\d*(\.?\d+)?$/,
                'number_positive': /^[0-9]\d*(\.?\d+)?$/,
                'full_year': /[1-9][0-9]{3}/,
                'url_simple': /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+(\/(.)*)?(\?(.)*)?/i,
                'nickname': /^[a-zA-Z0-9_-]{0,15}$/,
                'singleText': /[^\s](.|[\n\r])*/i,
                'longText': /[^\s](.[\n\r]*?)*/i,
                'number_format': /^[-+]?\d+((([,.]{1})\d{3})(\3\d{3})*)*([.,]{1}\d+)?$/,
                'password_valid': /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$¡!#.@:%_\-\*+~=¿?()<>&])([A-Za-z\d$¡!#.@:%_\-\*+~=¿?()<>&]){0,128}$/
            },
            validators: {
                maxLength: function(el, required, parent) {
                    // validate required and patterns again
                    var el_patterns = this.pattern(el),
                        value = el.value.trim(),
                        valid_length = (required) ? (el.value.length > 0) : true,
                        el_validation = true;
                    el_validation = (el_patterns[1].test(value) && valid_length ||
                                        !required && el.value.length < 1 || $(el).attr('disabled')) ? true : false;

                    var $el = $(el),
                        textFld = $el.val(),
                        maxLength = parseInt( $el.data('maxlen') ) || parseInt( $el.attr('length') ),
                        $counter = $el.next('span.count-field-char').length ? $el.next('span.count-field-char') : $('<span>').addClass('count-field-char');

                    if( $el.data('maxlen') != undefined ) {
                        $counter.text( maxLength-textFld.length +' Caracteres' );
                        $counter.insertAfter($el);
                    }

                    return  textFld.length > maxLength || !el_validation ? false : true;
                },
                maxWords: function  (el, required, parent) {
                    // validate required and patterns again
                    var el_patterns = this.pattern(el),
                        value = el.value.trim(),
                        valid_length = (required) ? (el.value.length > 0) : true,
                        el_validation = true;
                    el_validation = (el_patterns[1].test(value) && valid_length ||
                                        !required && el.value.length < 1 || $(el).attr('disabled')) ? true : false;

                    var $el = $(el),
                        textFld = $el.val(),
                        maxLength = parseInt( $el.data('maxlen') ),
                        hasLength = 0,
                        $counter = $el.next('span.count-field-char').length ? $el.next('span.count-field-char') : $('<span>').addClass('count-field-char');

                    hasLength = textFld.length ? window.Misc.trim(textFld.replace(/\s{2,}|\t/g,' ')).split(' ').length : 0;
                    $counter.text( (maxLength-hasLength) +' Palabras' );
                    $counter.insertAfter($el);

                    return  hasLength > maxLength || !el_validation ? false : true;
                },
                onChecked: function(el, required, parent) {
                    var $el = $(el);
                    var checked = 0;

                    if ( $el.is( ":checkbox" ) ) {

                        $( 'input[type="checkbox"][data-relchecks="'+ $el.data('relchecks') +'"]:checked' ).each(function(index, el) {
                            checked++;
                        });

                        // validate associated checks
                        if( checked ){
                            $( 'input[type="checkbox"][data-relchecks="'+ $el.data('relchecks') +'"]' ).parent().removeClass('error');
                        }else {
                            $( 'input[type="checkbox"][data-relchecks="'+ $el.data('relchecks') +'"]' ).parent().addClass('error');
                        }
                    }

                    return checked;
                },
                oneDataMinimun: function (el, required, parent) {
                    var $el = $(el),
                        quantity = 0;

                    $( 'input[data-reldata="'+ $el.data('reldata') +'"]' ).each(function(index, el) {

                        if( $(el).val().length && $(el).data('invalid') == undefined )
                            quantity++;
                    });

                    // validate associated checks
                    if( quantity ){
                        $( 'input[data-reldata="'+ $el.data('reldata') +'"]' ).parent().removeClass('error');
                    }else {
                        $( 'input[data-reldata="'+ $el.data('reldata') +'"]' ).parent().addClass('error');
                    }

                    return quantity;
                },
                requiredOf: function(el, required, parent) {
                    var $el = $(el);

                    var from  = $('#'+ $el.data('requiredof')), //document.getElementById( el.getAttribute(this.add_namespace('data-requiredof')) ).value,
                        to    = $el,
                        valid = from.length ? (from.val().length || from.is(':checked') ? !!(to.val().length || to.is(':checked')) : true) : true;

                    return valid;
                },
                usernameAvailable: function(el, required, parent) {
                    var $el = $(el),
                        label = this.S('label[for="' + el.getAttribute('id') + '"]'),
                        available = $el.data('available'),
                        value = el.value.trim(),
                        el_patterns = this.pattern(el),
                        valid_length = (required) ? (el.value.length > 0) : true,
                        el_validation = el_patterns[1].test(value) ? true : false;

                    available = _.isBoolean(available) ? available : true;
                    var valid = (!el_validation || !valid_length) ? false : available;
                    if(!valid) {
                        $el.addClass('invalid');
                        $el.removeClass('valid');
                    }else{
                        $el.removeClass('invalid');
                        $el.addClass('valid');
                    }
                    return valid;
                }
            }
        },
        accordion: {
            multi_expand: false,
            toggleable: true
        },
        dropdown: {
            opened: function () {
                // Reposition dropdown using jquery.ui position
                var $dropdown = $(this),
                    targetEl = Foundation.libs.dropdown.S(this).data('target');

                var reloadPositions = function ($dropdown, targetEl) {
                    var offsetTop = $dropdown.offset().top,
                        offsetLeft = $dropdown.offset().left;

                    // redefine dropdown arrow
                    if( !$dropdown.hasClass('drop-right') && !$dropdown.hasClass('drop-left') ){

                        // change arrow direction
                        if( Math.round(offsetTop) < Math.round($(targetEl).offset().top) ) {
                            $dropdown.removeClass('drop-left drop-right drop-bottom')
                                     .addClass('drop-top');
                        }else {
                            $dropdown.removeClass('drop-left drop-right drop-top')
                                     .addClass('drop-bottom');
                        }
                    }else {
                        // change arrow direction
                        if( Math.round(offsetLeft) < Math.round($(targetEl).offset().left) ) {
                            $dropdown.removeClass('drop-top drop-right drop-bottom')
                                     .addClass('drop-left');
                        }else {
                            $dropdown.removeClass('drop-left drop-right drop-top')
                                     .addClass('drop-right');
                        }
                    }

                    // invert arrow
                    if( Math.round(offsetLeft) < Math.round($(targetEl).offset().left) ) {
                        $dropdown.addClass('arrow-inverted-left');
                    }else {
                        $dropdown.removeClass('arrow-inverted-left');
                    }
                    if( Math.round(offsetTop) < Math.round($(targetEl).offset().top) ) {
                        $dropdown.addClass('arrow-inverted-top');
                    }else {
                        $dropdown.removeClass('arrow-inverted-top');
                    }

                    // calculate pos at target
                    var gutterTop = $dropdown.hasClass('drop-top') ? parseFloat($dropdown.css('margin-top')) - $dropdown.outerHeight() : parseFloat($dropdown.css('margin-top')),
                        gutterLeft = $dropdown.hasClass('drop-left') ? parseFloat($dropdown.css('margin-left')) - $dropdown.outerWidth() : parseFloat($dropdown.css('margin-left')),
                        posAtHorizontal = $dropdown.hasClass('drop-right') ? 'right' : 'left',
                        posAtVertical = $dropdown.hasClass('drop-bottom') ? 'bottom' : 'top';

                    // set position of the dropdown
                    $dropdown.position({
                        of: targetEl || $dropdown.offsetParent(),
                        my: 'left+'+ gutterLeft +' top+'+ gutterTop,
                        at: posAtHorizontal +' '+ posAtVertical,
                        collision: 'flip'
                    });

                    if( typeof callback == 'function' )
                        callback.call(null, $dropdown, targetEl);
                }

                // redefine dropdown position
                var cloop = 1;
                do {
                    reloadPositions( $dropdown, targetEl );

                }while( ++cloop <= 2 )

                // // redefine dropdown position
                // reloadPositions( $dropdown, targetEl, reloadPositions );
            },
            closed: function () {
                var $dropdown = $(this);

                $dropdown.css('top', '0px');
            }
        }
    });

    // Instance wysiwyg plugin
    window.wysiwygConfig = new window.WysiwygConfig();

    //Init App Components
    //-----------------------
    $(function() {
        window.initComponent = new InitComponent();
        window.initComponent.initialize();

        stopPreloaderScreen();
    });

})(jQuery, this, this.document);

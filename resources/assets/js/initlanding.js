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
        * Constructor or Initialize Method
        */
        initialize: function () {
            // fix error about getAttribute method for comment object dom
            Object.getPrototypeOf(document.createComment('')).getAttribute = function() {}

            //Initialize
            this.initLanding();
            this.initConfigForm();
            this.initAnchor();
            this.configEllipsis();
            this.configSlick();
            this.initModalForm();
            this.autoOpenModal();
            this.configScrollbar();
            this.configSticky();
            this.initModalVideo();
            this.initTabs();
            // this.validateFormForEdit();
            this.chosenTrigger();
            this.select2Trigger();
            // this.initVideoPlayer();
            this.startParallaxScroll();
            this.initCollapsible();
            // override Materialize forms default validation
            window.validate_field = function () {};
        },

        /**
        * Init Landing Backbone Application
        */
        initLanding: function () {
            window.app.LandingRouter.start();
        },

        /**
        *  Init interactive anchor
        */
        initAnchor: function () {
            var config = {
                'anchor-topage' : {
                    'parentDelegate': 'body',//'#wrapper-land',
                    'anchorLink': '.anchor-topage',
                    'duration': 1000,
                    'gutter': -84
                },

                'anchor-tosection' : {
                    'parentDelegate': '.anchors-sub-nav',
                    'anchorLink': '.anchor-tosection',
                    'activation': true,
                    'duration': 1000,
                    'gutter': 0
                }
            };

            for (var selector in config)
                window.Misc.anchorJumpTo( config[selector] );
        },

        /**
        * Trigger Ellipsis plugin config
        */
        configEllipsis: function () {
            var config = {
                '.ellipsis': {}
            };

            for (var selector in config){
                 $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( $el.data('dotdotdot') == undefined ){
                        $el.dotdotdot(config[selector]);
                    }else {
                        $el.trigger("update.dot");
                    }
                });
            }
        },

        /**
        * Trigger Slick plugin config
        */
        configSlick: function () {
            var _this = this,
                config = {
                '.slick-autoslide': {
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: true,
                    autoplaySpeed: 1000,
                    infinite: true,
                    speed: 12000,
                    cssEase: 'linear',
                    arrows: false,
                    pauseOnHover: true,
                    responsive: [
                        {
                            breakpoint: 1441,
                            settings: {
                                slidesToShow: 4
                            }
                        },
                        {
                            breakpoint: 1025,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                speed: 10000
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                speed: 8000
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-autoslide-md': {
                    dots: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '15px',
                    adaptiveHeight: true,
                    responsive: [
                        {
                            breakpoint: 1025,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
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
                    // pauseOnDotsHover: true
                },
                '.slick-news': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 4
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 3
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
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-news-coomeva': {
                    dots: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 4
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 3
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
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-programs': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 2
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
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-events': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 2440,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
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
                    // pauseOnDotsHover: true
                },
                '.slick-carousel-pair': {
                    dots: false,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 2440,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-feature-projects': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1280,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 2,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 1,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                centerPadding: '40px',
                                arrows: false,
                                slidesToShow: 1,
                                dots: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-feature-projects-compensar': {
                    dots: false,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1280,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 2,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 1,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                centerPadding: '40px',
                                arrows: false,
                                slidesToShow: 1,
                                dots: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-tips': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1280,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 2,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                centerPadding: '40px',
                                slidesToShow: 1,
                                arrows: false,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                centerPadding: '40px',
                                arrows: false,
                                slidesToShow: 1,
                                dots: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-content': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: false,
                    asNavFor: '.slick-tabs'
                },

                '.slick-tabs': {
                    dots: false,
                    slidesToShow: 7,
                    slidesToScroll: 1,
                    centerMode: true,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '30px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 6,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerPadding: '20px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '20px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '20px',
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

                '.innpulsa-requirements-slick-tabs': {
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
                    centerPadding: '30px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 5,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerPadding: '20px',
                                centerMode: true,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '20px',
                                centerMode: true,
                                arrows: true
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '80px',
                                centerMode: true,
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
                },

                '.innpulsa-about-slick-tabs': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '30px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4,
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 4,
                                centerPadding: '20px',
                                centerMode: false,
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '40px',
                                centerMode: false,
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '80px',
                                centerMode: true,
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

                '.innpulsa-slick-stats': {
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    pauseOnHover: false,
                    centerMode: true,
                    infinite: true,
                    speed: 2000,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: false,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4,
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                            }
                        }
                    ]
                },

                '.slick-slider-innpulsa-team': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1280,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                centerPadding: '40px',
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                centerPadding: '40px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-content-five-activearrow': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: false,
                    asNavFor: '.slick-tabs-five-activearrow'
                },

                '.slick-tabs-five-activearrow': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '0',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content-five-activearrow',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4
                                // centerMode: true,
                                // infinite: true,
                                // centerPadding: '35px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '30px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '30px'
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '20px'
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

                '.slick-slider-banner': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-slider-coomeva': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-slider-text-btn': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },
                '.slick-programs': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '0px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 2
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
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                '.slick-events': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 2440,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
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
                    // pauseOnDotsHover: true
                },
                '.slick-carousel-pair': {
                    dots: false,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '40px',
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 2440,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 641,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '0px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerPadding: '0px',
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-content': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: false,
                    asNavFor: '.slick-tabs'
                },

                '.slick-tabs': {
                    dots: false,
                    slidesToShow: 7,
                    slidesToScroll: 1,
                    centerMode: true,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: true,
                    centerPadding: '30px',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 6,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerPadding: '20px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerPadding: '20px',
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerPadding: '20px',
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

                '.slick-content-five-activearrow': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: false,
                    asNavFor: '.slick-tabs-five-activearrow'
                },

                '.slick-tabs-five-activearrow': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 350,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '0',
                    adaptiveHeight: false,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-content-five-activearrow',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4
                                // centerMode: true,
                                // infinite: true,
                                // centerPadding: '35px',
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 3,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '30px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '30px'
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                centerMode: true,
                                infinite: true,
                                centerPadding: '20px'
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

                '.slick-slider-banner': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-slider-coomeva': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-slider-text-btn': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'linear',
                    fade:true,
                    arrows: true,
                    adaptiveHeight: true,

                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },
                '.slick-slider-copo': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    adaptiveHeight: false,
                    fade:true,
                    arrows: false,
                    centerPadding: '0px',
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //     breakpoint: 1440,
                        //     settings: {
                        //         slidesToShow: 4
                        //     }
                        // },
                        // {
                        //     breakpoint: 1200,
                        //     settings: {
                        //         slidesToShow: 3
                        //     }
                        // },
                        // {
                        //     breakpoint: 980,
                        //     settings: {
                        //         slidesToShow: 2,
                        //         centerPadding: '0px'
                        //     }
                        // },
                        // {
                        //     breakpoint: 640,
                        //     settings: {
                        //         slidesToShow: 1,
                        //         centerPadding: '0px',
                        //         arrows: false
                        //     }
                        // }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-carousel-content-testimonial-copo': {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    adaptiveHeight: true,
                    speed: 200,
                    asNavFor: '.slick-carousel-testimonial-copo'
                },

                '.slick-carousel-testimonial-copo': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    centerMode: false,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    infinite: false,
                    speed: 500,
                    cssEase: 'ease',
                    arrows: false,
                    centerPadding: '0',
                    adaptiveHeight: true,
                    variableWidth: false,
                    verticalSwiping: true,
                    asNavFor: '.slick-carousel-content-testimonial-copo',
                    focusOnSelect: true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 980,
                            settings: {
                               arrows: false
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                               slidesToShow: 1,
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                               slidesToShow: 1,
                            }
                        },
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-copo-emprendimiento-news': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>'
                    // responsive: [
                    //     {
                    //         breakpoint: 640,
                    //         settings: {
                    //             arrows: false
                    //         }
                    //     },
                    //     {
                    //         breakpoint: 480,
                    //         settings: {
                    //             arrows: false
                    //         }
                    //     }
                    // ]
                },

                '.slick-copo-emprendimiento-partners': {
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    centerMode: false,
                    infinite: true,
                    speed: 300,
                    cssEase: 'ease',
                    arrows: false,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    pauseOnHover: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                               slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                               slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                               slidesToShow: 4
                            }
                        }
                    ]
                },
                    '.slick-slider-bolivar': {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        adaptiveHeight: true,
                        autoplay: true,
                        autoplaySpeed: 3500,
                        arrows: false,
                        // pauseOnDotsHover: true
                    },
                    '.slick-slider-bolivar2': {
                        dots: false,
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        arrows: false,
                        autoplay: true,
                        autoplaySpeed: 4500,
                        responsive: [
                             {
                               breakpoint: 980,
                                settings: {
                                   slidesToShow: 1,
                                    slidesToScroll: 1,
                                   dots:false
                                }

                             },
                            {
                                breakpoint: 640,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    dots:false
                                }
                            }
                            // You can unslick at a given breakpoint now by adding:
                            // settings: "unslick"
                            // instead of a settings object
                        ]
                        // pauseOnDotsHover: true
                    },


                '.slick-slider-terpel': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 14000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    adaptiveHeight: false,
                    fade:true,
                    arrows: true,
                    centerPadding: '0px',
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //     breakpoint: 1440,
                        //     settings: {
                        //         slidesToShow: 4
                        //     }
                        // },
                        // {
                        //     breakpoint: 1200,
                        //     settings: {
                        //         slidesToShow: 3
                        //     }
                        // },
                        // {
                        //     breakpoint: 980,
                        //     settings: {
                        //         slidesToShow: 2,
                        //         centerPadding: '0px'
                        //     }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-slider-images-dinamiza': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2500,
                    pauseOnHover: false,
                    centerMode: false,
                    infinite: true,
                    speed: 2500,
                    cssEase: 'ease',
                    adaptiveHeight: false,
                    fade: true,
                    arrows: false,
                    centerPadding: '0px',
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-slider-default': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    pauseOnHover: false,
                    centerMode: false,
                    infinite: true,
                    speed: 1000,
                    cssEase: 'ease',
                    adaptiveHeight: false,
                    fade:true,
                    arrows: false,
                    centerPadding: '0px',
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //     breakpoint: 1440,
                        //     settings: {
                        //         slidesToShow: 4
                        //     }
                        // },
                        // {
                        //     breakpoint: 1200,
                        //     settings: {
                        //         slidesToShow: 3
                        //     }
                        // },
                        // {
                        //     breakpoint: 980,
                        //     settings: {
                        //         slidesToShow: 2,
                        //         centerPadding: '0px'
                        //     }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-testimonial-dinamiza': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    centerMode: false,
                    infinite: true,
                    speed: 500,
                    pauseOnHover:false,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                arrows: false,
                                dots: false
                            }
                        }
                    ]
                },

                '.slick-convocatorias-dinamiza': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-events-dinamiza': {
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-stats-dinamiza': {
                    dots: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    pauseOnHover: false,
                    centerMode: true,
                    infinite: true,
                    speed: 2000,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: false,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                        {
                            breakpoint: 1440,
                            settings: {
                                slidesToShow: 4,
                            }
                        },
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                            }
                        }
                    ]
                },

                '.slick-dinamiza-partners': {
                    dots: false,
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 0,
                    pauseOnHover: true,
                    centerMode: true,
                    infinite: true,
                    speed: 2000,
                    cssEase: 'linear',
                    arrows: false,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object

                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                            }
                        },
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 4,
                            }
                        }
                    ]
                },
                '.slick-slider-innpulsa-2020': {
                    dots: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    arrows: false,
                    autoplay: false,
                    responsive: [
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }

                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },

                '.slick-slider-testimonial': {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false,
                                adaptiveHeight: true
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                adaptiveHeight: true
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },

                '.slick-carousel-team': {
                    dots: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 6000,
                    centerMode: false,
                    infinite: true,
                    speed: 350,
                    cssEase: 'ease',
                    // fade: true,
                    arrows: true,
                    adaptiveHeight: false,
                    verticalSwiping: false,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>',
                    responsive: [
                        // {
                        //  breakpoint: 1440,
                        //  settings: {
                        //      slidesToShow: 8
                        //  }
                        // },
                        // {
                        //  breakpoint: 1200,
                        //  settings: {
                        //      slidesToShow: 6,
                        //      arrows: false
                        //  }
                        // },
                        // {
                        //  breakpoint: 980,
                        //  settings: {
                        //      slidesToShow: 3,
                        //      centerPadding: '20px',
                        //      arrows: false
                        //  }
                        // },
                        {
                            breakpoint: 640,
                            settings: {
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                },
                '.slick-slider-cenisoft-events': {
                    dots: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    arrows: true,
                    autoplay: false,
                    responsive: [
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }

                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                    // pauseOnDotsHover: true
                },
                    '.slick-slider-mentorias': {
                        vertical: true,
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        autoplay: true,
                        responsive: [
                            {
                                breakpoint: 980,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }

                            },
                            {
                                breakpoint: 640,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                            // You can unslick at a given breakpoint now by adding:
                            // settings: "unslick"
                            // instead of a settings object
                        ]
                        // pauseOnDotsHover: true
                    },
                    '.slick-slider-cenisoft-news': {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        adaptiveHeight: true,
                        autoplay: false
                        // pauseOnDotsHover: true
                    },
                    '.slick-slider1-innpulsa-landing2020': {
                        dots: false,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        adaptiveHeight: true,
                        autoplay: true,
                        autoplaySpeed: 6000,
                        prevArrow: '<button type="button" class="prev show-for-tablet-up" style="transform: translateY(-100px);background: transparent;\color: #162761;"><i class="mdi mdi-arrow-left mdi-36px"></i></button>',
                        nextArrow: '<button type="button" class="next show-for-tablet-up" style="transform: translateY(-170px);background: transparent;\color: #162761;margin-left: 160px;"><i class="mdi mdi-arrow-right mdi-36px"></i></button>',
                        responsive: [
                            {
                                breakpoint: 500,
                                arrows: false
                            }
                        ]
                        // pauseOnDotsHover: true
                    },
                    '.slick-slider2-innpulsa-landing2020': {
                        dots: true,
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        arrows: false,
                        infinite: true,
                        adaptiveHeight: true,
                        autoplay: true,
                        autoplaySpeed: 6000

                        // pauseOnDotsHover: true
                    },
                    '.slick-slider3-innpulsa-landing2020': {
                        dots: true,
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        arrows: false,
                        infinite: true,
                        adaptiveHeight: true,
                        autoplay: true,
                        autoplaySpeed: 6000,
                        responsive: [
                            {
                                breakpoint: 980,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 2,
                                    arrows: true
                                }

                            },
                            {
                                breakpoint: 640,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    arrows: true
                                }
                            }
                            // You can unslick at a given breakpoint now by adding:
                            // settings: "unslick"
                            // instead of a settings object
                        ]

                        // pauseOnDotsHover: true
                    },
                    '.slick-slider-innpulsa2020': {
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 14000,
                        centerMode: false,
                        infinite: true,
                        speed: 350,
                        cssEase: 'ease',
                        adaptiveHeight: false,
                        fade:true,
                        arrows: true,
                        centerPadding: '0px',
                        verticalSwiping: false,
                        prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                        nextArrow: '<button type="button" class="slick-next">Next</button>',
                        responsive: [
                            // {
                            //     breakpoint: 1440,
                            //     settings: {
                            //         slidesToShow: 4
                            //     }
                            // },
                            // {
                            //     breakpoint: 1200,
                            //     settings: {
                            //         slidesToShow: 3
                            //     }
                            // },
                            // {
                            //     breakpoint: 980,
                            //     settings: {
                            //         slidesToShow: 2,
                            //         centerPadding: '0px'
                            //     }
                            // },
                            {
                                breakpoint: 640,
                                settings: {
                                    arrows: false
                                }
                            }
                            // You can unslick at a given breakpoint now by adding:
                            // settings: "unslick"
                            // instead of a settings object
                        ]
                        // pauseOnDotsHover: true
                    },

            };

            for (var selector in config) {
                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( !$el.hasClass('slick-initialized') ){
                        $el.slick(config[selector]);
                        $el.on('setPosition', function(event, slick) {

                            // trigger ellipsis
                            _this.configEllipsis();
                        });

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

                            $el.on('afterChange', function (slick, currentSlide) {
                                var $currentTab = currentSlide.$slides.eq(currentSlide.currentSlide);

                                $(document).foundation('tab', 'toggle_active_tab', $currentTab);
                            });
                        }
                    }
                });
            }
        },

        /**
        *  auto open modal
        */
        autoOpenModal: function () {
            $('.modal-land[data-openauto]').each(function(index, el) {
                var $el = $(el);
                $el.foundation('reveal','open');
            });
        },

        /**
        * Init Scrollbar plugin
        */
        configScrollbar: function () {
            var config = {
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
                    suppressScrollX: false
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
        * Init sticky plugin
        */
        configSticky: function () {
            var config = {
                '.sticky-top-menu': {
                    wrapperClassName: 'sticky-wrapper-topmenu',
                    getWidthFrom: $('#header-land'),
                    topSpacing: 0
                },
                '.sticky-sub-nav': {
                    wrapperClassName: 'sticky-wrapper-subnav',
                    getWidthFrom: $('#destapafuturo-navmenu'),
                    responsiveWidth: true,
                    topSpacing: 0
                },
                '.sticky-sub-nav-reb': {
                    wrapperClassName: 'sticky-wrapper-subnav',
                    getWidthFrom: $('#reb-navmenu'),
                    responsiveWidth: true,
                    topSpacing: 0
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

                    if( !$el.parent().hasClass('is-sticky') ){
                        $el.sticky( settings );

                        // handler events
                        if(selector == '.sticky-top-menu') {
                            $( window ).scroll(function() {
                                if( $el.offset().top > 100 ) {
                                    $el.addClass('sticky-menu-limit');
                                }else {
                                    $el.removeClass('sticky-menu-limit');
                                }
                            });
                        }

                        if( $el.hasClass('sticky-sub-nav') ) {
                            $el.off('sticky-start');
                            $el.off('sticky-end');
                            $el.on('sticky-start', function() {
                                $el.find('.opts-action-subnav').removeClass('hidedark');
                            });
                            $el.on('sticky-end', function() {
                                $el.find('.opts-action-subnav').addClass('hidedark');
                            });
                        }
                    }
                });
            }
        },

        /**
        * init event handlers for modal video
        */
        initModalVideo: function () {
            var _this = this;

            $(document).on('opened.fndtn.reveal', '[data-reveal]#modal-video-landing', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this);
                _this.initVideoPlayer();

                if( $modal.hasClass('full') ){
                    $('body').css('overflow', 'hidden');
                }
            });

            $(document).on('close.fndtn.reveal', '[data-reveal]#modal-video-landing', function (event) {

                if(event.namespace != 'fndtn.reveal') return;

                var $modal = $(this);

                _this.playerVideoLand.pause();
                _this.playerVideoLand.remove();

                $('body').css('overflow', 'auto');
            });
        },

        /**
        * init tab config
        */
        initTabs: function () {

            $('[data-tab].tabs-route, [data-tab].tabs-progress-bar').off('toggled');
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
        * init video player
        */
        initVideoPlayer: function () {

            this.playerVideoLand = new MediaElementPlayer('#player-video-landing', {
                pluginPath: window.Misc.urlFull('js/vendor/'),
                plugins: ['flash','silverlight','youtube','vimeo'],
                enablePluginDebug: true,
                alwaysShowControls: true,
                videoVolume: 'horizontal',
                features: ['playpause','volume','current','duration','progress','fullscreen'],
                success: function (media, element) {
                    media.play();
                }
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

            // Render Materialize field form
            Materialize.updateTextFields();
            $('select').material_select();
            $('input[data-abide-validator*=maxLength], textarea[data-abide-validator*=maxLength], input[length], textarea[length]').characterCounter();

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
        * init select2 plugin
        */
        select2Trigger: function () {
            var _this = this,
                config = {
                  '.choice-select' : {language:"es", placeholder:'Seleccione una opción'},
                  '.choice-select-deselect'  : {language:"es", placeholder:'Seleccione una opción', allowClear: true},
                  '.choice-select-no-single' : {},
                  '.choice-select-multiple': {},
                  '.choice-select-autocomplete': {
                    language: "es",
                    placeholder:'Seleccione una opción',
                    ajax: {
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        escapeMarkup: function (markup) { return markup; },
                        cache: true,
                        minimumInputLength: 1
                    }
                  }
                };

            // Instance selects to choice plugin
            for (var selector in config){

                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( $el.data('select2') == undefined ){
                        $el.select2(config[selector]);
                    }
                });
            }
        },

        /**
        * Parallax scrolling
        */
        startParallaxScroll: function () {

            $(window).stellar({
                horizontalScrolling: false,
                responsive: true
            });
        },

        /**
        * Collapsible
        *
        */
        initCollapsible: function () {
            $('.collapsible').collapsible();
        }
    };

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
                'nickname': /^[a-zA-Z0-9\._-]{0,15}$/,
                'singleText': /[^\s](.|[\n\r])*/i,
                'longText': /[^\s](.[\n\r]*?)*/i,
                'number_format': /^[-+]?\d+((([,.]{1})\d{3})(\3\d{3})*)*([.,]{1}\d+)?$/
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
                }
            }
        },
        accordion: {
            multi_expand: false,
            toggleable: true
        },
        dropdown: {
            opened: function() {
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
            closed: function  () {
                var $dropdown = $(this);

                $dropdown.css('top', '0px');
            }
        },

        "magellan-expedition": {
            destination_threshold: 0,
            throttle_delay: 0
        }
    });

    //Init App Components
    //-----------------------
    $(function() {
        window.initComponent = new InitComponent();
        window.initComponent.initialize();
    });

})(jQuery, this, this.document);

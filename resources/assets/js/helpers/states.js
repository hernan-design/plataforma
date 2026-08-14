// parametrization file
// --------------------

(function () {

    var _tp = (function () {
        return {
            getState: {
                'progress': 1,
                'review': 2,
                'cancelled': 3,
                'live': 4,
                'correction': 5,
                'confirm': 6,
                'confirmed': 7,
                'active': 8,
                'inactive': 9,
                'feedback': 10,
                'complete': 11,
                'qualified': 12,
                'removed': 13,
                'pending': 14,
                'evaluated': 15,
                'closed': 16,
                'rejected': 25,
                'returned': 26,
                'finalized': 29,
                'to_finalize': 30,
                'review_deliverables': 32,
                'rejection_of_deliverables': 33,
                'pending_accept': 34
            },

            getModule: function (module) {
                var moduleTypes = {
                    'forum': 1,
                    'wall': 2,
                    'header': 3,
                    'banner': 4,
                    'sitemap': 7,
                    'projects': 9,
                    'calendar': 13,
                    'blog': 14,
                    'mentoring': 20,
                    'surveys': 21,
                    'users': 22,
                    'teams': 23,
                    'learn': 24,
                    'marketplace': 25,
                    'calls': 26,
                    'discussion': 27,
                    'register': 29,
                    'comment': 31,
                    'agreements': 52,
                    'phases': 53
                };

                return moduleTypes[module];
            },

            getResource: function (resource) {
                var resourceType = {
                    'foro.gestion': 1,
                    'foro.comentario': 2,
                    'muro.gestion': 3,
                    'muro.comentario': 4,
                    'mentoria.gestion': 6,
                    'mentoria.comentario': 5,
                    'proyectos.gestion': 7,
                    'proyectos.comentario': 8,
                    'blog.gestion': 9,
                    'blog.comentario': 10,
                    'discusion.gestion': 11,
                    'discusion.comentario': 12,
                    'producto.gestion': 13,
                    'convocatoria.gestion': 14,
                    'eventos.gestion': 15,
                    'aprende.gestion': 16
                };

                return resourceType[resource];
            },

            typeEvent: {
                'mentoring': 1,
                'call': 2,
                'meeting': 3,
                'conference': 4,
                'diplomat': 5,
                'festival': 6,
                'forum': 7,
                'networking': 8,
                'seminary': 9,
                'workshop': 10,
                'symposium': 11,
                'webinar': 12,
                'program': 13
            },

             getClassTypeEvent: {
                'user': 1,
                'platform': 2
            },

            thumbs: {
                'avatar': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-user-image.svg';
                },
                'global': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-image.svg';
                },
                'creditCards': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/general/aprende-payment-cards.png';
                },
                'cvv': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/general/aprende-payment-card-2.png';
                },
                'preloadEntry': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/wall-post-basic-content-loader.svg';
                },
                'preloadItem': function () {
                    return 'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/wall-general-content-loader.svg';
                }
            },

            product: {
                'class' : {
                    'product': 1,
                    'reward': 2
                }
            },

            getClassEntrepreneurship: {
                'idea': 1,
                'entrepreneurship': 2,
                'group': 3,
                'company': 4,
                'grouptwo': 5
            },

            getPhases: {
		        'general': 1,
		        'one_challenge': 134,
		        'two_challenge': 137,
		        'three_challenge': 138,
		        'four_challenge': 139,
				'challenge_1.2': 150,
				'empodera2020_two':250,
                'aldea_20__challenge_1_3': 255
		    },

		    getProgram: {
				'invitation_entrepreneurs': 113,
				'empodera': 198,
				'empodera2020': 471 ,
                'specialized_service_advisors': 185,
		        'club_best': 115,
		        'award_innova': 121,
				'participants_only': 122,
				'register': 196,
                'reg_mentores_provedores': 350,
                'reg_entidades_provedores': 351
		    },


            getTypeAttached: {
                'pdf': 1,
                'youtube': 2,
                'flash': 3,
                'vimeo': 4,
                'html': 5,
                'imagen': 6,
                'gallery': 7,
                'link':8,
                'survey':9
            },

            getIconTypeAttachment: {
                1: 'mdi mdi-file',
                2: 'mdi mdi-play-circle-outline',
                3:'mdi mdi mdi-flash',
                4: 'mdi mdi-play-circle-outline',
                5: 'mdi mdi-language-html5',
                6:'mdi mdi-file-image',
                7:'mdi mdi-file-image',
                8: 'mdi mdi-link-variant',
                9: 'mdi mdi-format-list-checks'
            },

            docAttached: {
                'image': 5,
                'curriculum': 10
            },

            typePart: {
                'seller': 1,
                'purchaser': 2
            },

            typeUser: {
                'person': 1,
                'entity': 2
            },

            typeProgram: {
                'internal': 1,
                'external': 2
            },

            getRole: {
				'admin': 2,
                'mentor': 7,
                'seller': 14
            },

            orientationProgram: {
                'entity': 1,
                'user': 2
            },

            getOrientationSpace: {
                'user': 1,
                'project': 2
            },

            inDocs: [
                'pdf',
                'doc',
                'docx',
                'xls',
                'xlsx',
                'ppt',
                'pptx'
            ],

            inVideos: [
                'swf',
                'flash',
                'youtube',
                'vimeo',
                'html',
                'mp4',
                'webm',
                'ogg',
                '3gp',
                'flv'
            ],

            typeQuestionSurvey: {
                'open': 1,
                'single': 2,
                'multiple': 3,
                'upload': 4,
                'matriz': 5
            },

            classQuestionSurvey: {
                'visible': 1,
                'hidden': 2
            },

            typeQuestionField: {
                'singleText': 1,
                'longText': 2,
                'number_format': 3,
                'full_year': 4,
                'cities': 5,
                'pass_confirm': 6,
                'agree_terms': 7,
                'email': 8,
                'url': 9,
                'url_simple': 10,
                'image': 11,
                'image_multiple': 12,
                'attachment': 13,
                'date': 14,
                'select': 15,
                'ciiu': 16,
                'education_level': 17,
                'economic_sector': 18,
                'currency': 19,
                'single_check': 20,
                'multiple_check': 21,
                'phone': 22,
                'percentage': 23,
                'integer': 24,
                'identification': 25,
                'before_date': 26,
                'negative_currency': 27
            },

            getInstitution: {
                'terpel': 37,
                'ecopetrol': 53,
                'innpulsa':51,
                'dinamiza':69,
                'cenisoft': 46,
                'compensar': 30
            },

            typeNotify: {
                'general': 1,
                'friendship': 2,
                'like': 3,
                'favorite': 4,
                'discussion': 5
            },

            getTypePayment: {
                'accord' : 1,
                'voucher': 2
            },

            currencyMasks : {
                'cop': 'currency-mask-cop',
                'usd': 'currency-mask-usd'
            },

            ncurrencyMasks : {
                'cop': 'ncurrency-mask-cop',
                'usd': 'ncurrency-mask-usd'
            },

            typeItemMentoring: {
                'mentor': 1,
                'entrepreneurship': 2
            },

            typeItemEvaluation: {
                'select': 1,
                'boolean': 2,
                'stars': 3,
                'upload': 4,
                'textarea': 5,
                'checkbox': 6,
            },

            typePrivacy: {
                'private': 1,
                'public': 2
            },

            classProduct: {
                'product': 1,
                'reward': 2,
                'service': 3
            },

            modalityProduct: {
                'virtual': 1,
                'blended': 2,
                'presential': 3
            },

            levelEducation: {
                'other': 7,
                'baccalaureate': 8
            },

            messages: {
                typeError: '{file} tiene una extensión inválida. Extensiones válidas {extensions}.',
                sizeError: "{file} es demasiado grande, el tamaño máximo de archivo es {sizeLimit}.",
                minSizeError: "{file} es demasiado pequeño, el tamaño mínimo de archivo es {minSizeLimit}.",
                emptyError: "{file} está vacío, por favor seleccione los archivos nuevamente sin él.",
                noFilesError: "No hay archivos para cargar",
                tooManyItemsError: "Demasiados artículos ({netItems}) sería cargado. Límite de artículo es {itemLimit}.",
                maxHeightImageError: 'La imagen es muy alta.',
                maxWidthImageError: "La imagen es muy amplia.",
                minHeightImageError: "La imagen no es lo suficientemente alta",
                minWidthImageError: "La imagen no es lo suficientemente amplia",
                retryFailTooManyItems: "Error de reintentos - ha alcanzado el límite de su archivo.",
                onLeave: "Los archivos se cargan, si se va ahora, la carga se cancelará.",
                unsupportedBrowserIos8Safari: "Error irrecuperable: este navegador no permite la carga de archivos de ningún tipo debido a errores graves en iOS8 Safari. Utilice iOS8 Chrome hasta que Apple resuelva estos problemas."
            },

            text: {
                fileInputTitle: 'Carga un archivo',
                failUpload: 'La carga falló',
                paused: 'Pausado',
                waitingForResponse: 'Procesando...'
            },

            getTypeID: {
                'cc': 1,
                'ce': 2,
                'nit': 3,
                'ti': 4,
                'p': 5,
                'rc': 6,
                'nui': 7
            },

            getTypeSpecialty: {
                'other': 16
            },

            getTypePromo: {
                promotion: 1,
                advertisement: 2
            },

            confirmMessage: "Estás seguro de que quieres eliminar {filename}?"
        };

    }).call(this);


    /**
    * Expose the class either via AMD, CommonJS or the global object
    */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return _tp;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = exports.default = _tp;
    }
    else {
        window._tp = _tp;
    }

}).call(this);

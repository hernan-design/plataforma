/**
* Class WysiwygConfig
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

(function ($, window, document, undefined) {

	window.WysiwygConfig = function (setConfig, setElement) {
		// Init Attributes
		this.initialize(setConfig, setElement);
	}

	window.WysiwygConfig.prototype = {

		/**
		* Constructor Method
		* @param String setConfig
		* @param Mixin setElement
		*/
		initialize: function (setConfig, setElement) {
			setConfig || (setConfig = null);
			setElement || (setElement = null);

			var config = {
				'.wysiwyg-postwall': {
					'class': 'wrap-wysiwyg-postwall',
					toolbar: 'bottom',
					configButtons: {
						otroBoton: {
							title: 'Nombrar a alguien',
							image: '\uf007',
							click: function( $button ) {
								alert('Do something');
							},
							showselection: false  // wanted on selection
						},
						insertimage: {
							title: 'Insertar imagen', //Insert image
							image: '\uf03e',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						insertlink: false,
						fontname: false,
						fontsize: false,
						header: false,
						bold: false,
						italic: false,
						underline: false,
						strikethrough: false,
						forecolor: false,
						highlight: false,
						alignleft: false,
						aligncenter: false,
						alignright: false,
						alignjustify: false,
						subscript: false,
						superscript: false,
						indent: false,
						outdent: false,
						orderedList: false,
						unorderedList: false,
						removeformat: false
					}
				},

				'.wysiwyg-single': {
					'class': 'wrap-wysiwyg-single',
					toolbar: 'bottom-selection',
					configButtons: {
						insertimage: false,
						fontname: false,
						fontsize: false,
						header: false,
						forecolor: false,
						highlight: false,
						subscript: false,
						superscript: false,
						strikethrough: false
					}
				},

				'.wysiwyg-single-without-link': {
					'class': 'wrap-wysiwyg-single-without-link',
					toolbar: 'bottom-selection',
					configButtons: {
						insertimage: false,
						insertlink: false,
						fontname: false,
						fontsize: false,
						header: false,
						forecolor: false,
						highlight: false,
						subscript: false,
						superscript: false,
						strikethrough: false
					}
				},

				'.wysiwyg-basic': {
					'class': 'wrap-wysiwyg-basic',
					toolbar: 'bottom-selection',
					configButtons: {
						insertimage: false,
						fontname: false,
						fontsize: false,
						header: false,
						bold: false,
						italic: false,
						underline: false,
						strikethrough: false,
						forecolor: false,
						highlight: false,
						alignleft: false,
						aligncenter: false,
						alignright: false,
						alignjustify: false,
						subscript: false,
						superscript: false,
						indent: false,
						outdent: false
					}
				}
			};

			if( setConfig !== null && setConfig.length && setElement !== null ) {
				this._setWysiwyg(setElement, config[setConfig]);
				return;
			}

			for( var selector in config ){

				var _config = {};
				_config = $.extend({}, _config, config[selector]);

				this._setWysiwyg(selector, _config);
			}
		},

		/**
		* Set wysiwyg
		* @param mixin selector
		* @param Object _config
		*/
		_setWysiwyg: function (selector, _config) {

			if( !selector || !selector.length || !_config || !_.isObject(_config) )
				return false;

			$(selector).each(function(index, element) {
				var setButtons = {
						insertimage: {
							title: 'Insertar imagen', //Insert image
							image: '\uf030',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						insertlink: {
							title: 'Insertar link', //Insert Link
							image: '\uf08e'
						},
						// Fontname plugin
						fontname: {
						    title: 'Fuente', //Font
						    image: '\uf031',
						    popup: function ( $popup, $button ) {

						        var list_fontnames = {
						                // Name : Font
						                'Arial, Helvetica' : 'Arial,Helvetica',
						                'Verdana'          : 'Verdana,Geneva',
						                'Georgia'          : 'Georgia',
						                'Courier New'      : 'Courier New,Courier',
						                'Times New Roman'  : 'Times New Roman,Times'
						            };

						        var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
						                               .attr('unselectable','on');

						        $.each( list_fontnames, function( name, font ){
						            var $link = $('<a/>').attr('href','#')
						                                .css( 'font-family', font )
						                                .html( name )
						                                .click(function(event){
						                                    $(element).wysiwyg('shell').fontName(font).closePopup();
						                                    // prevent link-href-#
						                                    event.stopPropagation();
						                                    event.preventDefault();
						                                    return false;
						                                });
						            $list.append( $link );
						        });

						        $popup.append( $list );
						    },
						    //showstatic: true,    // wanted on the toolbar
						    showselection: false // wanted on selection
						},
						// Fontsize plugin
						fontsize: {
						    title: 'Tamaño', //Size
						    image: '\uf034',
						    popup: function( $popup, $button ) {
						        var list_fontsizes = {
						            // Name : Size
						            'Enorme'       : 7, //Huge
						            'Más Grande'   : 6, //Larger
						            'Grande'       : 5, //Large
						            'Normal'       : 4,
						            'Pequeño'      : 3, //Small
						            'Más pequeñas' : 2, //Smaller
						            'Diminuto'     : 1  //Tiny
						        };
						        var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
						                               .attr('unselectable','on');
						        $.each( list_fontsizes, function( name, size ){
						            var $link = $('<a/>').attr('href','#')
						                                .css( 'font-size', (8 + (size * 3)) + 'px' )
						                                .html( name )
						                                .click(function(event){
						                                    $(element).wysiwyg('shell').fontSize(size).closePopup();
						                                    // prevent link-href-#
						                                    event.stopPropagation();
						                                    event.preventDefault();
						                                    return false;
						                                });
						            $list.append( $link );
						        });
						        $popup.append( $list );
						   }
						    //showstatic: true,    // wanted on the toolbar
						    //showselection: true    // wanted on selection
						},
						// Header plugin
						header: {
						    title: 'Titular', //Header
						    image: '\uf1dc',
						    popup: function( $popup, $button ) {
						        var list_headers = {
						                // Name : Font
						                'Titular 1'    : '<h1>', //Header
						                'Titular 1'    : '<h2>',
						                'Titular 3'    : '<h3>',
						                'Titular 4'    : '<h4>',
						                'Titular 5'    : '<h5>',
						                'Titular 6'    : '<h6>',
						                'Preformateada' : '<pre>' //Preformatted
						            };
						        var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
						                               .attr('unselectable','on');
						        $.each( list_headers, function( name, format ){
						            var $link = $('<a/>').attr('href','#')
						                                 .css( 'font-family', format )
						                                 .html( name )
						                                 .click(function(event){
						                                    $(element).css({'color': '#000'})
						                                            .wysiwyg('shell').format(format).closePopup();
						                                    // prevent link-href-#
						                                    event.stopPropagation();
						                                    event.preventDefault();
						                                    return false;
						                                });
						            $list.append( $link );
						        });
						        $popup.append( $list );
						   }
						    //showstatic: true,    // wanted on the toolbar
						    //showselection: false    // wanted on selection
						},
						bold: {
							title: 'Negrita (Ctrl+B)', //Bold
							image: '\uf032',
							hotkey: 'b'
						},
						italic: {
							title: 'Italica (Ctrl+I)', //Italic
							image: '\uf033',
							hotkey: 'i'
						},
						underline: {
							title: 'Subrayar (Ctrl+U)', //Underline
							image: '\uf0cd',
							hotkey: 'u'
						},
						strikethrough: {
							title: 'Tachado (Ctrl+S)', //Strikethrough
							image: '\uf0cc',
							hotkey: 's'
						},
						forecolor: {
							title: 'Color de texto', //Text color
							image: '\uf1fc'
						},
						highlight: {
							title: 'Color de fondo', //Background color
							image: '\uf043'
						},
						alignleft: {
							title: 'Alinear a la izquierda', //Left
							image: '\uf036',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						aligncenter: {
							title: 'Alinear al centro', //Center
							image: '\uf037',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						alignright: {
							title: 'Alinear a la derecha', //Right
							image: '\uf038',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						alignjustify: {
							title: 'Justificar', //Justify
							image: '\uf039',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						subscript: {
							title: 'Subíndice', //Subscript
							image: '\uf12c',
							//showstatic: true,    // wanted on the toolbar
							showselection: true    // wanted on selection
						},
						superscript: {
							title: 'Superíndice', //Superscript
							image: '\uf12b',
							//showstatic: true,    // wanted on the toolbar
							showselection: true    // wanted on selection
						},
						indent: {
							title: 'Indentar', // Indent
							image: '\uf03c',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						outdent: {
							title: 'Sin Indentar', //Outdent
							image: '\uf03b',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						orderedList: {
							title: 'Lista Ordenada', //Ordered list
							image: '\uf0cb',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						unorderedList: {
							title: 'Lista Desordenada', //Unordered list
							image: '\uf0ca',
							//showstatic: true,    // wanted on the toolbar
							showselection: false    // wanted on selection
						},
						removeformat: {
							title: 'Retirar Formato', //Remove format
							image: '\uf12d'
						}
					},
					buttonsExtend = $.extend({}, setButtons, _config.configButtons ),
					defaults = {
						'class': 'some-more-classes',
						toolbar: 'top-selection',
						dropfileclick: 'Drop image or click',
						placeholderUrl: 'www.example.com',
						maxImageSize: [600,200],
						 // Submit-Button
						submit: {
							title: 'Submit',
							image: '\uf00c' // <img src="path/to/image.png" width="16" height="16" alt="" />
						},
						buttons: buttonsExtend
						// onImageUpload: this.onImageUpload,
						// onKeyEnter: function (argument) {
						//     console.log('llega', argument);
						// }
					};

				// extend defautl settings with the config defined
				var settings = $.extend({}, defaults, _.omit(_config, 'configButtons') );

				if( $(element).data('wysiwygjs') == undefined ) {

					$(element).wysiwyg(settings).change(function(e) {
						// console.log(e.target);

						var wysiwygeditor = $(e.target).data('wysiwygjs').wysiwygeditor;
						var currentEditor = wysiwygeditor.getElement();
						var linksEditor = $( currentEditor ).find('a');

						// set font size
						// wysiwygeditor.fontSize('15px');

						// define external link
						linksEditor.each(function(indx, el) {
						    var hrefLink = $(el).attr('href');

						    if( ! /^http(s)?/.test(hrefLink) )
						        hrefLink = 'http://'+ hrefLink;

						    $(el).attr({
						        'href': hrefLink,
						        'target': '_blank'
						    });
						});
					});
				}
			});
		}
	}

})(jQuery, this, this.document);

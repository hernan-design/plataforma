// Include dependencies
const jQuery       = require('jquery');
const _            = require('underscore');
const InitAnimated = require('./animated');
const Misc         = require('./helpers/misc');

// Foundation zurb & Materialize
const Foundation = (typeof window !== 'undefined' && window.Foundation) || (typeof global !== 'undefined' && global.Foundation) || null;
const Materialize = (typeof window !== 'undefined' && window.Materialize) || (typeof global !== 'undefined' && global.Materialize) || null;

// Inputmask
let Inputmask = null;

// svg animate
const jsonEntryPreloader = require('./helpers/entry-shape-preloader.json');
const jsonItemPreloader = require('./helpers/item-shape-preloader.json');
let SvgEntryAnim = null;

// load dependencies when window global scope is already
if(typeof window !== 'undefined') {
    window.$ = window.jQuery = jQuery;

    // inputmask
    require('../libs/inputmask/dist/inputmask/inputmask.extensions.js');
    require('../libs/inputmask/dist/inputmask/inputmask.numeric.extensions.js');
    Inputmask = require('../libs/inputmask/dist/inputmask/inputmask.phone.extensions.js');
    require('../libs/inputmask/dist/inputmask/jquery.inputmask.js');

    // select2
    try {
        const select2 = require('select2');
        if (typeof select2 === 'function') {
            select2(window, jQuery);
        }
        import('select2/dist/js/i18n/es.js');
    } catch(e) {}

    // datetimepicker
    // require('../libs/datetimepicker/build/jquery.datetimepicker.full.js')(jQuery);

    // svg animation
    try {
        const eve = require('eve');
        window.eve = eve;
        const Snap = require('snapsvg');
    } catch(e) {}
    SvgEntryAnim = (typeof window !== 'undefined' && window.SVGAnim) || (typeof global !== 'undefined' && global.SVGAnim) || null;
}

// wnumb
const wNumb = require('wnumb');

// moment.js
const moment = require('moment');
require('moment/locale/es.js');

// Globalize
const Globalize = require('globalize/dist/globalize');
require('globalize/dist/globalize/message');
require('globalize/dist/globalize/plural');

// Initialize variables
let document = global.document;
let locale = 'es-CO';

// Function to initialize plugins
// ------------------------------
const initApp = module.exports = exports = function () {
    // fix error about getAttribute method for comment object dom
    Object.getPrototypeOf(document.createComment('')).getAttribute = function() {}

    // override Materialize forms default validation
    global.validate_field = () => {};

    configInputMask();
    select2Trigger();
    datepickerTrigger();
    initConfigForm();
    noCloseModal();
    noScrollModal();
    stopPreloaderScreen();
    initTabs();
    (new InitAnimated()).initialize();
}
// Initialize methods immediately
// ------------------------------
!(function () {
    // configFormatting();
    configGlobalize();
    configDateFormatter();
    if(global && global.document) {
        validateForm();
        initFoundation();
    }
}).call(this);

// config formatting functions
const copCurrencyF = module.exports.copCurrencyF = wNumb({
    mark: ',',
    thousand: '.',
    decimals: 0,
    prefix: '$',
    negativeBefore: '- '
});
const dolarCurrencyF = module.exports.dolarCurrencyF = wNumb({
    mark: '.',
    thousand: ',',
    decimals: 0,
    prefix: 'USD ',
    negativeBefore: '- '
});

// Stop preloader screen
function stopPreloaderScreen () {
    setTimeout(() => {
        $('body').addClass('loaded');
    }, 100);
}

/**
 * Initialize foundation
 */
function initFoundation () {
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
                'number_format': /^[-+]?\d+((([,.]{1})\d{3})(\3\d{3})*)*([.,]{1}\d+)?$/,
                'card_dash': /^(?:4\d{3}-?(?:\d{4}-?){2}\d?(?:\d{3})?|5[1-5]\d{2}-?(?:\d{4}-?){3}|6(?:011|5\d\d)-?(?:\d{4}-?){3}|3[47]\d{2}-?(?:\d{4}-?){3}|3(?:0[0-5]|[68]\d)\d-?(?:\d{4}-?){2}\d{2}|(?:2131|1800|35\d{3})-?(?:\d{4}-?){2}\d{3})$/
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

                    hasLength = textFld.length ? Misc.trim(textFld.replace(/\s{2,}|\t/g,' ')).split(' ').length : 0;
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
}

/*
 * Initialize form config
 */
const initConfigForm = module.exports.initConfigForm = (parentNode) => {
    // Show maxLength
    $('[data-maxlen]', parentNode).each(function(index, el) {
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
                hasLength = textFld.length ? Misc.trim(textFld.replace(/\s{2,}|\t/g,' ')).split(' ').length : 0;
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
    $('select', parentNode).material_select('destroy');
    $('select', parentNode).material_select();
    $('textarea.materialize-textarea', parentNode).trigger('autoresize');
    $('input[data-abide-validator*=maxLength], textarea[data-abide-validator*=maxLength], input[length], textarea[length]', parentNode).characterCounter();
    $('.button-collapse').each(function(index, el) {
        if( typeof $(el).data('activates') === 'undefined' ) {
            $(el).sideNav();
        }
    });

    // reload plugins
    $('select', parentNode).trigger('change.select2');

    // handler events plugins
    $(document).off('focus blur', '.tagsinput input');
    $(document).on('focus', '.tagsinput input', function (e) {

        var $inputEl = $(e.target);

        $inputEl.parents('.tagsinput').addClass('is-focused').prev('input').triggerHandler('focus');
    });
    $(document).on('blur', '.tagsinput input', function (e) {

        var $inputEl = $(e.target);

        $inputEl.parents('.tagsinput').removeClass('is-focused');
    });
};

/**
 * to validate forms with Editor
 */
function validateForm () {
    Foundation.libs.abide['init'] = function (scope, method, options) {
        this.bindings(method, options);

        // delegate custom events
        validateFormEvents(scope);
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
        form = self.S(scope).attr('novalidate', '');
        self.S(form).each(function (idx, el) {
            // self.events(el);
            // delegate custome events
            validateFormEvents(el);
        });
    };
}
/**
 * validate fields
 * @param $invalid_fields collection or element
 */
function validateFields ($invalid_fields) {
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
};
/**
 * focus scroll in invalid inputs
 * @parem Element formInvalid
 */
function invalidFocusField (formInvalid) {
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
}
function validateFieldOne (form, originalSelf, e) {

    var settings = form.data(Foundation.libs.abide.attr_name(true) + '-init') || {};

    clearTimeout(Foundation.libs.abide.timer);
    Foundation.libs.abide.timer = setTimeout(function () {
        Foundation.libs.abide.validate([originalSelf], e);
        // customize validation
        validateFields(originalSelf);
    }.bind(originalSelf), settings.timeout);
}
/**
 * validate form events
 */
function validateFormEvents (formScope) {
    (({}).toString.call(formScope).slice(8, -1) === 'HTMLFormElement') || (formScope = 'form[data-abide]');

    // customize validations
    $(formScope)
    .off('submit.fndtn.abide')
    .on('submit.fndtn.abide', function(e) {

        var is_ajax = /ajax/i.test( Foundation.libs.abide.S(e.target).attr(Foundation.libs.abide.attr_name()) );

        return Foundation.libs.abide.validate( Foundation.libs.abide.S(e.target).find('input, textarea, select').not("[data-abide-ignore]").get(), e, is_ajax );;
    });

    $(formScope).off('validate.fndtn.abide');
    $(formScope).on('validate.fndtn.abide', function (e) {

        var settings = $(this).data(Foundation.libs.abide.attr_name(true) + '-init') || {};
        var $invalid_fields = $(this).find('[data-invalid]:not([type="submit"]), .invalid:not([type="submit"])');

        // validate fields
        validateFields($invalid_fields);

        // focus and scroll to fields that they are invalid
        if(e.type == 'invalid' && settings.focus_on_invalid) invalidFocusField(this);
    })
    .off('blur.fndtn.abide change.fndtn.abide', 'input:not([data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])')
    .on('blur.fndtn.abide change.fndtn.abide', 'input:not([data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])', function (e) {

        // overwrite foundation validation
        var form = Foundation.libs.abide.S($(e.target).closest('form[data-abide]')[0]).attr('novalidate', ''),
            settings = form.data(Foundation.libs.abide.attr_name(true) + '-init') || {};

        var id = this.getAttribute('id'),
            eqTo = form.find('[data-equalto="'+ id +'"]');

        // old settings fallback
        // will be deprecated with F6 release
        if (settings.validate_on_blur && settings.validate_on_blur === true) {
          validateFieldOne(form, this, e);
        }
        // checks if there is an equalTo equivalent related by id
        if(typeof eqTo.get(0) !== "undefined" && eqTo.val().length){
          validateFieldOne(form, eqTo.get(0), e);
        }
        // new settings combining validate options into one setting
        if (settings.validate_on === 'change') {
          validateFieldOne(form, this, e);
        }
    })
    .off('keydown.fndtn.abide', 'input:not(:radio,:checkbox,[data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])')
    .on('keydown.fndtn.abide', 'input:not(:radio,:checkbox,[data-abide-ignore],[type="submit"]), textarea:not([data-abide-ignore]), select:not([data-abide-ignore])', function (e) {

        // overwrite foundation validation
        var form = Foundation.libs.abide.S($(e.target).closest('form[data-abide]')[0]).attr('novalidate', ''),
            settings = form.data(Foundation.libs.abide.attr_name(true) + '-init') || {};

        var id = this.getAttribute('id'),
            eqTo = form.find('[data-equalto="'+ id +'"]');
        // old settings fallback
        // will be deprecated with F6 release
        if (settings.live_validate && settings.live_validate === true && e.which != 9) {
          validateFieldOne(form, this, e);
        }
        // checks if there is an equalTo equivalent related by id
        if(typeof eqTo.get(0) !== "undefined" && eqTo.val().length){
          validateFieldOne(form, eqTo.get(0), e);
        }
        // new settings combining validate options into one setting
        if (settings.validate_on === 'tab' && e.which === 9) {
          validateFieldOne(form, this, e);
        }
        else if (settings.validate_on === 'change') {
          validateFieldOne(form, this, e);
        }
    });
}

/**
 * Trigger jquery.inputmask plugin config
 */
const configInputMask = module.exports.configInputMask = (element) => {
    Inputmask.extendDefaults({
        autoUnmask: true,
        removeMaskOnSubmit: true,
    });
    Inputmask.extendAliases({
        'currencySubmit': {
            alias: 'currency',
            unmaskAsNumber: true,
            allowMinus: false,
            min: 0,
            removeMaskOnSubmit: true,
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
                if (unmaskedValue === "" && opts.nullable === true) {
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
            alias: 'currencySubmit',
            radixPoint: ",",
            groupSeparator: ".",
            digits: 0
        },
        '.currency-mask-usd': {
            alias: 'currencySubmit',
            prefix: "USD "
        },
        '.ncurrency-mask-cop': {
            alias: 'currencySubmit',
            radixPoint: ",",
            groupSeparator: ".",
            digits: 0,
            allowMinus: true,
            min: null
        },
        '.ncurrency-mask-usd': {
            alias: 'currencySubmit',
            prefix: "USD ",
            allowMinus: true,
            min: null
        },
        '.phone-mask-co': {
            // url: Misc.urlFull('js/vendor/phone-codes/phone-codes.js'),
            // alias: 'phone',
            // countrycode: '57',
            mask: '(999)999-9999',
            placeholder: '_',
            greedy: true
        },
        '.percentage-mask': {
            alias: 'percentage',
            placeholder: '',
            min: 0,
            max: null,
            unmaskAsNumber: true,
            clearMaskOnLostFocus: false,
            showMaskOnHover: false,
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
            min: 0,
            allowMinus: false,
            unmaskAsNumber: true,
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
            allowPlus: false
        },
        '.full_year': {
            mask: '9999',
            greedy: true,
            placeholder: 'Y',
            clearMaskOnLostFocus: false
        },
        '.credit-card-mask': {
            mask: '9999-9999-9999-9[99][9]',
            greedy: false,
            autoGroup: true,
            groupSeparator: '-',
            placeholder: '_',
            numericInput: false,
            rightAlign: false
            // regex: '^(?:4\d{3}-?(?:\d{4}-?){2}\d?(?:\d{3})?|5[1-5]\d{2}-?(?:\d{4}-?){3}|6(?:011|5\d\d)-?(?:\d{4}-?){3}|3[47]\d{2}-?(?:\d{4}-?){3}|3(?:0[0-5]|[68]\d)\d-?(?:\d{4}-?){2}\d{2}|(?:2131|1800|35\d{3})-?(?:\d{4}-?){2}\d{3})$'
        }
    };

    for (var selector in config){
        var $selector = $(element).length ? $(element).filter(selector) : $(selector);

        $selector.each(function(index, el) {
            var $el = $(el);

            $el.inputmask( config[selector] );
        });
    }
}

/**
 * config moment.js
 */
function configDateFormatter() {
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
}

/*
 * load globalize for internationalization and localization
 */
function configGlobalize () {
    // load required CLDR JSON
    Globalize.load(
        require('cldr-data/supplemental/likelySubtags.json'),
        require('cldr-data/supplemental/plurals.json'),
        require('cldr-data/supplemental/ordinals.json')
    );
    // load globalize messages from json file
    Globalize.loadMessages( require('../../lang/es/messages.json') );

    Globalize.locale( locale );
}
/**
 * format message for institution
 * @param message {String}
 * @param data {Object}
 * @param _locale {String}
 * @return formated message {String}
 */
const formatMessage = module.exports.formatMessage = (message, data, _locale) => {

    const _Globalize = _locale ? Globalize(_locale) : Globalize;
    const slugInstitution = process.env.SLUG_INSTITUTION;

    try {
        return _Globalize.formatMessage(`${slugInstitution ? slugInstitution +'/' : ''}${message}`, data);

    }catch(e) {
        return _Globalize.formatMessage(message, data);
    }
}

/**
 * message formatter for institution
 * @param message {String}
 * @param _locale {String}
 * @return formatter {Function}, parameters: {object}
 */
const messageFormatter = module.exports.messageFormatter = (message, _locale)  => {

    const _Globalize = _locale ? Globalize(_locale) : Globalize;
    const slugInstitution = process.env.SLUG_INSTITUTION;

    try {
        return _Globalize.messageFormatter(`${slugInstitution ? slugInstitution +'/' : ''}${message}`);

    }catch(e) {
        return _Globalize.messageFormatter(message);
    }
}

/**
 * init select2 plugin
 */
const select2Trigger = module.exports.select2Trigger = (element) => {
    let config = {
        '.choice-select' : { language:"es", placeholder:'Seleccione una opción' },
        '.choice-select-deselect'  : { language:"es", placeholder:'Seleccione una opción', allowClear: true },
        '.choice-select-nosearch' : { language:"es", placeholder:'Seleccione una opción', minimumResultsForSearch: Infinity },
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
                        page: params.page
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
    for(var selector in config) {
        var $selector = $(element).length ? $(element).filter(selector) : $(selector);

        $selector.each(function(index, el) {
            var $el = $(el);

            if( $el.data('select2') == undefined ) {
                if( $el.data('ajax--url') ) {
                    config[selector].ajax.url = $el.data('ajax--url');
                }

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
                        var ajaxOptions = $el.data('select2').dataAdapter.ajaxOptions || $el.data('ajax--url');

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
            }else {
                $el.trigger('change.select2');
            }
        });
    }
}

/**
 * Trigger foundation datepicker plugin
 */
const datepickerTrigger = module.exports.datepickerTrigger = (element) => {
    jQuery.datetimepicker.setLocale('es');

    var config = {
        '.fdatepicker' : {
            language: 'es',
            format: 'yyyy-mm-dd'
        }
    };

    var configTp = {
        '.datetimepk': {
            timepicker: true,
            format: 'Y-m-d H:i',
            step: 30,
            mask: '9999-19-39 29:59',
            scrollInput: false,
            startDate: new Date(),
            allowBlank: true
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
    for (var selector in config){
        var $selector = $(element).length ? $(element).filter(selector) : $(selector);

        $selector.each(function(index, el) {
            var $el = $(el);

            if( $el.data('datepicker') === undefined ){
                $el.fdatepicker(config[selector]);
            }
        });
    }

    // set jQuery datetimepicker
    for (var selector in configTp){
        var $selector = $(element).length ? $(element).filter(selector) : $(selector);

        $selector.each(function(index, el) {
            var $el = $(el);

            if( $el.data('xdsoft_datetimepicker') === undefined ){
                $el.datetimepicker(configTp[selector]);
            }
        });
    }
}

/**
 * functions that animate a svg graphic
 */
const loadSVGEntryAnimation = module.exports.loadSVGEntryAnimation = () => {

    if(!SvgEntryAnim) {
        return false;
    }

    const fpsAnim = 24;
    const widthAnim = 580;
    const heightAnim = 200;

    const compAnimate = new SvgEntryAnim(
       jsonEntryPreloader,
       widthAnim,
       heightAnim,
       fpsAnim
    );

    return compAnimate;
}
const loadSVGItemAnimation = module.exports.loadSVGItemAnimation = () => {

    if(!SvgEntryAnim) {
        return false;
    }

    const fpsAnim = 24;
    const widthAnim = 280;
    const heightAnim = 50;

    const compAnimate = new SvgEntryAnim(
       jsonItemPreloader,
       widthAnim,
       heightAnim,
       fpsAnim
    );

    return compAnimate;
}

/**
 * doesn't allow to close modal
 */
const noCloseModal = module.exports.noCloseModal = (element) => {
    const $selector = $(element).length ? $(element) : $('[data-reveal]');

    $selector.filter('[data-noclose]').each(function(index, el) {
        var $el = $(el);
        $el.foundation('reveal', {close_on_background_click:false, close_on_esc:false});
    });
}
const noScrollModal = module.exports.noScrollModal = (element) => {
    const $selector = $(element).length ? $(element) : '[data-reveal][data-noscroll]';

    const noScrolling = (event) => {
        if(event.namespace != 'fndtn.reveal') return;

        document.body.style.overflow = 'hidden';
    }
    const scrolling = (event) => {
        if(event.namespace != 'fndtn.reveal') return;

        document.body.style.overflow = 'auto';
    }

    $(document).off('open.fndtn.reveal', $selector, noScrolling);
    $(document).on('open.fndtn.reveal', $selector, noScrolling);

    $(document).off('closed.fndtn.reveal', $selector, scrolling);
    $(document).on('closed.fndtn.reveal', $selector, scrolling);
}

/**
 * init tab config
 */
const initTabs = module.exports.initTabs = (element) => {
    const altSelector = (altSel) => $(element).length ? element : altSel;

    $(altSelector('[data-tab].tabs-route, [data-tab].tabs-progress-bar, [data-tab].slick-tabs')).off('toggled');
    $(altSelector('[data-tab]')).filter('.tabs-route').on('toggled', function(event, tab) {
        var $elTab = $(event.currentTarget),
            $linkActive = $elTab.find('dd.active a, .tab-title.active a'),
            refTab = $linkActive.attr('aria-controls');

        var settings = $elTab.data(Foundation.libs.tab.attr_name(true) + '-init') || {};

        // if it's url to go there
        if( settings.is_hover && Modernizr.touch && Misc.isUrl($linkActive.attr('href')) ) {

            Misc.redirect($linkActive.attr('href'));

            if( refTab != '' ) {
                $('#'+refTab).addClass('active')
                             .siblings('.content').removeClass('active');
            }

        }else if( Misc.isUrl($linkActive.attr('href')) && $elTab.hasClass('tabs-redirect') ) {
            Misc.redirect($linkActive.attr('href'));

        }else {
            if( refTab != '' ) {
                $('#'+refTab).addClass('active')
                             .siblings('.content').removeClass('active');
            }
        }
    });

    $(altSelector('[data-tab]')).filter('.table-of-contents').off('toggled');
    $(altSelector('[data-tab]')).filter('.table-of-contents').on('toggled', function(event, tab) {
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
    $(altSelector('[data-tab]')).filter('.tabs-progress-bar').on('toggled', function (event, tab) {

        var $elTab = $(event.currentTarget),
            $tabChildren = $elTab.find('dd, .tab-title'),
            $barProgress = $elTab.find('.bar__fill');

        // calculate percentage of progress bar
        var percentageBar =  ($tabChildren.index($tabChildren.filter('.active'))) / ($tabChildren.length - 1) * 100;
        $barProgress.css({'width': percentageBar + '%' });
    });

    window.setTimeout(function () {
        $(altSelector('[data-tab]')).filter('.tabs-progress-bar').trigger('toggled');
    }, 1500);

    // init materialize tabs
    // $('ul.tabs-sub-nav').tabs();
}

// resources/assets/js/components/containers/base-editor.js
import '../../helpers/jquery-global.js';
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Misc, { formToJson, setSpinner, getCsrf, removeSpinner } from '../../helpers/misc';
import { route } from '../../helpers/laroute.js';
import $ from 'jquery';

class BaseEditor extends Component {

    constructor(props) {
        super(props);

        let data = props.formCreate ? formToJson(props.formCreate) : {};
        this.defaultValue = props.value || props.defaultValue || data[props.name] || '';

        // set default states
        this.state = {
            value: this.defaultValue,
            canRender: false
        };

        // binding event handlers
        this.handleChange = this.handleChange.bind(this);
        this.imageUpload = this.imageUpload.bind(this);
    }

    async componentDidMount() {
        if (typeof window !== 'undefined') {
            window.$ = window.jQuery = $;
            $.summernote = $.summernote || { lang: {} };

            await import('bootstrap-sass/assets/javascripts/bootstrap/modal.js');
            await import('bootstrap-sass/assets/javascripts/bootstrap/dropdown.js');
            await import('bootstrap-sass/assets/javascripts/bootstrap/tooltip.js');

            // set aliases for bootstrap js libraries
            if(
                $.fn.dropdown.noConflict &&
                $.fn.tooltip.noConflict
            ){
                const bsDropdown = $.fn.dropdown.noConflict();
                const bsTooltip = $.fn.tooltip.noConflict();

                $.fn.bsDropdown = bsDropdown;
                $.fn.bsTooltip = bsTooltip;

                // Bridge $.fn.tooltip so Summernote and jQuery UI coexist seamlessly
                const origTooltip = $.fn.tooltip;
                $.fn.tooltip = function(option) {
                    if (this.closest('.note-editor, .note-btn-group, .note-toolbar').length || this.data('bs.tooltip') || (typeof option === 'string' && (option === 'hide' || option === 'show' || option === 'toggle'))) {
                        if ($.fn.bsTooltip) {
                            try {
                                return $.fn.bsTooltip.apply(this, arguments);
                            } catch(e) {}
                        }
                    }
                    try {
                        if (typeof option === 'string' && (option === 'hide' || option === 'close')) {
                            if (this.data('ui-tooltip') || this.data('uiTooltip')) {
                                return origTooltip.call(this, 'close');
                            }
                            return this;
                        }
                        if (typeof option === 'string' && (option === 'show' || option === 'open')) {
                            if (this.data('ui-tooltip') || this.data('uiTooltip')) {
                                return origTooltip.call(this, 'open');
                            }
                            return this;
                        }
                        return origTooltip.apply(this, arguments);
                    } catch(err) {
                        return this;
                    }
                };
            }

            const jq = window.jQuery || window.$ || $;
            if (jq) {
                window.$ = window.jQuery = jq;
                jq.summernote = jq.summernote || {};
                jq.summernote.lang = jq.summernote.lang || {};
                jq.summernote.options = jq.summernote.options || {};
                jq.summernote.plugins = jq.summernote.plugins || {};
                jq.summernote.ui = jq.summernote.ui || {};
            }

            this.ReactSummernote = (await import('react-summernote')).default;
            await import("summernote/dist/summernote.js");

            // Re-ensure summernote namespaces after summernote/dist/summernote.js loads
            if (jq && jq.summernote) {
                jq.summernote.lang = jq.summernote.lang || {};
                jq.summernote.options = jq.summernote.options || {};
                jq.summernote.plugins = jq.summernote.plugins || {};
            }

            try {
                await import("summernote-cleaner/summernote-cleaner.js");
            } catch (cleanerErr) {
                console.warn('summernote-cleaner could not be loaded:', cleanerErr);
            }

            try {
                await import('react-summernote/lang/summernote-es-ES.js');
            } catch (langErr) {
                console.warn('summernote-es-ES could not be loaded:', langErr);
            }
        }

        const jq = window.jQuery || window.$ || $;
        const $nodeEditor = jq(this.nodeEditor);

        this.setState({canRender: true}, () => {
            if ($nodeEditor.find) {
                if ($nodeEditor.find('[data-toggle="tooltip"]').bsTooltip) {
                    $nodeEditor.find('[data-toggle="tooltip"]').bsTooltip();
                }
                $nodeEditor.find('[data-toggle="dropdown"]').each(function(index, el) {
                    const $el = jq(el);
                    if ($el.bsDropdown) {
                        $el.bsDropdown();
                        if ($el.data('_lite_dropdown')) {
                            $el.data('_lite_dropdown').setEvent();
                        }
                    }
                });
            }
        });
    }

    componentWillUnmount() {
        const jq = window.jQuery || window.$ || $;
        const $nodeEditor = jq(this.nodeEditor);
        if ($nodeEditor.find) {
            if ($nodeEditor.find('[data-toggle="tooltip"]').bsTooltip) {
                $nodeEditor.find('[data-toggle="tooltip"]').bsTooltip('destroy');
            }
            $nodeEditor.find('[data-toggle="dropdown"]').off('bs.dropdown');
        }
    }

    componentWillReceiveProps(nextProps) {

        let data = nextProps.formCreate ? formToJson(nextProps.formCreate) : {};
        this.defaultValue = nextProps.value || nextProps.defaultValue || data[nextProps.name] || '';

        this.writeValue(this.defaultValue);
    }

    /**
    * @param model
    * handler when editor model change
    */
    handleChange(content) {

        // validate if the editor content is really empty
        if(this.editor && this.editor.isEmpty()) {
            this.editor.replace('');
            this.writeValue('');
        }else {
            this.writeValue(content);
        }

        if(this.props.onChange) this.props.onChange(content);
    }

    /**
    * @param content
    * write value for state
    */
    writeValue(content) {
        this.setState({ value: content });
    }

    /*
    * reference editor
    */
    refEditor(editor) {
        this.editor = editor;
    }

    /**
    * @param files
    * images upload change
    */
    imageUpload(files) {
        const dataFile = files[0];
        const noteEditor = this.editor.noteEditable;
        const {
            paramsImageUpload,
            imageInputName,
            imageEndpoint = Misc.urlFull(route('file.upload'))
        } = this.props;

        const data = new FormData();
        for (let key in paramsImageUpload) {
            data.append(key, paramsImageUpload[key]);
        }
        data.append(imageInputName, dataFile);

        let customHeaders = new Headers({
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
            "X-XSRF-TOKEN": getCsrf().getCookie('XSRF-TOKEN'),
        });

        // load spinner
        setSpinner( noteEditor );

        fetch(imageEndpoint, {
            method: "POST",
            credentials: "same-origin",
            headers: customHeaders,
            body: data
        }).then(
            response => response.json()
        ).then( data => {
            this.editor.insertImage(data.file_path, function ($image) {
                $image.css('width', '100%');
                // $image.attr('data-filename', 'retriever');
            });

            // remove spinner
            removeSpinner({
                wrap: noteEditor,
                direct: false
            });
        }).catch(err => ({
            infoStatus: 'error'
        }));
    }

    render() {
        const ReactSummernote = this.ReactSummernote;

        let defaults = {
            lang: 'es-ES',
            minHeight: 50,
            maxHeight: 400,
            dialogsInBody: true,
            dialogsFade: true,
            placeholder: this.props.placeholder,
            focus: this.props.autoFocus,
            toolbar: [
                ['font', ['bold', 'italic', 'underline', 'strikethrough']],
                ['para', ['ul', 'ol', 'paragraph']]
            ],
            cleaner: {
                action: 'paste', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                newline: '<br>', // Summernote's default is to use '<p><br></p>'
                keepHtml: true,
                keepClasses: false, // Remove Classes
                badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
                badAttributes: ['style', 'start'], // Remove attributes from remaining tags
                limitChars: false, // 0/false|# 0/false disables option
                limitDisplay: '', // text|html|both
                limitStop: false // true/false
            }
        };
        const { name, placeholder, autoFocus, required, value, defaultValue, options, onChange, editorRef, ...props } = this.props;
        const settings = {...defaults, ...options};

        if (this.state.canRender && ReactSummernote) {
            return (
                <div className={`editor-content ${this.props.className}`} ref={node => { this.nodeEditor = node; }}>
                    <ReactSummernote
                        value={this.state.value}
                        options={settings}
                        onChange={this.handleChange}
                        onImageUpload={this.imageUpload}
                        ref={node => { this.refEditor(node); editorRef(node); }}
                        {...props}
                    />
                    <input
                        type="hidden"
                        name={name}
                        value={this.state.value}
                        required={required}
                    />
                    {/*<div className="col-md-6">
                        <div className="editor-content-preview panel-content radius" dangerouslySetInnerHTML={{ __html: this.state.value }} />
                    </div>*/}
                </div>
            );
        }
        else {
            return (
                <div className={`editor-content ${this.props.className}`} ref={node => { this.nodeEditor = node; }}>
                    <textarea
                        name={name}
                        value={this.state.value}
                        required={required}
                        placeholder={placeholder}
                        autoFocus={autoFocus}
                        onChange={e => { this.handleChange(e.target.value); }}
                        ref={node => { editorRef(node); }}
                    />
                </div>
            );
        }
    }
}

BaseEditor.propTypes = {
    formCreate: PropTypes.oneOfType([
        PropTypes.node
    ]),
    name: PropTypes.string.isRequired,
    defaultValue: PropTypes.string,
    value: PropTypes.string,
    className: PropTypes.string,
    required: PropTypes.bool,
    autoFocus: PropTypes.bool,
    placeholder: PropTypes.string,
    options: PropTypes.object,
    onChange: PropTypes.func,
    editorRef: PropTypes.func,
    imageInputName: PropTypes.string,
    imageEndpoint: PropTypes.string,
    paramsImageUpload: PropTypes.object
};

BaseEditor.defaultProps = {
    name: '',
    className: '',
    required: false,
    autoFocus: false,
    placeholder: '',
    options: {},
    editorRef: () => {},
    imageInputName: 'file',
    paramsImageUpload: {}
};

export default BaseEditor

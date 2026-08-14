// resources/assets/js/components/wall/form/form-post.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { actionCreators } from '../../../stores/wall';
import { strToNickname, stripTags, urlWrapLink } from '../../../helpers/misc';
import { getModule } from '../../../helpers/states';
import { typeContent } from '../../../helpers/redux-utils';
import { formatMessage } from '../../../init-app';

// app components
import FormPublish from './form-publish';
import BaseEditor from '../../containers/base-editor';

class FormPost extends Component {
    constructor(props) {
        super(props)

        // initialize attributes;
        this.parsedContent = '';

        // bind event handlers
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(content) {
        this.parsedContent = this.parseContent(content);
        // this.editor.replace(this.parsedContent);
    }

    handleSubmit(e, edit, record) {
        const { storeEntry, updateEntry } = this.props;

        if( edit && record ) {
            return updateEntry(this.nodeForm.id, { itemId: record.cod })
        }

        return storeEntry(this.nodeForm.id, {
            'texto_muro': this.parsedContent
        });
    }

    parseContent(content) {
        // content = stripTags(content, '<br><p><a><img>')
        // content = urlWrapLink( content );

        return content;
    }

    render() {
        const { ...rest } = this.props;
        const editorOptions = {
            minHeight: 100,
            toolbar: [
                ['insert', ['picture','link']]
            ],
            popover: {
                image: [['remove', ['removeMedia']]],
                link: [
                    ['link', ['linkDialogShow', 'unlink']]
                ]
            },
            cleaner: {
                action: 'paste', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                newline: '<br>',
                keepHtml: true, // Remove all Html formats
                keepOnlyTags: ['<p>', '<br>', '<a>', '<img>'], // If keepHtml is true, remove all tags except these
                keepClasses: false, // Remove Classes
                badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
                badAttributes: ['style', 'start'], // Remove attributes from remaining tags
                limitChars: false, // 0/false|# 0/false disables option
                limitDisplay: '', // text|html|both
                limitStop: false // true/false
            }
        };

        return(
            <FormPublish id="form_publish_post" onSubmit={this.handleSubmit} formRef={node => { this.nodeForm = node; }} type={typeContent(getModule('wall'))} {...rest} render={props => (
                <div>
                    <div className="row">
                        <div className="small-12 columns input-field">
                            <select
                                name="url_canal"
                                defaultValue={ props.channelUrl === 'general' ? '' : props.channelUrl }
                            >
                                <option value=''>#General</option>
                                {props.channels.map(ch => (
                                    <option
                                        key={ch.codigoCanal}
                                        value={ch.urlCanal}
                                        data-codigo-canal={ch.codigoCanal}
                                        disabled={!props.availableChannel(ch)}
                                    >
                                        { strToNickname(ch.nombreCanal, '#') }
                                    </option>
                                ))}
                            </select>
                            <label>Compartir con:</label>
                        </div>
                    </div>
                    <div className="row">
                        <div className="small-12 columns">
                            <BaseEditor
                                name="texto_muro"
                                placeholder={formatMessage('community/editor_content_placeholder')}
                                defaultValue={props.record ? props.record.textoMuro : ''}
                                onChange={this.handleChange}
                                options={editorOptions}
                                editorRef={editor => { this.editor = editor; }}
                                paramsImageUpload={{ targ_w: 550 }}
                                required
                                autoFocus
                            />
                        </div>
                    </div>
                </div>
            )} />
        );
    }
}

FormPost.propTypes = {
    storeEntry: PropTypes.func.isRequired,
    updateEntry: PropTypes.func.isRequired,
    channelUrl: PropTypes.string.isRequired,
    history: PropTypes.object.isRequired,
    onClose: PropTypes.func
};

FormPost.defaultProps = {
    channelUrl: ''
};

const mapDispatchToProps = dispatch => bindActionCreators(actionCreators, dispatch);

export default connect(null, mapDispatchToProps)(FormPost)

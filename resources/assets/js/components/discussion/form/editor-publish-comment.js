// resources/assets/js/components/discussion/form/editor-publish-comment.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { composables } from '../../../stores/paginator';
import Misc, { strToNickname, stripTags, urlWrapLink } from '../../../helpers/misc';
import { thumbs } from '../../../helpers/states';
import laroute from '../../../helpers/laroute.js';
import lazyDrive from '../../decorators/lazyDrive';
import { formatMessage } from '../../../init-app';

// app components
import Form from '../../containers/form';

class EditorPublishComment extends Component {
    constructor(props) {
        super(props);

        // initialize attributes;
        this.parsedContent = '';

        // initial state
        this.state = {
            fieldText: ''
        };

        // bind event handlers
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }

    handleSubmit(e, formData = {}) {
        e.preventDefault();

        const { listActions, addFields, addDirection, name:nameProp } = this.props;

        formData[nameProp] = this.parsedContent;
        formData = { ...formData, ...addFields };

        listActions.storeEntry(null, formData, addDirection).then(resp => {
            if(resp.success) {
                this.Form.resetFields();
                this.setState({ fieldText: '' });
            }
        });
    }

    handleChange(e) {
        this.setState({ fieldText: e.target.value });
        this.parsedContent = this.parseContent(e.target.value);
    }

    parseContent(content) {
        content = stripTags( content, 'a' );
        content = content.replace(/(\&nbsp;|<[a-z\?\!\/]([a-z0-9\_\:\.])*(\s[^>]*)?(>|$))/gi, ' $&');
        content = urlWrapLink( content );

        return content;
    }

    render() {
        const { id, name, formId, rows, cols, autoFocus, placeholder, nameButton, ownerData, isLoading, isAdding } = this.props;

        return(
            <div className="textarea-post-discussion no-inside-btn">
                <ul className="inline-list-grid align-top no-spacing">
                    { !!Object.keys(ownerData).length && (
                        <li className="has-image">
                            <a href={ Misc.urlFull(laroute.route('usuario.nickname', {nickname: ownerData.nicknameUsuario})) } className="rounded-thumb no-outline" title={ownerData.nombreUsuario}>
                                <img src={ownerData.imagenUsuario} alt={strToNickname(ownerData.nicknameUsuario)} className="rounded-img size25" onError={e => { Misc.imageDefault(e.target, thumbs.avatar()) }} />
                            </a>
                        </li>
                    )}
                    <li>
                        <Form onSubmit={this.handleSubmit} id={formId} className="form-discussion-comment" ref={node => { this.Form = node; }} formRef={node => { this.nodeForm = node; }}>
                            <ul className="inline-list-grid align-bottom">
                                <li>
                                    <textarea onChange={this.handleChange} name={name} id={id || name} cols={cols} rows={rows} className="materialize-textarea validate" placeholder={placeholder} required autoFocus={autoFocus} value={this.state.fieldText} />
                                </li>
                                <li className="short-col">
                                    <button className={`button xtiny sky-blue radius btn-lowerc btn-clean-margin ${isAdding ? 'disabled' : ''}`} type="submit">{ nameButton }</button>
                                </li>
                            </ul>
                        </Form>
                    </li>
                </ul>
            </div>
        );
    }
}

EditorPublishComment.propTypes = {
    name: PropTypes.string.isRequired,
    id: PropTypes.string,
    formId: PropTypes.string,
    rows: PropTypes.number,
    cols: PropTypes.number,
    autoFocus: PropTypes.bool,
    placeholder: PropTypes.string,
    nameButton: PropTypes.string,
    listActions: PropTypes.shape({
        storeEntry: PropTypes.func.isRequired
    }),
    ownerData: PropTypes.object.isRequired,
    listId: PropTypes.string.isRequired,
    isLoading: PropTypes.bool.isRequired,
    isAdding: PropTypes.bool.isRequired,
    addFields: PropTypes.object,
    addDirection: PropTypes.string
};

EditorPublishComment.defaultProps = {
    name: 'texto_discucion',
    id: 'texto_discucion',
    formId: '',
    rows: 2,
    cols: 50,
    autoFocus: true,
    placeholder: formatMessage('discussion/placeholder_field'),
    nameButton: formatMessage('discussion/button_submit'),
    isLoading: false,
    isAdding: false,
    listId: '',
    addFields: {},
    addDirection: 'start',
    ownerData: {}
};

const mapStateToProps = state => ({
    ownerData: state.session.user
});

const mapDispatchToProps = (dispatch, ownProps) => ({
    listActions: bindActionCreators(composables(ownProps), dispatch)
});

export default connect(mapStateToProps, mapDispatchToProps)(lazyDrive(EditorPublishComment))

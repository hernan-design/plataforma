// resources/assets/js/components/wall/form/form-forum.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { actionCreators } from '../../../stores/wall';
import laroute from '../../../helpers/laroute';
import Misc, { strToNickname } from '../../../helpers/misc';
import { getModule } from '../../../helpers/states';
import { typeContent } from '../../../helpers/redux-utils';
import NoSSR from 'react-no-ssr';
import { formatMessage } from '../../../init-app';

// app components
import FormPublish from './form-publish';
import SimpleEditor from '../../simple-editor';
import TagsAutosuggest from '../../containers/tags-autosuggest';

class FormForum extends Component {
    constructor(props) {
        super(props);

        // bind event handlers
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleSubmit(e, edit, record) {
        const { storeEntry, updateEntry, location } = this.props;

        if( edit && record ) {
            return updateEntry(this.nodeForm.id, {
                itemId: location.state && location.state.itemId,
                type: typeContent(getModule('forum')),
                codigo_foro: record.codigoRecursoModulo,
                codigo_muro: record.codigoMuro,
                action: 'wall'
            });
        }

        return storeEntry(this.nodeForm.id, {
            type: typeContent(getModule('forum')),
            action: 'wall'
        });
    }

    render() {
        const { ...rest } = this.props;

        return(
            <FormPublish id="form_publish_forum" onSubmit={this.handleSubmit} formRef={node => { this.nodeForm = node; }} type={typeContent(getModule('forum'))} {...rest} render={props => (
                <div>
                    <div className="row">
                        <div className="small-12 columns input-field">
                            <input type="text" name="titulo_foro" id="titulo_foro" data-abide-validator="maxLength" data-maxlen="80" required defaultValue={props.record ? props.record.tituloForo : ''} autoFocus />
                            <label htmlFor="titulo_foro">Título del tema</label>
                        </div>
                    </div>

                    <div className="row">
                        <div className="small-12 columns">
                            <NoSSR onSSR={<p>Cargando editor...</p>}>
                                <SimpleEditor
                                    name="descripcion_foro"
                                    formCreate="#form_publish_forum"
                                    placeholder={formatMessage('forum/editor_content_placeholder')}
                                    defaultValue={props.record ? props.record.descripcionForo : ''}
                                    required
                                />
                            </NoSSR>
                        </div>
                    </div>

                    <fieldset className="panel-section-form">
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
                    </fieldset>

                    <fieldset className="panel-section-form">
                        <div className="row">
                            <div className="small-12 columns input-field">
                                <select name="codigo_categoria_foro" defaultValue={props.record ? props.record.codigoCategoriaForo : ''} required>
                                    <option value="" disabled>Categoría</option>
                                    {props.forumCategories.map(c => (
                                        <option key={c.codigoCategoriaForo} value={c.codigoCategoriaForo}>
                                            {c.nombreCategoriaForo}
                                        </option>
                                    ))}
                                </select>
                                <label>Categoriza el tema:</label>
                            </div>
                        </div>
                    </fieldset>

                    <div className="row">
                        <div className="small-12 columns">
                            <TagsAutosuggest name="tags_foro" defaultValue={props.record ? props.record.tags : ''} />
                        </div>
                    </div>
                </div>
            )} />
        );
    }
}

FormForum.propTypes = {
    storeEntry: PropTypes.func.isRequired,
    updateEntry: PropTypes.func.isRequired,
    channelUrl: PropTypes.string.isRequired,
    history: PropTypes.object.isRequired,
    forumCategories: PropTypes.arrayOf(
        PropTypes.object
    ),
    onClose: PropTypes.func
};

FormForum.defaultProps = {
    channelUrl: '',
    forumCategories: []
};

const mapStateToProps = state => ({
    forumCategories: state.forum.categories
});

const mapDispatchToProps = dispatch => bindActionCreators({
    storeEntry: actionCreators.storeEntry,
    updateEntry: actionCreators.updateEntry
}, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(FormForum)

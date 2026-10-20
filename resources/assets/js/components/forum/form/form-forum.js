// resources/assets/js/components/forum/form/form-forum.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { actionCreators } from '../../../stores/forum';
import laroute from '../../../helpers/laroute.js';
import Misc, { strToNickname } from '../../../helpers/misc';
import { getModule } from '../../../helpers/states';
import { typeContent } from '../../../helpers/redux-utils';
import NoSSR from 'react-no-ssr';

// app components
import FormPublish from '../../containers/form-publish';
import TagsAutosuggest from '../../containers/tags-autosuggest';
import SimpleEditor from '../../simple-editor';

class FormForum extends Component {
    constructor(props) {
        super(props);

        // initial state
        this.state = {
            isAdding: false
        };

        // bind event handlers
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleSubmit(e, edit, record) {
        const { storeForum, updateForumOfList, location, history } = this.props;

        if( edit && record ) {
            return updateForumOfList(this.nodeForm.id, {
                listId: location.state && location.state.listId,
                itemId: location.state && location.state.itemId,
                foro: record.codigoForo
            });
        }

        this.setState({ isAdding:true });
        storeForum(this.nodeForm.id).then(data => {
            this.setState({ isAdding:false });

            if( !(data instanceof Error) ) {
                history.push(`/foro/${data.urlCategoriaForo}/${data.urlForo}`);
            }

            return data;
        }).catch(
            err => this.setState({ isAdding:false })
        );
    }

    render() {
        const { ...rest } = this.props;
        const { isAdding } = this.state;

        const currentCaregory = this.props.forumCategories.find(c => (
            c.urlCategoriaForo === this.props.categoryUrl
        ));

        return(
            <FormPublish id="form_publish_forum" onSubmit={this.handleSubmit} formRef={node => { this.nodeForm = node; }} isAdding={isAdding} {...rest} render={props => (
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
                                    placeholder="Contenido del tema"
                                    defaultValue={props.record ? props.record.descripcionForo : ''}
                                    required
                                />
                            </NoSSR>
                        </div>
                    </div>

                    {/*<fieldset className="panel-section-form">
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
                    </fieldset>*/}

                    <fieldset className="panel-section-form">
                        <div className="row">
                            <div className="small-12 columns input-field">
                                <select
                                    name="codigo_categoria_foro"
                                    defaultValue={ props.record ? props.record.codigoCategoriaForo
                                        : (currentCaregory ? currentCaregory.codigoCategoriaForo
                                        : '')
                                    }
                                    required
                                >
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
    storeForum: PropTypes.func.isRequired,
    updateForumOfList: PropTypes.func,
    categoryUrl: PropTypes.string.isRequired,
    history: PropTypes.object.isRequired,
    forumCategories: PropTypes.arrayOf(
        PropTypes.object
    ),
    onClose: PropTypes.func
};

FormForum.defaultProps = {
    categoryUrl: '',
    forumCategories: []
};

const mapStateToProps = state => ({
    forumCategories: state.forum.categories
});

const mapDispatchToProps = dispatch => bindActionCreators({
    storeForum : actionCreators.storeForum,
    updateForumOfList : actionCreators.updateForumOfList,
    loadRecord: (record) => actionCreators.loadForum(record.codigoForo, { type: 'encrypt' })
}, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(FormForum)

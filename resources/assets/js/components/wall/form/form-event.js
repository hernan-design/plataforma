// resource/assets/js/components/wall/form/form-event.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { actionCreators } from '../../../stores/wall';
import laroute from '../../../helpers/laroute.js';
import moment from 'moment';
import Misc, { strToNickname } from '../../../helpers/misc';
import { getModule } from '../../../helpers/states';
import { typeContent } from '../../../helpers/redux-utils';
import NoSSR from 'react-no-ssr';
import { formatMessage } from '../../../init-app';

// app components
import FormPublish from './form-publish';
import SimpleEditor from '../../simple-editor';

class FormEvent extends Component {
    constructor(props) {
        super(props);

        // bind event handlers
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleSubmit(e, edit, record) {
        const { storeEntry, updateEntry } = this.props;

        if( edit && record ) {
            return updateEntry(this.nodeForm.id, {
                itemId: record.cod,
                codigo_evento: record.codigoRecursoModulo,
                codigo_muro: record.codigoMuro,
                type: typeContent(getModule('calendar')),
                action: 'wall'
            });
        }

        return storeEntry(this.nodeForm.id, {
            type: typeContent(getModule('calendar')),
            action: 'wall'
        });
    }

    render() {
        const { ...rest } = this.props;

        return(
            <FormPublish id="form_publish_event" onSubmit={this.handleSubmit} formRef={node => { this.nodeForm = node; }} type={typeContent(getModule('calendar'))} {...rest} render={props => (
                <div>
                    <div className="row">
                        <div className="small-12 columns input-field">
                            <input type="text" name="nombre_evento" id="nombre_evento" data-abide-validator="maxLength" data-maxlen="80" autoFocus required defaultValue={props.record ? props.record.nombreEvento : ''} />
                            <label htmlFor="nombre_evento">Título del evento</label>
                        </div>
                    </div>

                    <div className="row">
                        <div className="small-12 tablet-6 columns input-field">
                            <div>
                                <input type="text" name="fecha_inicio" id="fecha_inicio" className="datetimeafterpk" defaultValue={props.record ? moment(`${props.record.fechaEvento} ${props.record.horaInicioEvento}`).format('YYYY-MM-DD HH:mm') : ''} required />
                            </div>
                            <label htmlFor="fecha_inicio" className="active">Fecha inicio</label>
                        </div>
                        <div className="small-12 tablet-6 columns input-field">
                            <div>
                                <input type="text" name="fecha_fin" id="fecha_fin" className="datetimeafterpk" defaultValue={props.record ? moment(`${props.record.fechaFinEvento} ${props.record.horaFinEvento}`).format('YYYY-MM-DD HH:mm') : ''} required />
                            </div>
                            <label htmlFor="fecha_fin" className="active">Fecha fin</label>
                        </div>
                    </div>

                    <div className="row">
                        <div className="small-12 columns input-field">
                            <select
                                name="codigo_tipo_evento"
                                defaultValue={props.record ? props.record.codigoTipoEvento : ''}
                                required
                            >
                                <option value="" disabled>Tipo de evento</option>
                                { props.eventTypes.map(et => (
                                    <option key={et.codigoTipoEvento} value={et.codigoTipoEvento}>{ et.nombreTipoEvento }</option>
                                )) }
                            </select>
                        </div>
                    </div>

                    <div className="row">
                        <div className="small-12 tablet-6 columns input-field">
                            <select
                                name="codigo_ciudad"
                                className="browser-default choice-select-autocomplete"
                                data-ajax--url={ Misc.urlFull(laroute.route('ciudades.index')) }
                                placeholder="Ciudad"
                                data-placeholder="Ciudad"
                                data-initial-value={props.record ? props.record.codigoCiudad : ''}
                                required
                            />
                            <label>Ciudad:</label>
                        </div>
                        <div className="small-12 tablet-6 columns input-field">
                            <input type="text" name="lugar_evento" id="lugar_evento" defaultValue={props.record ? props.record.lugarEvento : ''} />
                            <label htmlFor="lugar_evento">Lugar del evento</label>
                        </div>
                    </div>

                    <div className="row">
                        <div className="small-12 columns input-field">
                            <select
                                name="url_canal"
                                defaultValue={ props.channelUrl === 'general' ? '' : props.channelUrl }
                            >
                                <option value="">#General</option>
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
                            <NoSSR onSSR={<p>Cargando editor...</p>}>
                                <SimpleEditor
                                    name="descripcion_evento"
                                    formCreate="#form_publish_event"
                                    placeholder={formatMessage('calendar/event/editor_content_placeholder')}
                                    defaultValue={props.record ? props.record.descripcionEvento : ''}
                                    required
                                />
                            </NoSSR>
                        </div>
                    </div>
                </div>
            )} />
        );
    }
}

FormEvent.propTypes = {
    storeEntry: PropTypes.func.isRequired,
    updateEntry: PropTypes.func.isRequired,
    channelUrl: PropTypes.string.isRequired,
    history: PropTypes.object.isRequired,
    eventTypes: PropTypes.array,
    onClose: PropTypes.func
};

FormEvent.defaultProps = {
    channelUrl: '',
    eventTypes: [],
};

const mapStateToProps = state => ({
    eventTypes: state.event.types
});

const mapDispatchToProps = dispatch => bindActionCreators(actionCreators, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(FormEvent)

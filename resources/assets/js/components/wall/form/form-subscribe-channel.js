// resources/assets/js/components/wall/form/form-subscribe-channel.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { actionCreators } from '../../../stores/wall';
import { strToNickname } from '../../../helpers/misc';

// app components
import Form from '../../containers/form';

class FormSubscribeChannel extends Component {
    constructor(props) {
        super(props)

        // bind event handlers
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleSubmit(e) {
        e.preventDefault();

        const { subscribeChannel, location } = this.props;

        if(location.state && location.state.codChannel) {
            subscribeChannel(`channel_${location.state.codChannel}`);
        }
    }

    render() {
        const { channels, location, ownerData } = this.props;
        const currentChannel = channels.find(ch => ch.urlCanal === (location.state && location.state.channel));
        const owner_channel = ownerData.channels.find(channel => (channel.codigoCanal === currentChannel.codigoCanal));

        if ( typeof owner_channel === 'undefined' ) {
            return(
                <Form id="form_subscribe_channel" onSubmit={this.handleSubmit} formRef={node => { this.nodeForm = node; }}>
                    <div className="panel-content radius" style={{ marginTop: 0 }}>
                        <ul className="inline-list-grid align-top no-spacing">
                            <li className="has-image">
                                <i className="mdi mdi-lock mdi-30 gray-light left"></i>
                            </li>
                            <li>
                                <p className="text-md gray-dark-text">{`Suscríbete al contenido del canal ${currentChannel ? strToNickname(currentChannel.nombreCanal, '#') : ''}.`}</p>
                                <button type="submit" className="waves-effect waves-light button small sky-blue radius btn-bold btn-clean-margin btn-lowerc">Suscribirme</button> 
                            </li>
                        </ul>
                        <p></p>
                    </div>
                </Form>
            );
        } else {

            if (owner_channel.codigoEstado === 8){
                return(
                    <Form id="form_subscribe_channel" onSubmit={this.handleSubmit} formRef={node => { this.nodeForm = node; }}>
                        <div className="panel-content radius" style={{ marginTop: 0 }}>
                            <ul className="inline-list-grid align-top no-spacing">
                                <li className="has-image">
                                    <i className="mdi mdi-lock mdi-30 gray-light left"></i>
                                </li>
                                <li>
                                    <p className="text-md gray-dark-text">{`Suscríbete al contenido del canal ${currentChannel ? strToNickname(currentChannel.nombreCanal, '#') : ''}.`}</p>
                                    <button type="submit" className="waves-effect waves-light button small sky-blue radius btn-bold btn-clean-margin btn-lowerc">Suscribirme</button> 
                                </li>
                            </ul>
                            <p></p>
                        </div>
                    </Form>
                );
            } else if (owner_channel.codigoEstado === 9) {    
                return(
                    <Form id="form_subscribe_channel" onSubmit={this.handleSubmit} formRef={node => { this.nodeForm = node; }}>
                        <div className="panel-content radius" style={{ marginTop: 0 }}>
                            <ul className="inline-list-grid align-top no-spacing">
                                <li className="has-image">
                                    <i className="mdi mdi-lock mdi-30 gray-light left"></i>
                                </li>
                                <li>
                                    <p className="text-md gray-dark-text">{`Esperando que seas activado para acceder al contenido del canal ${currentChannel ? strToNickname(currentChannel.nombreCanal, '#') : ''}.`}</p>
                                </li>
                            </ul>
                            <p></p>
                        </div>
                    </Form>
                );
            }
        }
    }
}

FormSubscribeChannel.propTypes = {
    location: PropTypes.object.isRequired,
    match: PropTypes.object.isRequired,
    history: PropTypes.object.isRequired
};

FormSubscribeChannel.defaultProps = {
    'channels': []
};

const mapStateToProps = state => ({
    channels: state.channel.channels,
    ownerData: state.session.user,
});

const mapDispatchToProps = dispatch => bindActionCreators({
    subscribeChannel: actionCreators.subscribeChannel,
}, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(FormSubscribeChannel)

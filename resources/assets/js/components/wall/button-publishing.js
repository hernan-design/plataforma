// resources/assets/js/components/wall/button-publishing.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { formatMessage } from '../../init-app';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { actionCreators } from '../../stores/wall';
import { strToNickname, imageDefault } from '../../helpers/misc';
import { thumbs } from '../../helpers/states';
import { Link } from 'react-router-dom';

class ButtonPublishing extends Component {
    constructor(props) {
        super(props);

        // bind event handlers
        this.handleUnsubscribe = this.handleUnsubscribe.bind(this);
    }

    componentDidMount() {
        if( ({}).hasOwnProperty.call($.fn, 'foundation') ) {
            $(document).foundation('dropdown', 'reflow');
            $(document).foundation('tooltip', 'reflow');
        }
    }

    componentWillUnmount() {
        if( ({}).hasOwnProperty.call($.fn, 'foundation') ) {
            $(this.element).find('[data-dropdown]').foundation('dropdown', 'off');
            $(this.element).find('[data-tooltip]').foundation('tooltip', 'off');
        }
    }

    handleUnsubscribe(e) {
        e.preventDefault();
        const { channels, channelUrl, unsubscribeChannel } = this.props;
        const currentChannel = channels.find(ch => ch.urlCanal === channelUrl);

        unsubscribeChannel(currentChannel && currentChannel.codigoCanal);
    }

    render() {
        const { match, hasChannel, ownerData, channels, channelUrl } = this.props;
        const currentChannel = channels.find(ch => ch.urlCanal === channelUrl);

        return(
            <div id="panel-wall-publishing" className="panel-content radius-tablet-up" ref={node => { this.element = node; }}>
                <h5 className="dark-text bold-header">{ strToNickname( currentChannel ? currentChannel.nombreCanal : 'General', '#') }</h5>

                <div>
                    { currentChannel && !currentChannel.canalAbierto &&
                        (<ul className="list-icons-browse text-sm gray-light-text">
                            <li>
                                <a data-dropdown={`drop-opts-community-user`} aria-controls={`drop-opts-community-user`} data-options="is_hover:true" className="is-hovered">
                                    <i className="mdi mdi-settings mdi-18"></i>
                                </a>
                                <ul id="drop-opts-community-user" data-dropdown-content className="opts-action-dropdown radius no-arrow text-sm" aria-hidden="true">
                                    <li>
                                        <a href="#" onClick={this.handleUnsubscribe}>{formatMessage('community/leave_channel')} <i className="mdi mdi-account-off mdi-21 vcenter"></i></a>
                                    </li>
                                </ul>
                            </li>
                            <li className="vdivider"><span className="vertical-separator"></span></li>
                            <li>
                                <span data-tooltip aria-haspopup="true" className="linear-span radius tip-top vtop-text" title="Usuarios inscritos al canal">
                                    <i className="mdi mdi-account mdi-18 vcenter"></i>
                                    <span className="text-sm normal-text gray-dark-text vcenter-text">{ (currentChannel && currentChannel.contadorInscritos) || 0 }</span>
                                </span>
                            </li>
                        </ul>)
                    }
                    { currentChannel &&
                        currentChannel.descripcionCanal &&
                        <p className="text-md gray-dark-text">{ currentChannel.descripcionCanal }</p>
                    }

                    <hr style={{ margin: '10px 0' }} />
                </div>

                { ownerData.usuarioVerificado &&
                    (<Link to={{
                        pathname: `${match.url}${hasChannel ? '' : '/general'}/create`,
                        state: {
                            modal: true,
                            channel: currentChannel ? currentChannel.urlCanal : '',
                            codChannel: currentChannel ? currentChannel.codigoCanal : ''
                        }
                    }} style={{ display:'block' }} >
                        <ul className="inline-list-grid vcenter">
                            <li className="has-image">
                                <img src={ownerData.imagenUsuario} alt={strToNickname(ownerData.nicknameUsuario)} onError={e => { imageDefault(e.target, thumbs.avatar()) }} className="rounded-img size35" />
                            </li>
                            <li>
                                <span className="gray-base-text text-md normal-text">{formatMessage('community/publish_button_msg')}</span>
                            </li>
                        </ul>
                    </Link>)
                }
            </div>
        )
    }
};

ButtonPublishing.propTypes = {
    match: PropTypes.object.isRequired,
    location: PropTypes.object.isRequired,
    history: PropTypes.object.isRequired,
    ownerData: PropTypes.object.isRequired,
    hasChannel: PropTypes.bool,
    channelUrl: PropTypes.string,
    channels: PropTypes.array,
    unsubscribeChannel: PropTypes.func.isRequired
};

ButtonPublishing.defaultProps = {
    hasChannel: false,
    channelUrl: '',
    channels: []
};

const mapStateToProps = state => ({
    ownerData: state.session.user,
    channels: state.channel.channels
});
const mapDispatchToProps = dispatch => bindActionCreators({
    unsubscribeChannel: actionCreators.unsubscribeChannel
}, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(ButtonPublishing)

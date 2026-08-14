// resources/assets/js/components/wall/publishing.js
import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { Route, Redirect, Switch } from 'react-router-dom';

// app componenets
import ChoosePublishing from './form/choose-publishing';
import ButtonPublishing from './button-publishing';
import FormPost from './form/form-post';
import FormEvent from './form/form-event';
import FormForum from './form/form-forum';
import FormSubscribeChannel from './form/form-subscribe-channel';

const SwitchForm = ({ match, ...props }) => {
    const { params } = match;

    switch(params.formPublish) {
        case 'post':
            return (<FormPost {...props} />);
        case 'event':
            return (<FormEvent {...props} />);
        case 'forum':
            return (<FormForum {...props} />);
        default:
            return null;
    }
};

const Publishing = ({ match, location, history, ownerData, channels, passPrivacity }) => {
    
    // validated attributes
    const isModal = !!(
        location.state &&
        location.state.modal
    );

    const hasChannel = ({}).hasOwnProperty.call(match.params, 'channel') && !!match.params.channel;
    const currentChannel = channels.find(ch => hasChannel && (ch.urlCanal === match.params.channel));
    const availablePublish = ownerData.usuarioVerificado && passPrivacity;

    const handleBack = (e) => {
        if(e) {
            e.preventDefault;
            e.stopPropagation();
        }

        if(match.params.channel && match.params.channel === 'general') {
            history.replace('/comunidad');
        }else {
            history.replace(`${match.url}`);
        }
    }

    return(
        <section className="content-chosen-publishing">
            <Switch>
                <Redirect from={`/comunidad/general`} exact to={{
                    pathname: `/comunidad`,
                    state: {
                        channel: '',
                        codChannel: ''
                    }
                }} />

                {/* history.action === 'POP'&&
                    <Redirect to={{
                        pathname: `${match.url}`,
                        state: {
                            channel: currentChannel ? currentChannel.urlCanal : '',
                            codChannel: currentChannel ? currentChannel.codigoCanal : ''
                        }
                    }} />
                */}

                { !availablePublish ?
                    <Redirect from={`${match.url}/create`} to={{
                        pathname: `${match.url}`,
                        state: {
                            channel: currentChannel ? currentChannel.urlCanal : '',
                            codChannel: currentChannel ? currentChannel.codigoCanal : ''
                        }
                    }} />
                    :
                    null
                }
                { isModal ?
                    <Route path={`${match.url}/(create|edit)/:formPublish`} render={props => (
                        <SwitchForm onClose={handleBack} channelUrl={match.params.channel} style={styles.choosingBox} {...props} />
                    )} />
                    :
                    null
                }
                { isModal ?
                    <Route path={`${match.url}/create`} render={props => (
                        <ChoosePublishing onClose={handleBack} style={styles.choosingBox} ownerData={ownerData} {...props} />
                    )} />
                    :
                    null
                }
                { passPrivacity ?
                    <Route path={`${match.url}`} render={(props) => (
                        <ButtonPublishing hasChannel={hasChannel} channelUrl={match.params.channel} {...props} />
                    )} />
                    :
                    <Route path={`${match.url}`} component={FormSubscribeChannel} />
                }
            </Switch>

            { isModal && passPrivacity ?
                (<Route path={`${match.url}`} children={() => <span
                    className="overlight"
                    style={styles.overlight}
                    onClick={handleBack}
                />} />)
                :
                null
            }
        </section>
    );
};

Publishing.propTypes = {
    match: PropTypes.object.isRequired,
    location: PropTypes.object.isRequired,
    history: PropTypes.object.isRequired,
    ownerData: PropTypes.object.isRequired,
    passPrivacity: PropTypes.bool
};

Publishing.defaultProps = {
    channels: [],
    passPrivacity: false
};

// styles for component
const styles = {
    choosingBox: {
        position: 'relative',
        zIndex: 101
    },
    overlight: {
        display: 'block',
        position: 'fixed',
        width: '100%',
        height: '100%',
        top: 0,
        left: 0,
        background: 'rgba(0, 0, 0, .4)',
        zIndex: 100
    }
};

const mapStateToProps = state => ({
    ownerData: state.session.user,
    channels: state.channel.channels
});

export default connect(mapStateToProps)(Publishing)

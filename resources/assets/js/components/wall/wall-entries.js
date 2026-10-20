// resources/assets/js/components/wall/wall-entries.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { Route, withRouter, Switch } from 'react-router-dom';
import { LIST_ID as listIdWall } from '../../stores/wall';
import { composables as actionCreators } from '../../stores/paginator';
import { decorators, currentQuery } from '@orange-marmalade/paginate-this';
import { range, isEqual } from 'lodash';
import NoSSR from 'react-no-ssr';
import { thumbs } from '../../helpers/states';
import { loadSVGEntryAnimation, formatMessage } from '../../init-app';

// app components
import Publishing from './publishing';
import Entry from './entry';
import LoadMoreBound from '../load-more-bound';
import Preload from '../preload';
import NoResults from '../no-results';

const renderEntries = (listId) => {
    return (id, i) => (
        <Entry
            key={id || i}
            index={i}
            itemId={id}
            listId={listId}
        />
    );
};

const renderPreload = (count) => {
    return range(count).map(val => (
        <Preload
            key={val}
            style={{ marginBottom:'20px' }}
            preload={ loadSVGEntryAnimation }
            image={ thumbs.preloadEntry() }
        />
    ))
}

const WrapPreload = ({ count=0 }) => (<section className="wrap-publishied-entries">{renderPreload(count)}</section>);

class WallEntries extends Component {
    constructor(props) {
        super(props);

        // initial state
        this.state = {
            channelLocation: props.location,
            ids: props.results.map(r => r.cod)
        };

        // bind event handlers
        this.passChannelPrivacity = this.passChannelPrivacity.bind(this);
    }

    componentDidMount() {
        // initial results fetch
        this.refreshResults(this.props.location);
    }

    UNSAFE_componentWillReceiveProps(nextProps) {
        const { location:locationNext, history:historyNext } = nextProps;

        if(this.props.results !== nextProps.results) {
            this.setState({
                ids: nextProps.results.map(r => r.cod)
            });
        }

        if(this.props.location !== locationNext && historyNext.action !== 'POP') {
            this.refreshResults(locationNext, 100);
        }
    }

    shouldComponentUpdate(nextProps, nextState) {
        const { location, isLoading, isAdding, shouldUpdate, ownerData } = this.props;

        return (!isEqual(this.state.ids, nextState.ids) ||
            isLoading !== nextProps.isLoading ||
            isAdding !== nextProps.isAdding ||
            location !== nextProps.location ||
            ownerData !== nextProps.ownerData);
    }

    refreshResults(location, timeout = 0) {
        const { listActions } = this.props;

        const channel = (location && location.state && ({}).hasOwnProperty.call(location.state, 'channel'))
            ? location.state.channel
            : (location && location.pathname ? location.pathname.replace(/^\/comunidad\/?/, '') : '');

        const channelLocation = {
            ...(location || {}),
            state: {
                ...((location && location.state) || {}),
                channel
            }
        };

        this.setState({ channelLocation }, () => {
            if( this.passChannelPrivacity() ) {
                listActions.showByState('url_canal', channel, timeout);
            }
        });
    }

    passChannelPrivacity() {
        const channelLocation = this.state.channelLocation || {};
        const { ownerData, channels } = this.props;
        
        const stateChannel = channelLocation.state && channelLocation.state.channel;
        const stateCodChannel = channelLocation.state && channelLocation.state.codChannel;
        const evalChannelPrivacity = ch => ((ch.urlCanal === stateChannel) && ch.canalAbierto);
        const owner_channels = (ownerData && Array.isArray(ownerData.channels))
            ? ownerData.channels.find(channel => (channel.codigoCanal === stateCodChannel && channel.codigoEstado === 8))
            : undefined;

        return !!(
            (Array.isArray(channels) && channels.findIndex(evalChannelPrivacity) !== -1) ||
            typeof owner_channels != 'undefined' ||
            !stateChannel ||
            stateChannel === '' ||
            stateChannel === 'general' ||
            typeof channelLocation.state === 'undefined'
        );
    }

    render() {
        const { match, location, listId, isLoading, isAdding, pageQuery } = this.props;
        
        return (
            <div id="wrapper-wall-entries">
                {/* Render forms for create posts */}
                <Route path={`${match.url}/:channel?`} render={props => (
                    <Publishing passPrivacity={this.passChannelPrivacity()} {...props} />
                )} />
                {/* Render all filtered posts */}
                <NoSSR onSSR={ <WrapPreload count={4} /> }>
                    <section className="wrap-publishied-entries">
                        { !isLoading &&
                            !isAdding &&
                                this.passChannelPrivacity() &&
                                    <NoResults hasResults={!!this.state.ids.length} message={formatMessage('community/no_results')} />
                        }
                        { isAdding && renderPreload(1) }
                        { this.passChannelPrivacity() ?
                            this.state.ids.map(renderEntries(listId))
                            :
                            null
                        }
                        { isLoading && renderPreload(4) }
                        { this.passChannelPrivacity() ?
                            <LoadMoreBound listId={listId} isLoading={isLoading} />
                            :
                            null
                        }
                    </section>
                </NoSSR>
            </div>
        )
    }
}

WallEntries.propTypes = {
    listActions: PropTypes.shape({
        showByState: PropTypes.func.isRequired
    }),
    isLoading: PropTypes.bool.isRequired,
    isAdding: PropTypes.bool.isRequired,
    pageQuery: PropTypes.object.isRequired,
    results: PropTypes.arrayOf(
        PropTypes.object
    ).isRequired,
    listId: PropTypes.string.isRequired,
    ownerData: PropTypes.object.isRequired,
    channels: PropTypes.arrayOf(
        PropTypes.object
    ).isRequired
};

WallEntries.defaultProps = {
    isLoading: false,
    isAdding: false,
    results: [],
    listId: ''
};

const mapStateToProps = state => ({
    isAdding: state.recipeEntries.get('isAdding'),
    pageQuery: currentQuery(state.recipeEntries, listIdWall).query,
    ownerData: state.session.user,
    channels: state.channel.channels
});
const mapDispatchToProps = (dispatch, ownProps) => ({
    listActions: bindActionCreators(actionCreators(ownProps), dispatch)
});

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(decorators.tabulate(WallEntries)))

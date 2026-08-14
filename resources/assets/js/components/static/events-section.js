// resources/assets/js/components/static/articles-section.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import tabulateByState from '../decorators/tabulateByState';
import { Link, withRouter } from 'react-router-dom';
import laroute from '../../helpers/laroute';
import { actionCreators } from '../../stores/event';
import NoSSR from 'react-no-ssr';
import Misc from '../../helpers/misc';
import { thumbs } from '../../helpers/states';
import moment from 'moment';
import { loadSVGItemAnimation } from '../../init-app';
import { range } from 'lodash';

// app components
import NoResults from '../no-results';
import Preload from '../preload';

const renderPreload = (count) => {
    return range(count).map(val => (
        <li key={val}>
            <Preload
                style={{ marginBottom:'2px' }}
                preload={ loadSVGItemAnimation }
                image={ thumbs.preloadItem() }
            />
        </li>
    ))
}

const WrapPreload = ({ count=0 }) => (
    <div className="content-courses-summary content-data-list">
        <ul className="events-section-list no-bullet">
            {renderPreload(count)}
        </ul>
    </div>
);

const renderEvents = () => {
    return (event) => (
        <li key={event.urlEvento}>
            <a href={ Misc.urlFull(laroute.route('calendario.evento.show', { evento: event.urlEvento })) } className="card-event-summary card-data-info">
                <p className="text-xmd dark-text normal-text">{event.nombreEvento}</p>
                <span className="text-sm gray-base-text">
                    { moment(event.fechaEvento).format('ddd DD [de] MMM') }
                    { moment(event.fechaFinEvento).isValid() &&
                        moment(event.fechaFinEvento).isAfter(event.fechaEvento)
                        ?
                        ` - ${moment(event.fechaFinEvento).format('ddd DD [de] MMM')}`
                        :
                        ''
                    }
                </span>
            </a>
        </li>
    );
};

class EventsSection extends Component {
    constructor(props) {
        super(props);

        // initial attributes
        this.previousLocation = props.location;
    }

    componentWillUpdate(nextProps) {
        const { location } = this.props;

        // set previousLocation if props.location is not modal
        if (
            nextProps.history.action !== 'POP' &&
            (!location.state || !location.state.modal)
        ) {
            this.previousLocation = this.props.location
        }
    }

    render() {
        const { results, isLoading, match, location } = this.props;

        const isModal = !!(
          location.state &&
          location.state.modal &&
          this.previousLocation !== location // not initial render
        );

        return(
            <div className="events-summary-section panel-content with-title radius-tablet-up show-for-tablet-up">
                <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
                    <span className="left">Próximos eventos</span>
                    <i className="mdi mdi-calendar mdi-18 gray-light vcenter"></i>
                </h6>
                <NoSSR onSSR={ <WrapPreload count={4} /> }>
                    <div className="content-events-summary content-data-list">
                        { !isLoading &&
                            <NoResults hasResults={!!results.length} message={`No hay eventos para el canal`} />
                        }
                        <ul className="events-section-list no-bullet">
                             { results.map(renderEvents()) }
                             { isLoading && renderPreload(4) }
                        </ul>
                    </div>
                </NoSSR>
                <div className="panel-action">
                    <ul className="inline-list-grid align-center text-sm">
                        <li className="text-left">
                            <a href={Misc.urlFull(laroute.route('calendario.index'))}>Ver más</a>
                        </li>
                        <li className="text-right">
                            <Link
                                to={{
                                    pathname: `${this.previousLocation.pathname}${match.isExact ? '/general' : ''}/create/event`,
                                    state: {
                                        modal: true
                                    }
                                }}
                                className="button xtiny inst-secondary-outline radius btn-lowerc btn-clean-margin">
                                <i className="mdi mdi-plus mdi-14 vcenter icon-btn"></i>
                                Crear
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        );
    }
}

EventsSection.propTypes = {
    match: PropTypes.object.isRequired,
    location: PropTypes.object.isRequired,
    results: PropTypes.arrayOf(
        PropTypes.object
    ).isRequired,
    isLoading: PropTypes.bool.isRequired,
    listId: PropTypes.string.isRequired
};

EventsSection.defaultProps = {
    isLoading: false,
    listId: '',
    results: []
};

const mapDispatchToProps = dispatch => bindActionCreators({
    loadByState: actionCreators.loadShallowesByChannel
}, dispatch);

export default withRouter( connect(null, mapDispatchToProps)(tabulateByState(EventsSection)) )

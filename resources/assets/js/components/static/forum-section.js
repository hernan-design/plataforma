// resources/assets/js/components/static/forum-section.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import tabulateByState from '../decorators/tabulateByState';
import { Link, withRouter } from 'react-router-dom';
import laroute from '../../helpers/laroute';
import { composables } from '../../stores/paginator';
import NoSSR from 'react-no-ssr';
import Misc, { strToNickname } from '../../helpers/misc';
import { thumbs } from '../../helpers/states';
import moment from 'moment';
import { loadSVGItemAnimation } from '../../init-app';
import { range } from 'lodash';
import $ from 'jquery';

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
    <div className="content-forums-summary content-data-list">
        <ul className="forums-section-list no-bullet">
            {renderPreload(count)}
        </ul>
    </div>
);

const renderForums = ({ ellipsisToRef }) => {
    return (forum) => (
        <li key={forum.codigoForo}>
            <a href={ Misc.urlFull(laroute.route('foro.categoria.tema', { category: forum.urlCategoriaForo, theme: forum.urlForo })) } className="card-forum-summary card-data-info">
                <p className="text-xmd dark-text normal-text" style={styles.textForum} ref={node => { ellipsisToRef(node); }}>{forum.tituloForo}</p>
                <span className="text-sm gray-base-text linear-span">
                    Creado por
                    &nbsp;
                    <span className="gray-dark-text" title={forum.nombreUsuario}>{ strToNickname(forum.nicknameUsuario) }</span>
                    &nbsp;
                    {moment(`${forum.fechaAperturaForo} ${forum.horaAperturaForo}`).fromNow()}
                </span>
            </a>
        </li>
    );
};

class ForumsSection extends Component {
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

    ellipsisToRef(el) {
        let $el = $(el);

        if( $el.length && ({}).hasOwnProperty.call($.fn, 'dotdotdot') ) {
            $el.dotdotdot();
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
            <div className="forums-summary-section panel-content with-title radius-tablet-up" hidden>
                <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
                    <span className="left">Foros</span>
                    <i className="mdi mdi-forum mdi-18 gray-light vcenter"></i>
                </h6>
                <NoSSR onSSR={ <WrapPreload count={4} /> }>
                    <div className="content-forums-summary content-data-list">
                        { !isLoading &&
                            <NoResults hasResults={!!results.length} message={`No hay entradas de foro para el canal`} />
                        }
                        <ul className="forums-section-list no-bullet">
                             { results.map(renderForums({ ellipsisToRef: this.ellipsisToRef })) }
                             { isLoading && renderPreload(4) }
                        </ul>
                    </div>
                </NoSSR>
                <div className="panel-action">
                    <ul className="inline-list-grid align-center text-sm">
                        <li className="text-left">
                            <a href={Misc.urlFull(laroute.route('foro.index'))}>Ver más</a>
                        </li>
                        <li className="text-right">
                            <Link
                                to={{
                                    pathname: `${this.previousLocation.pathname}${match.isExact ? '/general' : ''}/create/forum`,
                                    state: {
                                        modal: true
                                    }
                                }}
                                className="button xtiny inst-secondary-outline radius btn-lowerc btn-clean-margin"
                            >
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

ForumsSection.propTypes = {
    match: PropTypes.object.isRequired,
    location: PropTypes.object.isRequired,
    results: PropTypes.arrayOf(
        PropTypes.object
    ).isRequired,
    isLoading: PropTypes.bool.isRequired,
    listId: PropTypes.string.isRequired
};

ForumsSection.defaultProps = {
    isLoading: false,
    listId: '',
    results: []
};

const styles = {
    textForum: {
        overflow: 'hidden',
        maxHeight: '40px'
    }
};

const mapDispatchToProps = (dispatch, ownProps) => bindActionCreators({
    loadByState: composables({ listId: ownProps.listId }).showByState
}, dispatch);

export default withRouter( connect(null, mapDispatchToProps)(tabulateByState(ForumsSection)) )

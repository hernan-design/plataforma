// resources/assets/js/components/forum/static/latest-forums.js
import React from 'react';
import PropTypes from 'prop-types';
import { decorators } from '@orange-marmalade/paginate-this';
import NoSSR from 'react-no-ssr';
import { withRouter, NavLink, Link } from 'react-router-dom';
import laroute from '../../../helpers/laroute';
import { imageDefault, strToNickname } from '../../../helpers/misc';
import moment from 'moment';
import $ from 'jquery';

// app components
import NoResults from '../../no-results';
import renderPreload from '../../decorators/renderPreloadItems';

const WrapPreload = ({ count=0 }) => (
    <div className="content-latest-forums">
        <ul className="latest-forums-list no-bullet">
            {renderPreload(count)}
        </ul>
    </div>
);

const renderThemes = ({ ellipsisToRef }) => {
    return (forum) => (
        <li key={forum.codigoForo}>
            <Link
                to={laroute.route('foro.categoria.tema', {
                    category: forum.urlCategoriaForo,
                    theme: forum.urlForo
                })}
                className="card-data-info"
            >
                <p className="text-xmd dark-text normal-text" style={styles.textForum} ref={node => { ellipsisToRef(node); }}>{forum.tituloForo}</p>
                <span className="text-sm gray-base-text linear-span">
                    Creado por
                    &nbsp;
                    <span className="gray-dark-text" title={forum.nombreUsuario}>{ strToNickname(forum.nicknameUsuario) }</span>
                    &nbsp;
                    {moment(`${forum.fechaAperturaForo} ${forum.horaAperturaForo}`).fromNow()}
                </span>
            </Link>
        </li>
    );
};

const LatestForums = ({ location, results, isLoading }) => {

    const ellipsisToRef = (el) => {
        let $el = $(el);

        if( $el.length && ({}).hasOwnProperty.call($.fn, 'dotdotdot') ) {
            $el.dotdotdot();
        }
    }

    return(
        <div className="latest-forums-section panel-content with-title radius-tablet-up">
            <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
                <span className="left">Últimos temas</span>
                <i className="mdi mdi-forum mdi-18 gray-light vcenter"></i>
            </h6>
            <NoSSR onSSR={ <WrapPreload count={4} /> }>
                <div className="content-latest-forums">
                    { !isLoading &&
                        <NoResults hasResults={!!results.length} />
                    }
                    <ul className="latest-forums-list no-bullet">
                        { results.map(renderThemes({ ellipsisToRef: ellipsisToRef })) }
                        { isLoading && renderPreload(4) }
                    </ul>
                </div>
            </NoSSR>
        </div>
    );

};

LatestForums.defaultProps = {
    results: [],
    isLoading: false
};

const styles = {
    textForum: {
        overflow: 'hidden',
        maxHeight: '40px'
    }
};

export default withRouter(decorators.tabulate(LatestForums))

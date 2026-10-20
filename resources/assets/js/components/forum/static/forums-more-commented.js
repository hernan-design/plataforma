// resources/assets/js/components/forum/static/forums-more-commented.js
import React from 'react';
import PropTypes from 'prop-types';
import { decorators } from '@orange-marmalade/paginate-this';
import NoSSR from 'react-no-ssr';
import { withRouter, NavLink, Link } from 'react-router-dom';
import laroute from '../../../helpers/laroute.js';
import { imageDefault } from '../../../helpers/misc';
import { thumbs } from '../../../helpers/states';

// app components
import NoResults from '../../no-results';
import Preload from '../../preload';
import renderPreload from '../../decorators/renderPreloadItems';

const WrapPreload = ({ count=0 }) => (
    <div className="content-forum-more-commented">
        <ul className="forums-more-commented-list no-bullet">
            {renderPreload(count)}
        </ul>
    </div>
);

const renderThemes = () => {
    return (forum) => (
        <li key={forum.codigoForo}>
            <Link
                to={laroute.route('foro.categoria.tema', {
                    category: forum.urlCategoriaForo,
                    theme: forum.urlForo
                })}
                className="card-data-info"
            >
                <ul className="inline-list-grid align-top no-bullet">
                    <li className="has-image">
                        <img src={forum.imagenUsuario} alt={forum.nombreUsuario} className="rounded-img size35" onError={e => { imageDefault(e.target, thumbs.avatar()) }} />
                    </li>
                    <li>
                        <p className="text-sm dark-text">{forum.tituloForo}</p>
                        <ul className="inline-list-items text-xsm gray-light-text">
                            <li>
                                <span>
                                    <i className="mdi mdi-comment-outline mdi-14 gutter-right vcenter"></i>
                                    <span>{forum.contadorComentario}</span>
                                </span>
                            </li>
                        </ul>
                    </li>
                </ul>
            </Link>
        </li>
    );
};

const ForumsMoreCommented = ({ location, results, isLoading }) => (
    <div className="forums-more-commented-section panel-content with-title radius-tablet-up">
        <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
            <span className="left">Temas más comentados</span>
            <i className="mdi mdi-comment-multiple-outline mdi-18 gray-light vcenter"></i>
        </h6>
        <NoSSR onSSR={ <WrapPreload count={4} /> }>
            <div className="content-forums-more-commented">
                { !isLoading &&
                    <NoResults hasResults={!!results.length} />
                }
                <ul className="forums-more-commented-list no-bullet">
                    { results.map(renderThemes()) }
                    { isLoading && renderPreload(4) }
                </ul>
            </div>
        </NoSSR>
        <div className="panel-action">
            <ul className="inline-list-grid align-center text-sm">
                <NavLink to={{ pathname: `${location.pathname}`, search: '?filterBy=more-commented' }}>Ver más</NavLink>
            </ul>
        </div>
    </div>
);

ForumsMoreCommented.defaultProps = {
    results: [],
    isLoading: false
};

export default withRouter(decorators.tabulate(ForumsMoreCommented))

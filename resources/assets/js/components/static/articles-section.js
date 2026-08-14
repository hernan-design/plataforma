// resources/assets/js/components/static/articles-section.js
import React from 'react';
import PropTypes from 'prop-types';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import tabulateByState from '../decorators/tabulateByState';
import { withRouter } from 'react-router-dom';
import laroute from '../../helpers/laroute';
import { actionCreators } from '../../stores/article';
import NoSSR from 'react-no-ssr';
import Misc, { imageDefault } from '../../helpers/misc';
import { thumbs } from '../../helpers/states';
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
    <div className="content-article-summary content-data-list">
        <ul className="articles-section-list no-bullet">
            {renderPreload(count)}
        </ul>
    </div>
);

const renderArticles = ({ ellipsisToRef }) => {
    return (article) => (
        <li key={article.codigoContenido}>
            <a
                href={Misc.urlFull(laroute.route('blog.categoria.articulo', {
                    category: article.urlTipoContenido,
                    article: article.urlContenido
                }))}
                className="card-article-summary card-data-info"
            >
                <ul className="inline-list-grid align-top no-bullet">
                    <li className="has-image">
                        <img src={article.imagenContenido} className="rounded-img size40" onError={e => { imageDefault(e.target, thumbs.global()) }} />
                    </li>
                    <li>
                        <p className="text-sm dark-text" style={styles.textArticle} ref={node => { ellipsisToRef(node); }}>{article.resumenContenido}</p>
                    </li>
                </ul>
            </a>
        </li>
    );
};

const ArticlesSection = ({ results, isLoading }) => {

    const ellipsisToRef = el => {
        let $el = $(el);

        if( $el.length && ({}).hasOwnProperty.call($.fn, 'dotdotdot') ) {
            $el.dotdotdot();
        }
    };

    return(
        <div className="articles-summary-section panel-content with-title radius-tablet-up show-for-tablet-up">
            <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
                <span className="left">Artículos</span>
                <i className="mdi mdi-pen mdi-18 gray-light vcenter"></i>
            </h6>
            <NoSSR onSSR={ <WrapPreload count={4} /> }>
                <div className="content-article-summary content-data-list">
                    { !isLoading &&
                        <NoResults hasResults={!!results.length} message={`No hay artículos para el canal`} />
                    }
                    <ul className="articles-section-list no-bullet">
                        { results.map(renderArticles({ ellipsisToRef })) }
                        { isLoading && renderPreload(4) }
                    </ul>
                </div>
            </NoSSR>
            <div className="panel-action">
                <ul className="inline-list-grid align-center text-sm">
                    <li className="text-left">
                        <a href={ Misc.urlFull(laroute.route('blog.index')) }>Ver más</a>
                    </li>
                    <li className="text-right">
                        <a href={ Misc.urlFull(laroute.route('blog.create')) } className="button xtiny inst-secondary-outline radius btn-lowerc btn-clean-margin">
                            <i className="mdi mdi-plus mdi-14 vcenter icon-btn"></i>
                            Crear
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    );
}

ArticlesSection.propTypes = {
    results: PropTypes.arrayOf(
        PropTypes.object
    ).isRequired,
    isLoading: PropTypes.bool.isRequired,
    listId: PropTypes.string.isRequired
};

ArticlesSection.defaultProps = {
    isLoading: false,
    listId: '',
    results: []
};

const styles = {
    textArticle: {
        overflow: 'hidden',
        maxHeight: '50px'
    }
};

const mapDispatchToProps = dispatch => bindActionCreators({
    loadByState: actionCreators.loadShallowesByChannel
}, dispatch);

export default withRouter( connect(null, mapDispatchToProps)(tabulateByState(ArticlesSection)) )

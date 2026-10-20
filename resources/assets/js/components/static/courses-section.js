// resources/assets/js/components/static/courses-section.js
import React from 'react';
import PropTypes from 'prop-types';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import tabulateByState from '../decorators/tabulateByState';
import { withRouter } from 'react-router-dom';
import laroute from '../../helpers/laroute.js';
import { actionCreators } from '../../stores/course';
import NoSSR from 'react-no-ssr';
import Misc, { imageDefault } from '../../helpers/misc';
import { thumbs } from '../../helpers/states';
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
        <ul className="courses-section-list no-bullet">
            {renderPreload(count)}
        </ul>
    </div>
);

const renderCourses = ({ ellipsisToRef }) => {
    return (course) => (
        <li key={course.codigoCurso}>
            <a
                href={ Misc.urlFull(laroute.route('aprende.categoria.curso', {
                    type: course.urlTipoCurso,
                    category: course.urlCategoriaCurso,
                    course: course.urlCurso
                })) }
                className="card-courses-summary card-data-info"
            >
                <ul className="inline-list-grid align-top no-bullet">
                    <li className="has-image">
                        <img src={course.imagenCurso} className="rounded-img size40" onError={e => { imageDefault(e.target, thumbs.global()) }} />
                    </li>
                    <li>
                        <p className="text-sm dark-text" style={styles.textCourse} ref={node => { ellipsisToRef(node); }}>{course.nombreCurso}</p>
                    </li>
                </ul>
            </a>
        </li>
    );
};

const CoursesSection = ({ results, isLoading}) => {

    const ellipsisToRef = el => {
        let $el = $(el);

        if( $el.length && ({}).hasOwnProperty.call($.fn, 'dotdotdot') ) {
            $el.dotdotdot();
        }
    };

    return(
        <div className="courses-summary-section panel-content with-title radius-tablet-up">
            <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
                <span className="left">Cursos que te pueden interesar</span>
                <i className="mdi mdi-school mdi-18 gray-light vcenter"></i>
            </h6>
            <NoSSR onSSR={ <WrapPreload count={4} /> }>
                <div className="content-courses-summary content-data-list">
                    { !isLoading &&
                        <NoResults hasResults={!!results.length} message={`No hay cursos para el canal`} />
                    }
                    <ul className="courses-section-list no-bullet">
                        { results.map(renderCourses({
                            ellipsisToRef
                        })) }
                        { isLoading && renderPreload(4) }
                    </ul>
                </div>
            </NoSSR>
            <div className="panel-action">
                <ul className="inline-list-grid align-center text-sm">
                    <li className="text-left">
                        <a href={ Misc.urlFull(laroute.route('aprende.index')) }>Ver más</a>
                    </li>
                </ul>
            </div>
        </div>
    );
};

CoursesSection.propTypes = {
    results: PropTypes.arrayOf(
        PropTypes.object
    ).isRequired,
    isLoading: PropTypes.bool.isRequired,
    listId: PropTypes.string.isRequired
};

CoursesSection.defaultProps = {
    isLoading: false,
    listId: '',
    results: []
};

const styles = {
    textCourse: {
        overflow: 'hidden',
        maxHeight: '50px'
    }
};

const mapDispatchToProps = dispatch => bindActionCreators({
    loadByState: actionCreators.loadShallowesByChannel
}, dispatch);

export default withRouter( connect(null, mapDispatchToProps)(tabulateByState(CoursesSection)) )

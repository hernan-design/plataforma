// resources/assets/js/components/forum/static/related-themes.js
import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { composables } from '../../../stores/paginator';
import tabulateList from '../../decorators/tabulateList';
import NoSSR from 'react-no-ssr';

// app components
import RelatedTopic from './related-topic';
import NoResults from '../../no-results';
import Preload from '../../preload';
import LoadMoreBound from '../../load-more-bound';
import renderPreload from '../../decorators/renderPreloadItems';

const WrapPreload = ({ count=0 }) => (
    <div className="content-related-forums content-data-list">
        <ul className="forums-section-list no-bullet">
            {renderPreload(count)}
        </ul>
    </div>
);

const renderThemes = (listId) => {
    return (id, i) => (
        <RelatedTopic
            key={id || i}
            index={i}
            itemId={id}
            listId={listId}
        />
    );
};

const RelatedThemes = ({ isLoading, ids, listId, title, titleIcon }) => (
    <div className="related-forums-section panel-content with-title radius-tablet-up">
        <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
            <span className="left">{typeof title === 'function' ? title() : title}</span>
            <i className={`mdi ${titleIcon} mdi-21 gray-light vcenter`}></i>
        </h6>
        <NoSSR onSSR={ <WrapPreload count={1} /> }>
            <div className="content-related-forums content-data-list">
                { !isLoading &&
                    <NoResults hasResults={!!ids.length} message={`No hay temas relacionados`} />
                }
                <ul className="forums-section-list no-bullet">
                     { ids.map(renderThemes(listId)) }
                     { isLoading && renderPreload(1) }
                </ul>
                <LoadMoreBound listId={listId} isLoading={isLoading} isButton />
            </div>
        </NoSSR>
    </div>
);

RelatedThemes.propTypes = {
    listId: PropTypes.string.isRequired,
    ids: PropTypes.array.isRequired,
    isLoading: PropTypes.bool.isRequired,
    title: PropTypes.oneOfType([
        PropTypes.func,
        PropTypes.string
    ]),
    titleIcon: PropTypes.string,
    filterData: PropTypes.object.isRequired
};
RelatedThemes.defaultProps = {
    listId: '',
    ids: [],
    isLoading: false,
    title: '',
    titleIcon: 'mdi-file-tree'
};

const mapDispatchToProps = (dispatch, ownProps) => ({
    listActions: bindActionCreators(composables({ listId: ownProps.listId }), dispatch)
});

export default connect(null, mapDispatchToProps)(tabulateList(RelatedThemes));

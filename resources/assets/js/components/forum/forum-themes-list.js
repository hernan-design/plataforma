// resources/assets/js/components/forum/forum-themes-list.js
import React from 'react';
import PropTypes from 'prop-types';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import tabulateList from '../decorators/tabulateList';
import { composables } from '../../stores/paginator';
import { loadSVGItemAnimation, formatMessage } from '../../init-app';
import { thumbs } from '../../helpers/states';
import { range } from 'lodash';
import NoSSR from 'react-no-ssr';

// app components
import ForumThemeItem from './forum-theme-item';
import renderPreload from '../decorators/renderPreloadItems';
import LoadMoreBound from '../load-more-bound';
import NoResults from '../no-results';

const renderThemes = (listId) => {
    return (id, i) => (
        <ForumThemeItem
            key={id}
            index={i}
            itemId={id}
            listId={listId}
        />
    );
};

const WrapPreload = ({ count=0 }) => (<ul className="forums-section-list no-bullet">{renderPreload(count)}</ul>);

const ForumThemesList = ({ listId, ids, isLoading, canLoadMore }) => (
    <div className="forum-list-content panel-content radius-tablet-up">
        <NoSSR onSSR={ <WrapPreload count={1} /> }>
            <ul className="forums-section-list no-bullet">
                {/* Render themes item */}
                { !isLoading && <NoResults hasResults={!!ids.length} message={formatMessage('forum/no_results')} /> }
                { ids.map(renderThemes(listId)) }
                { isLoading && renderPreload(1) }
            </ul>
        </NoSSR>
        {canLoadMore && <LoadMoreBound listId={listId} isLoading={isLoading} /> }
    </div>
);

ForumThemesList.propTypes = {
    listId: PropTypes.string.isRequired,
    ids: PropTypes.array.isRequired,
    canLoadMore: PropTypes.bool
};

ForumThemesList.defaultProps = {
    listId: '',
    ids: [],
    isLoading: false,
    canLoadMore: true
};

const mapDispatchToProps = (dispatch, ownProps) => ({
    listActions: bindActionCreators(composables(ownProps), dispatch)
});

export default connect(null, mapDispatchToProps)(tabulateList(ForumThemesList))

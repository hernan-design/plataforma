// resources/assets/js/components/discussion/discussion-list.js
import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { composables } from '../../stores/paginator';
import tabulateList from '../decorators/tabulateList';
import { loadSVGItemAnimation } from '../../init-app';
import { thumbs } from '../../helpers/states';
import { range } from 'lodash';
import { formatMessage } from '../../init-app';

// app components
import Preload from '../preload';
import EditorPublishComment from './form/editor-publish-comment';
import DiscussionItem from './discussion-item';
import NoResults from '../no-results';
import LoadMoreBound from '../load-more-bound';

const renderDiscussions = (listId) => {
    return (id, i) => (
        <DiscussionItem
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
            preload={ loadSVGItemAnimation }
            image={ thumbs.preloadItem() }
            width='100%'
            height='100%'
        />
    ))
}

const DiscussionList = ({ className, listId, isLoading, isAdding, pageActions, listActions, ids, results, filterData, ...props }) => {
    const passFields = {
        'codigo_modulo': filterData.codigo_modulo,
        'codigo_recurso_modulo': filterData.codigo_recurso_modulo
    };

    return(
        <div className={`discussion-wrapper ${className}`}>
            <EditorPublishComment
                listId={listId}
                addFields={passFields}
                {...props}
            />
            <section className="discussion-posts-list">
                { !isLoading &&
                    !isAdding &&
                        <NoResults hasResults={!!ids.length} message={formatMessage('discussion/no_results')} />
                }
                {/* render discussions */}
                { isAdding && renderPreload(1) }
                { ids.map(renderDiscussions(listId)) }
                { isLoading && renderPreload(1) }
                <LoadMoreBound listId={listId} isLoading={isLoading} isButton />
            </section>
        </div>
    );
};

DiscussionList.propTypes = {
    formId: PropTypes.string,
    className: PropTypes.string,
    listActions: PropTypes.shape({
        showByStates: PropTypes.func.isRequired
    }),
    isLoading: PropTypes.bool.isRequired,
    isAdding: PropTypes.bool.isRequired,
    ids: PropTypes.array.isRequired,
    listId: PropTypes.string.isRequired,
    filterData: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.object
    ]).isRequired
};

DiscussionList.defaultProps = {
    formId: '',
    className: '',
    isLoading: false,
    isAdding: false,
    ids: [],
    listId: ''
};

const mapDispatchToProps = (dispatch, ownProps) => ({
    listActions: bindActionCreators(composables(ownProps), dispatch)
});

export default connect(null, mapDispatchToProps)(tabulateList(DiscussionList))

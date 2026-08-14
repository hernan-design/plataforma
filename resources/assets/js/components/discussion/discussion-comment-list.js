// resources/assets/js/components/discussion/discussion-comment-list.js
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
import DiscussionCommentItem from './discussion-comment-item';
import NoResults from '../no-results';
import LoadMoreBound from '../load-more-bound';

const createMarkup = (markup) => {
  return {__html: markup};
}

const renderComments = (listId) => {
    return (id, i) => (
        <DiscussionCommentItem
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

const DiscussionCommentList = ({ className, listId, isLoading, isAdding, pageActions, listActions, ids, results, filterData, filterValue, ownerData, ...props }) => {

    return(
        <div className={`post-comments-box discussion-comments-box ${className}`}>
            <section className="discussion-comments-list">
                { !isLoading &&
                    !isAdding &&
                        <NoResults hasResults={!!ids.length} message={formatMessage('comment/no_results')} />
                }
                {/* Render user commnet */}
                { ids.map(renderComments(listId)) }
                { (isLoading || isAdding) && renderPreload(1) }
                <LoadMoreBound listId={listId} isLoading={isLoading} isButton />
            </section>

            { !!Object.keys(ownerData).length &&
                <div className="user-comment discussion-user-comment">
                    <EditorPublishComment
                        listId={listId}
                        name='texto_comentario_discucion'
                        addDirection='end'
                        autoFocus={false}
                        addFields={{
                            codigo_discucion: filterValue
                        }}
                        {...props}
                    />
                </div>
            }
        </div>
    );
}

DiscussionCommentList.propTypes = {
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
    ]).isRequired,
    filterValue: PropTypes.any.isRequired
};

DiscussionCommentList.defaultProps = {
    formId: '',
    className: '',
    isLoading: false,
    isAdding: false,
    ids: [],
    listId: '',
    ownerData: {}
};

const mapStateToProps = (state, ownProps) => ({
    ownerData: state.session.user
});

const mapDispatchToProps = (dispatch, ownProps) => ({
    listActions: bindActionCreators(composables(ownProps), dispatch)
});

export default connect(mapStateToProps, mapDispatchToProps)(tabulateList(DiscussionCommentList))

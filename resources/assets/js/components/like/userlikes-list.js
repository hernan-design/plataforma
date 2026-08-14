// resources/assets/js/components/like/userlikes-list.js
import React from 'react';
import PropTypes from 'prop-types';
import { decorators } from '@orange-marmalade/paginate-this';
import { loadSVGItemAnimation, formatMessage } from '../../init-app';
import { thumbs } from '../../helpers/states';
import { range } from 'lodash';

// app components
import UserLikes from './userlikes';
import NoResults from '../no-results';
import Preload from '../preload';
import LoadMoreBound from '../load-more-bound';

const renderUserLike = (listId) => {
    return (id, i) => (
        <UserLikes
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

const UserLikesList = ({ listId, isLoading, ids }) => (
    <ul className="list-separator no-bullet">
        { !isLoading &&
            <NoResults hasResults={!!ids.length} message={formatMessage('like/no_results')} />
        }
        {ids.map(renderUserLike(listId))}
        {isLoading && renderPreload(1)}
        <LoadMoreBound listId={listId} isLoading={isLoading} isButton />
    </ul>
);

UserLikesList.propTypes = {
    ids: PropTypes.array.isRequired,
    listId: PropTypes.string.isRequired,
    isLoading: PropTypes.bool
};

UserLikesList.defaultProps = {
    ids: [],
    isLoading: false
};

export default decorators.tabulateLean(UserLikesList)

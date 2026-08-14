// resources/assets/js/components/discussion/discussion-comment-item.js
import React from 'react';
import PropTypes from 'prop-types';
import Misc from '../../helpers/misc';
import { thumbs, getResource } from '../../helpers/states';
import moment from 'moment';
import { decorators } from '@orange-marmalade/paginate-this';
import { namedContent } from '../../helpers/redux-utils';
import { RECIPE_ID as recipeIdLike, LIST_ID as listIdLike } from '../../stores/like';

// app components
import Like from '../like/like';

const createMarkup = (markup) => {
  return {__html: markup};
}

const DiscussionCommentItem = ({ record, ...props }) => {
    // initial attributes
    const configShowMore = {
        'container': '.container-more',
        'maxlen': 250
    };

    const showMore = (nodeTxt) => {
        Misc.showMore({
            ...configShowMore,
            container: nodeTxt
        });
    }

    const recipeIdLikeNamed = `${recipeIdLike}_${record.cod}_${namedContent(getResource('discusion.comentario'), true)}`;
    const listIdLikeNamed = `${listIdLike}_${record.cod}_${namedContent(getResource('discusion.comentario'), true)}`;

    return(
        <article className="user-comment">
            <ul className="inline-list-grid align-top no-spacing">
                <li className="has-image">
                    <a href={Misc.urlFull(record.urlProfile)} className="rounded-thumb no-outline" title={record.nombreUsuario}>
                        <img src={record.imagenUsuario} alt={Misc.strToNickname(record.nicknameUsuario)} className="rounded-img size25" onError={e => { Misc.imageDefault(e.target, thumbs.avatar()) }} />
                    </a>
                </li>
                <li>
                    <ul className="inline-list-grid align-top no-spacing">
                        <li>
                            <a href={Misc.urlFull(record.urlProfile)} title={record.nombreUsuario} className="nickname-comment-post text-md inst-color-secondary">{ Misc.strToNickname(record.nicknameUsuario) }</a>
                            <span className="text-xsm light-text">&nbsp;&bull;&nbsp;</span>
                            <span className="text-sm light-text">{moment([record.fechaComentario, record.horaComentario].join(' ')).format("MMMM DD [de] YYYY, h:mm a")}</span>
                        </li>
                    </ul>

                    {/* comment content box */}
                    <div className="comment-content-post">
                        <div
                            className="text-description-comment container-more"
                            dangerouslySetInnerHTML={createMarkup(record.textoComentario)}
                            ref={node => { showMore(node); }}
                        />
                    </div>

                    <ul className="comment-icons-list">
                        <li>
                            <Like
                                recipeId={recipeIdLikeNamed}
                                listId={listIdLikeNamed}
                                parentSrcparams={record.srcparams}
                                idDrop={`drop-ilike-entry-${record.cod}`}
                                iconSize={14}
                            />
                        </li>
                    </ul>
                </li>
            </ul>
        </article>
    );
}

DiscussionCommentItem.propTypes = {
    listId: PropTypes.string.isRequired,
    record: PropTypes.object.isRequired,
    updating: PropTypes.bool,
    removing: PropTypes.bool
};

DiscussionCommentItem.defaultProps = {
    listId: '',
    record: {},
    updating: false,
    removing: false
};

export default decorators.withRecordProps(DiscussionCommentItem)

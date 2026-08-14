// resources/assets/js/pages/forum/forum-detail.js
import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { RELATED_LIST_ID as relatedForumListId, AUTHOR_LIST_ID as authorForumListId } from '../../stores/forum';
import Misc, { strToNickname } from '../../helpers/misc';
import laroute from '../../helpers/laroute';
import { formatMessage } from '../../init-app';

// app components
import ForumTheme from '../../components/forum/forum-theme';
import RelatedThemes from '../../components/forum/static/related-themes';

const ForumDetail = ({ match, forum }) => (
    <div id="forum-detail-wrap">
        <div className="row">
            <div className="small-7 columns">
                {/* Render forum theme */}
                <ForumTheme />
            </div>
            <div className="small-5 columns">
                {/* Show static sections */}
                <aside className="right-aside-wrapper">
                    <RelatedThemes
                        listId={relatedForumListId}
                        title={formatMessage('forum/static/related_themes_title')}
                        titleIcon="mdi-file-tree"
                        filterData={{
                            url_foro: match.params.theme
                        }}
                    />
                    { forum &&
                        <RelatedThemes
                            listId={authorForumListId}
                            titleIcon="mdi-account"
                            filterData={{
                                url_foro: match.params.theme,
                                nickname: forum.nicknameUsuario
                            }}
                            title={() => (
                                <span>
                                    Otros temas por
                                    &nbsp;
                                    <a href={ Misc.urlFull(laroute.route('usuario.nickname', {nickname:forum.nicknameUsuario})) } className="dark-text">{strToNickname(forum.nicknameUsuario)}</a>
                                </span>
                            )}
                        />
                    }
                </aside>
            </div>
        </div>
    </div>
);

const mapStateToProps = state => ({
    forum: state.forum.forum
});

export default connect(mapStateToProps)(ForumDetail)

// resources/assets/js/components/discussion/discussion-item.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import Misc from '../../helpers/misc';
import laroute from '../../helpers/laroute';
import moment from 'moment';
import { decorators } from '@orange-marmalade/paginate-this';
import { actionCreators } from '../../stores/discussion';
import { LIST_ID as listIdDiscussionComment } from '../../stores/discussion-comment';
import { RECIPE_ID as recipeIdLike, LIST_ID as listIdLike } from '../../stores/like';
import { thumbs, getResource } from '../../helpers/states';
import { namedContent } from '../../helpers/redux-utils';
import { formatMessage } from '../../init-app';

// app components
import DiscussionCommentList from './discussion-comment-list';
import Like from '../like/like';
import SpinnerLoader from '../spinner-loader';
import ConfirmWindow from '../confirm-window';

const createMarkup = (markup) => {
  return {__html: markup};
}

class DiscussionItem extends Component {
    constructor(props) {
        super(props);

        // initial attributes
        this.configShowMore = {
            'container': '.container-more',
            'maxlen': 250
        };

        // initial state
        this.state = {
            toggleComments: false,
            confirmingDelete: false
        }

        // binding event handlers
        this.handleComments = this.handleComments.bind(this);
        this.handleDelete = this.handleDelete.bind(this);
        this.confirmDelete = this.confirmDelete.bind(this);
        this.confirmClosed = this.confirmClosed.bind(this);
    }

    handleComments(e) {
        e.preventDefault();

        this.setState((prevState) => ({
            toggleComments: !prevState.toggleComments
        }));
    }

    showMore(nodeTxt) {
        Misc.showMore({
            ...this.configShowMore,
            container: nodeTxt
        });
    }

    handleDelete(e) {
        e.preventDefault();

        this.setState({ confirmingDelete: true });
    }

    confirmDelete() {
        const { deleteDiscussion, itemId, record } = this.props;

        deleteDiscussion({
            itemId,
            discusion: record.codigoDiscucion
        });
    }

    confirmClosed() {
        this.setState({ confirmingDelete: false });
    }

    render() {
        const { record, removing, ...props } = this.props;
        const listIdDiscussionCommentNamed = `${listIdDiscussionComment}_${record.cod}`;
        const recipeIdLikeNamed = `${recipeIdLike}_${record.cod}_${namedContent(getResource('discusion.gestion'), true)}`;
        const listIdLikeNamed = `${listIdLike}_${record.cod}_${namedContent(getResource('discusion.gestion'), true)}`;

        return(
            <article className="discussion-post-box">
                <ul className="inline-list-grid align-top no-spacing">
                    <li className="has-image">
                        <a href={Misc.urlFull(laroute.route('usuario.nickname', {nickname: record.nicknameUsuario}))} className="rounded-thumb no-outline" title={record.nombreUsuario}>
                            <img src={record.imagenUsuario} alt={Misc.strToNickname(record.nicknameUsuario)} className="rounded-img size25" onError={e => { Misc.imageDefault(e.target, thumbs.avatar()) }} />
                        </a>
                    </li>
                    <li>
                        <ul className="inline-list-grid align-center no-spacing">
                            <li>
                                <a href={ Misc.urlFull(laroute.route('usuario.nickname', {nickname: record.nicknameUsuario})) } title={record.nombreUsuario} className="nickname-user-post text-md inst-color-secondary">{ Misc.strToNickname(record.nicknameUsuario) }</a>
                                <span className="text-xsm light-text">&nbsp;&bull;&nbsp;</span>
                                <span className="text-sm light-text">{moment([record.fechaDiscusion].join(' ')).format("MMMM DD [de] YYYY, h:mm a")}</span>
                            </li>
                        </ul>

                        {/* discussion content box */}
                        <div className="post-content-box">
                            <div
                                className="text-description-post container-more"
                                dangerouslySetInnerHTML={createMarkup(record.textoDiscucion)}
                                ref={node => { this.showMore(node); }}
                            />
                        </div>

                        {/* discussion footer box */}
                        <div className="post-footer-box">
                            <ul className="footer-box-icons post-icons-list">
                                <li>
                                    <Like
                                        recipeId={recipeIdLikeNamed}
                                        listId={listIdLikeNamed}
                                        parentSrcparams={record.srcparams}
                                        idDrop={`drop-ilike-entry-${record.cod}`}
                                        iconSize={14}
                                    />
                                </li>
                                <li>
                                    <a href="#" onClick={this.handleComments} className="show-comment-field" title="Haz un comentario">
                                        <i className="icon icon-comment icon-14 gutter-right" />
                                        <span className="data-count-comments">{record.contadorComentariosDiscucion}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        {/* Discussion comments box */}
                        { this.state.toggleComments &&
                            <DiscussionCommentList
                                listId={listIdDiscussionCommentNamed}
                                filterData="codigo_discucion"
                                filterValue={record.codigoDiscucion}
                            />
                        }
                    </li>
                </ul>
                { record.owner &&
                    <a href="#" onClick={this.handleDelete} className="close content-close discussion-post-hide" title="Remover discusión">×</a>
                }
                { this.state.confirmingDelete &&
                    <ConfirmWindow
                        onConfirm={this.confirmDelete}
                        onClosed={this.confirmClosed}
                        className="xtiny"
                        title={formatMessage('discussion/confirm_delete_title')}
                        render={() => <span>{formatMessage('discussion/confirm_delete_message')}</span>}
                    />
                }
                { removing && <SpinnerLoader text={formatMessage('deleting_text')} /> }
            </article>
        );
    }
}

DiscussionItem.propTypes = {
    listId: PropTypes.string.isRequired,
    itemId: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.number
    ]).isRequired,
    record: PropTypes.object.isRequired,
    updating: PropTypes.bool,
    removing: PropTypes.bool,
    deleteDiscussion: PropTypes.func
};

DiscussionItem.defaultProps = {
    listId: '',
    record: {},
    updating: false,
    removing: false,
    deleteDiscussion: () => {}
};

const mapDispatchToProps = (dispatch, ownProps) => bindActionCreators({
    deleteDiscussion: actionCreators(ownProps).deleteDiscussion
}, dispatch);

export default connect(null, mapDispatchToProps)(decorators.withRecordProps(DiscussionItem))

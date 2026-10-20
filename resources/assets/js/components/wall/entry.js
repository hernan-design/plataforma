// resources/assets/js/components/wall/entry.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { decorators } from '@orange-marmalade/paginate-this';
import { formatMessage } from '../../init-app';
import Misc from '../../helpers/misc';
import { getModule } from '../../helpers/states';
import { namedContent } from '../../helpers/redux-utils';
import { LIST_ID as listIdDiscussion } from '../../stores/discussion';
import { RECIPE_ID as recipeIdLike, LIST_ID as listIdLike } from '../../stores/like';

// app components
import UserEntryTop from './user-entry-top';
import PostEntry from './post-entry';
import EventEntry from './event-entry';
import ArticleEntry from './article-entry';
import ForumEntry from './forum-entry';
import CourseEntry from './course-entry';
import DiscussionList from '../discussion/discussion-list';
import EntryActions from './entry-actions';
import SpinnerLoader from '../spinner-loader';
import Like from '../like/like';

// render entry type
const renderEntry = (props) => {
    switch(props.codigoModulo) {
        case getModule('calendar'):
            return <EventEntry {...props} />;
        case getModule('blog'):
            return <ArticleEntry {...props} />;
        case getModule('forum'):
            return <ForumEntry {...props} />;
        case getModule('learn'):
            return <CourseEntry {...props} />;
        default:
            return <PostEntry {...props} />;
    }
};

class Entry extends Component {
    constructor(props) {
        super(props);

        // initial state
        this.state = {
            toggleDiscussion: false
        };

        // initial attributes
        this.configShowMore = {
            'container': '.container-more',
            'maxlen': 300
        };

        // bind event handlers
        this.handleDiscussions = this.handleDiscussions.bind(this);
    }

    componentDidMount() {
        Misc.showMore({
            ...this.configShowMore,
            container: this.nodeTxt
        });
    }

    handleDiscussions(e) {
        e.preventDefault();

        this.setState((prevState) => ({
            toggleDiscussion: !prevState.toggleDiscussion
        }));
    }

    render() {
        const { record, itemId, ownerData, updating, removing } = this.props;
        if (!record || !record.cod) return null;

        const modName = namedContent(record.codigoModulo) || 'Wall';
        const listIdDiscussionNamed = `${listIdDiscussion}_${record.cod}_${modName}`;
        const recipeIdLikeNamed = `${recipeIdLike}_${record.cod}_${modName}`;
        const listIdLikeNamed = `${listIdLike}_${record.cod}_${modName}`;
        const passData = {
            codigo_modulo: record.codigoModulo,
            codigo_recurso_modulo: record.codigoRecursoModulo
        };

        const isOwner = (ownerData && ownerData.codigoUsuario === record.codigoUsuario) || record.isAuthorizedToDelete;

        return(
            <article className="card-published-entry post-entry">
                <div className="card-content-entry">
                    <UserEntryTop {...record}/>
                    {renderEntry({
                        ...record,
                        contentRef: node => { this.nodeTxt = node }
                    })}
                    { isOwner ?
                        (<div>
                            <a className="action-hover-circle icon-21" data-dropdown={`drop-entry-actions-${record.cod}`} aria-controls={`drop-entry-actions-${record.cod}`} aria-expanded={false} data-options="is_hover:false" style={styles.actionActions}>
                                <i className="mdi mdi-dots-vertical"></i>
                            </a>
                            <EntryActions id={`drop-entry-actions-${record.cod}`} itemId={itemId} listId={this.props.listId} />
                        </div>)
                        :
                        null
                    }
                </div>

                <div className="card-action-entry">
                    <ul className="inline-list-grid align-center">
                        <li>
                            <ul className="social-box-icons inline-list-items no-bullet text-xsm normal-text">
                                <li>
                                    <Like
                                        recipeId={recipeIdLikeNamed}
                                        listId={listIdLikeNamed}
                                        parentSrcparams={record.srcparams}
                                        idDrop={`drop-ilike-entry-${record.cod}`}
                                        iconSize={16}
                                    />
                                </li>
                                <li>
                                    <a href="#" onClick={this.handleDiscussions} title="Discusión">
                                        <i className="mdi mdi-comment-outline mdi-16 gutter-right vcenter"></i>
                                        <span>{typeof record.contadorComentario !== 'undefined' ? record.contadorComentario : 0}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {/*<li>
                            <ul className="inline-list-items no-bullet gray-light-text text-right">
                                <li>
                                    <a><i className="mdi mdi-share mdi-21 vcenter"></i></a>
                                </li>
                            </ul>
                        </li>*/}
                    </ul>
                </div>
                { this.state.toggleDiscussion &&
                    <DiscussionList
                        listId={listIdDiscussionNamed}
                        filterData={passData}
                    />
                }
                { removing && <SpinnerLoader text={formatMessage('deleting_text')} /> }
                { updating && <SpinnerLoader text={formatMessage('updating_text')} /> }
            </article>
        );
    }
}

const styles = {
    'actionActions': {
        position: 'absolute',
        top: '20px',
        right: '20px'
    }
};

Entry.propTypes = {
    listId: PropTypes.string.isRequired,
    itemId: PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.string
    ]).isRequired,
    record: PropTypes.object.isRequired,
    updating: PropTypes.bool,
    removing: PropTypes.bool
};

Entry.defaultProps = {
    listId: '',
    record: {},
    updating: false,
    removing: false
}

const mapStateToProps = state => ({
    ownerData: state.session.user
});

export default connect(mapStateToProps)(decorators.withRecordProps(Entry))

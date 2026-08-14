// resources/assets/js/components/forum/forum-theme.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Link } from 'react-router-dom';
import { getModule } from '../../helpers/states';
import { withRouter } from 'react-router-dom';
import { actionCreators } from '../../stores/forum';

// app components
import ForumUserInfo from './forum-user-info';
import TagsList from '../tags-list';
import Like from '../like/like';
import DiscussionList from '../discussion/discussion-list';
import SpinnerLoader from '../spinner-loader';

const createMarkup = (markup) => {
  return {__html: markup};
}

class ForumTheme extends Component {
    constructor(props) {
        super(props);

        // initial state
        this.state = {
            isLoading: false
        };
    }

    componentDidMount() {
        const { history, record } = this.props;
        // initial results fetch
        if(!Object.keys(record).length || history.action !== 'POP') {
            this.refreshResults(this.props.match);
        }
    }

    componentWillReceiveProps(nextProps) {
        const { match:nextMatch } = nextProps;

        if(nextProps.location !== this.props.location) {
            this.refreshResults(nextMatch);
        }
    }

    shouldComponentUpdate(nextProps, nextState) {
        return !!(nextProps.record !== this.props.record ||
            nextState.isLoading !== this.state.isLoading);
    }

    refreshResults(match) {
        const { loadForum } = this.props;

        if(typeof loadForum === 'function' && match.params.theme) {
            this.setState({ isLoading: true });

            loadForum(match.params.theme).then(() => {
                this.setState({ isLoading: false });
            });
        }
    }

    render() {
        const { record } = this.props;
        const { isLoading } = this.state;

        const recipeIdLikeNamed = 'forumThemeLike';
        const listIdLikeNamed = 'recipeForumLikes';
        const listIdDiscussionNamed = 'recipeForumDiscussion';

        // if record is empty then return null
        if(!Object.keys(record).length) {
            return <SpinnerLoader />;
        }

        const passData = {
            codigo_modulo: getModule('forum'),
            codigo_recurso_modulo: record.codigoForo
        };

        return (
            <article id="forum-theme-detail" className="panel-content radius">
                <h3 className="">{record.tituloForo}</h3>
                <ForumUserInfo {...record} />
                <TagsList tags={record.tags} />

                <hr style={styles.separator} />

                <div className="theme-description" dangerouslySetInnerHTML={createMarkup(record.descripcionForo)} />

                <hr style={styles.separator} />

                <Link to="/foro" className='gray-base-text text-xmd'>
                    <i className="mdi mdi-arrow-left mdi-12"></i> Volver a foro
                </Link>

                <div className="panel-actions">
                    <ul className="inline-list-grid align-center">
                        <li>
                            <ul className="social-box-icons inline-list-items no-bullet text-sm normal-text">
                                <li>
                                    <Like
                                        recipeId={recipeIdLikeNamed}
                                        listId={listIdLikeNamed}
                                        parentSrcparams={record.srcparams}
                                        idDrop={`drop-ilike-theme-${record.cod}`}
                                        iconSize={18}
                                    />
                                </li>
                                <li>
                                    <a title="Discusión">
                                        <i className="mdi mdi-comment-outline mdi-18 gutter-right vcenter"></i>
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
                    <DiscussionList
                        listId={listIdDiscussionNamed}
                        filterData={passData}
                        autoFocus={false}
                    />
                </div>
                { isLoading && <SpinnerLoader /> }
            </article>
        );
    }
};

ForumTheme.propTypes = {
    record: PropTypes.object.isRequired,
    location: PropTypes.object.isRequired,
    match: PropTypes.object.isRequired,
    loadForum: PropTypes.func.isRequired
};

ForumTheme.defaultProps = {
    record: {}
};

const styles = {
    separator: {
        width: '6%'
    }
};

const mapStateToProps = state => ({
    record: state.forum.forum
});

const mapDispatchToProps = dispatch => bindActionCreators({ loadForum: actionCreators.loadForum }, dispatch)

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(ForumTheme))

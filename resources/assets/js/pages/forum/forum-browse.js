// resources/assets/js/pages/forum/forum-browse.js
import React from 'react';
import { Switch, Route } from 'react-router-dom';
import { connect } from 'react-redux';
import {
    LIST_ID as forumsListId,
    MORE_COMMENTED_LIST_ID as moreCommentedForumsListId,
    SHALLOW_LIST_ID as shallowForumListId,
    dynamicRecipes as dynamicRecipeForums
} from '../../stores/forum';

// app components
import PublishingForum from '../../components/forum/publishing-forum';
import ForumCategoriesBrowse from '../../components/forum/forum-categories-browse';
import ForumThemesList from '../../components/forum/forum-themes-list';
import ForumFilters from '../../components/forum/static/forum-filters';
import ForumsMoreCommented from '../../components/forum/static/forums-more-commented';
import LatestForums from '../../components/forum/static/latest-forums';

let previousLocation = null;

const ForumBrowse = ({ match, location, history, queryParams={}, categories=[] }) => {

    React.useEffect(() => {
        if(categories && categories.length) {
            dynamicRecipeForums(categories);
        }
    }, [categories]);

    // set previousLocation if props.location is not modal
    if (
      history.action !== "POP" &&
      (!location.state || !location.state.modal)
    ) {
        previousLocation = location;
    }else if(history.action === "POP" || match.isExact) {
        previousLocation = location;
    }

    // initialize variables to will pass
    const isModal = !!(
        location.state &&
        location.state.modal &&
        previousLocation !== location
    );

    const passFilterData = { ...queryParams };

    return (
        <div id="forum-browse-wrap">
            <div className="row">


                <div className="small-12 tablet-12 medium-3 columns">
                    {/* filters panel */}
                    <ForumFilters />
                </div>


                <div className="small-12 tablet-4 tablet-push-8 medium-3 medium-push-6 columns show-for-tablet-up">
                    {/* static sections */}
                    <ForumsMoreCommented listId={moreCommentedForumsListId} />
                    <LatestForums listId={shallowForumListId} />
                </div>


                <div className="small-12 tablet-8 tablet-pull-4 medium-6 medium-pull-3 columns">
                    <Route path={`${match.url}/:category?`} component={PublishingForum} />
                    {/* forum browse */}
                    <Switch location={isModal ? previousLocation : location}>
                        <Route path={`${match.url}/:category`} render={props => (
                            <ForumThemesList
                                key={props.match.params.category}
                                listId={`${forumsListId}_${props.match.params.category}`}
                                resetStates={true}
                                filterData={{
                                    ...passFilterData,
                                    url_categoria_foro: props.match.params.category
                                }}
                            />
                        )} />
                        <Route path={match.url} render={() => (
                            <ForumCategoriesBrowse filterData={passFilterData} />
                        )} />
                    </Switch>
                </div>


            </div>
        </div>
    );
}

const mapStateToProps = state => ({
    categories: state.forum.categories
});

export default connect(mapStateToProps)(ForumBrowse);

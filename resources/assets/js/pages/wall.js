// resources/assets/js/pages/wall.js
import React from 'react';
import { LIST_ID as listIdWall } from '../stores/wall';
import { SHALLOW_LIST_ID as shallowArticleListId } from '../stores/article';
import { SHALLOW_LIST_ID as shallowEventListId } from '../stores/event';
import { SHALLOW_LIST_ID as shallowCourseListId } from '../stores/course';
import { SHALLOW_LIST_ID as shallowForumListId } from '../stores/forum';

// app components
import WallEntries from '../components/wall/wall-entries';
import ChannelsFilter from '../components/static/channels-filter';
import ActiveAccount from '../components/static/active-account';
import ProfileCompletedInfo from '../components/static/profile-completed-info';
import SocialNetworks from '../components/static/social-networks';
import ArticlesSection from '../components/static/articles-section';
import EventsSection from '../components/static/events-section';
import CoursesSection from '../components/static/courses-section';
import ForumsSection from '../components/static/forum-section';
import FilterContent from '../components/wall/form/filter-content';

const Wall = (props) => {
    return (
        <section id="wall-wrapper">
            <div className="row">
                <div className="mobile-12 tablet-5 large-4 xlarge-3 columns">
                    {/* Show static sections */}
                    <aside className="left-aside-wrapper">
                        <ChannelsFilter />
                        <FilterContent listId={listIdWall} />
                        <ArticlesSection listId={shallowArticleListId} field="channel" />
                        <EventsSection listId={shallowEventListId} field="channel" />
                    </aside>
                </div>

                <div className="mobile-12 tablet-7 large-8 xlarge-6 columns">
                    {/* Render wall posts components */}
                    <WallEntries listId={listIdWall} />
                </div>

                <div className="tablet-3 xlarge-3 show-for-xlarge-up columns">
                    {/* Show static sections */}
                    <aside className="right-aside-wrapper">
                        <ProfileCompletedInfo />
                        <SocialNetworks />
                
                        <CoursesSection listId={shallowCourseListId} field="channel" />
                        <ForumsSection listId={shallowForumListId} field="channel" />
                    </aside>
                </div>
            </div>
        </section>
    );
}

export default Wall;

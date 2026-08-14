// resources/assets/js/pages/forum/forum.js
import React from 'react';
import { renderRoutes } from 'react-router-config';
import qs from 'qs';

// app components

const Forum = ({ route, location }) => (
    <section id="forum-wrapper">
        <div className="row">
            <div className="small-12 columns">
                {renderRoutes(
                    route.routes,
                    { queryParams: qs.parse(location.search, { ignoreQueryPrefix: true }) }
                )}
            </div>
        </div>
    </section>
);

export default Forum

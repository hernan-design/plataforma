// resources/assets/js/routers/reactroutes.js

// Page components
import Layout from '../pages/layout';
import IndexPage from '../pages/indexpage';
import Chat from '../pages/chat';
import Payment from '../pages/payment';
import Wall from '../pages/wall';

// forum
import Forum from '../pages/forum/forum';
import ForumDetail from '../pages/forum/forum-detail';
import ForumBrowse from '../pages/forum/forum-browse';

import NotFoundPage from '../pages/notfound';

const routes = [
    {   component: Layout,
        routes: [
            // {
            //  path: '/',
            //  exact: true,
            //  component: IndexPage
            // },
            {
                path: '/chat',
                component: Chat 
            },
            {
                path: '/comprar',
                component: Payment
            },
            {
                path: '/comunidad',
                component: Wall
            },
            {
                path: '/foro',
                component: Forum,
                routes: [
                    {
                        path: '/foro/:category/:theme',
                        component: ForumDetail
                    },
                    {
                        path: '/foro',
                        component: ForumBrowse
                    }
                ]
            },
            {
                path: '*',
                component: NotFoundPage
            }
        ]
    }
];

export default routes

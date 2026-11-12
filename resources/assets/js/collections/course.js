/**
* Class CourseList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.CourseList = Backbone.PageableCollection.extend({
        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('aprende.curso.index') );
        },
        model: app.CourseModel,
        state: {
            firstPage: 0,
            pageSize: 15 //number of records to show by page
        },
        queryParams: {
            totalPages: null,
            totalRecords: null,
            pageSize: "limit",
            currentPage: null,
            offset: function () { return this.state.currentPage * this.state.pageSize; }
        },
        /**
        * Constructor Method
        */
        initialize : function(){
        },
        /**
        * order by
        */
        // comparator: function(){
        // },
        /**
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            var totalRecords = (resp && resp.total_entries) || 0;
            var pageSize = (state && state.pageSize) || 15;
            var totalPages = Math.ceil(totalRecords / pageSize);
            var firstPage = (state && state.firstPage != null) ? state.firstPage : 0;
            var maxPage = firstPage === 0 ? Math.max(0, totalPages - 1) : Math.max(firstPage, totalPages);
            var currentPage = (state && state.currentPage != null) ? state.currentPage : firstPage;
            if (totalPages > 0 && currentPage > maxPage) {
                currentPage = maxPage;
            } else if (totalPages === 0) {
                currentPage = firstPage;
            }
            if (currentPage < firstPage) {
                currentPage = firstPage;
            }
            return {
                totalRecords: totalRecords,
                currentPage: currentPage
            };
        },
        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        }
   });
})(this, this.document);

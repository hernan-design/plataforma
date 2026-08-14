/**
* Class UserLikesList extend of Backbone Collection
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UserLikesList = Backbone.PageableCollection.extend({

        mode: 'server',
        url: function () {
            return window.Misc.urlFull( Route.route('like.index') );
        },
        model: app.LikeModel,

        state: {
            firstPage: 0,
            pageSize: 20 //number of records to show by page
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
        * parse state of the paginator collection
        */
        parseState: function (resp, queryParams, state, options) {
            return {totalRecords: resp.total_entries};
        },

        /**
        * Return all the posts
        * @param Object resp, response of the server
        */
        parseRecords: function (resp) {
            return resp.items;
        },

        /**
        * get like model by authenticated user
        */
        getModelLikeAuth: function () {

            return this.find(function (model) {
                return model.get('auth_like') === true;
            });
        }
   });

})(this, this.document);

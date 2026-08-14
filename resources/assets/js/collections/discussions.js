/**
* Class DiscussionsList extends of Backbone Collection
* @author TuProyecto/Copo software || Desarrollador : @krobing
* @link https://coposoftware.com
*/

// Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DiscussionList = Backbone.PageableCollection.extend({
        mode: 'server',
        url: function (){
           return window.Misc.urlFull( Route.route('discusion.index') );
        },
        model: app.DiscussionModel,

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
            //
        },

        /**
        * order by
        */
        comparator: function(){
            // ordenamos por el atributo nombre
            // return cliente.get('nombre');
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
        }
   });

})(this, this.document);

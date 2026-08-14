/**
* Class GroupItemRosterView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

    app.GroupItemRosterView = window.app.GroupItemView.extend({

        template: _.template( ($('#group-roster-list-tpl').html() || '')) 

    });
    
})(jQuery, this, this.document);
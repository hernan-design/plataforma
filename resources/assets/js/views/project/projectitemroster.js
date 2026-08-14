/**
* Class ProjectItemRosterView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

    app.ProjectItemRosterView = window.app.ProjectItemView.extend({

        template: _.template( ($('#project-roster-list-tpl').html() || '')) 

    });
    
})(jQuery, this, this.document);
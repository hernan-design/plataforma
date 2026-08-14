/**
* Class MostViewInternalArticleView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

    app.MostViewInternalArticleView = window.app.MostViewedArticleItemView.extend({

        template: _.template( ($('#most-viewed-article-internal-item-list-tpl').html() || ''))

    });
    
})(jQuery, this, this.document);
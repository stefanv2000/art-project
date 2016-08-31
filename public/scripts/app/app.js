/**
 * 
 */

define([
  'jquery',
  'underscore',
  'backbone',
  './../views/layout',
  './../views/menu',
  'router',
  'appview'
], function($, _, Backbone,Layout,ViewMenu,Router,AppView){
  var initialize = function(){


    //setup menu
    var menuview = new ViewMenu();
    $('body').append(menuview.render());
    //setup layout
    var layout = new Layout();
    $('body').append(layout.render());
    //start router
    Router.initialize({
    	appView:new AppView(),
    });
  };

  return {
    initialize: initialize
  };
});
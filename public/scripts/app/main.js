/**
 * @author stefan valea stefanvalea@gmail.com
 */

//*


require.config({
	  paths: {
		    jquery: '/scripts/libs/jquery',
		    underscore: '/scripts/libs/underscore',
		    backbone: '/scripts/libs/backbone',
		    text: '/scripts/libs/text',
		    'jquery.lazyload': '/scripts/libs/jquery.lazyload.min',
		    'jquery.validate': '/scripts/libs/jquery.validate.min',
		    'masonry' : '/scripts/libs/masonry.pkgd.min',
		  },
		  shim: {
			    backbone: {
			        deps: ["underscore", "jquery"],
			        exports: "Backbone"
			    },

			    underscore: {
			        exports: "_"
			    }
		  },		  
		  baseUrl:'/scripts/app',
});
//console.log(require.toUrl());
require(['jquery'],'utils');
var router;
require([
         'backbone','app'],
         function(Backbone,App){
	Backbone.View.prototype.close = function(){
		  this.remove();
		  this.unbind();
		  if (this.onClose){
			    this.onClose();
			  }
		  
		};
	
	App.initialize();
});
//*/
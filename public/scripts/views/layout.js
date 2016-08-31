define(['jquery','underscore','backbone','text!./../templates/layout.html'],
	function($,_,Backbone,layout){
		var LayoutView = Backbone.View.extend({
			className:'maincontent',
			id:'content',
			//el:$('body'),
			initialize : function(){
				
			},
			render:function(){				
				var template = _.template(layout,{});
				this.$el.html(template);
				return this.$el;
			},
		});
		
		return LayoutView;
});
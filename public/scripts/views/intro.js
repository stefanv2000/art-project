define(['jquery','underscore','backbone','./../app/models/intro'
        ,'text!./../templates/intro.html'
        ]
	,function($,_,Backbone,IntroCollection,introTemplate){
	return Backbone.View.extend({
		className : 'introview',
		initialize:function(){
			var self = this;
			$(window).on("resize", function(){
				self.resizeView();
				});
			
			this.introcollection = new IntroCollection();

			this.introcollection.fetch({
				success : function(){
					
					self.render();
				}
			});				
		},
		events:{
			"mouseenter .introcontentholder" : "mouseenter",
			"mouseleave .introcontentholder" : "mouseleave",
			"click .introcontentholder" : "gotoSection",
		},
		mouseenter:function(event){
			$(event.target).closest('.introcontentholder').find('.introcontainerimageholder').find('.introimage').addClass('introimagehover');
		},
		mouseleave:function(event){
			$(event.target).closest('.introcontentholder').find('.introcontainerimageholder').find('.introimage').removeClass('introimagehover');
		},
		gotoSection :function(event){
			router.navigate($(event.target).closest('.introcontentholder').data('href'),{trigger:true});

		},

		resizeView : function(){

		},
		remove : function(){
			$(window).off("resize", this.resizeView);
			if(this.slideshowTimeout){ clearTimeout(this.slideshowTimeout);}
	        Backbone.View.prototype.remove.apply(this, arguments);			
		},
		render:function(){
			var that = this;	
			Utils.changeTitle('');
			var introtemplate = _.template(introTemplate,{intro : that.introcollection.toJSON()});
			that.$el.html(introtemplate);			
			that.resizeView();
		
		},
	});
});
define(['jquery','underscore','backbone','text!./../templates/portfolio.html',
        './../app/models/portfolio','utils'],
	function($,_,Backbone,portfolioTemplate,Portfolio,Masonry){
	
		var PortfolioView = Backbone.View.extend({
			className:'portfolioview',
			resTimeout:null,
			initialize:function(){
				var self = this;
				$(window).on("resize", function(){
					if (self.resTimeout!= null ) clearTimeout(self.resTimeout);
					self.resTimeout = setTimeout(function(){self.resizeView();},80);
				});
				

				this.portfoliomodel = new Portfolio.portfolio({'id':this.options.id});
				this.portfoliomodel.on('change',function(){		self.render();				});
				this.portfoliomodel.fetch();
			},
			events : {
				'mouseenter .stillprojectholder' : 'showoverlay',
				'mouseleave .stillprojectholder' : 'hideoverlay',
				'click .stillprojectholder' : 'gotoProject',
				'click .closebutton' : 'closePortfolio',
			},
			closePortfolio : function(event){
				router.navigate(this.portfoliomodel.get('categoryslug'),{trigger:true});
			},
			showoverlay:function(event){
				$(event.target).closest('.stillprojectholder').find('.stillprojectoverlay').stop().css({
					left:'0px'
				});
			},
			hideoverlay:function(event){
				$(event.target).closest('.stillprojectholder').find('.stillprojectoverlay').stop().css({
					left:'-200px'
				});
			},
			gotoProject : function(event){
				router.navigate($(event.target).closest('.stillprojectholder').data('href'),{trigger:true});
			},
			
			resizeView : function(){
				var sizes = [$(window).width(),$(window).height()];
				console.log(sizes);
				var rightWidth = sizes[0]-75;
				if (sizes[0]<800) rightWidth=sizes[0]-25;
				this.$('.portfoliorightcontainer').width(rightWidth);

			},
			
			remove : function(){
				$(window).off("resize", this.resizeView);
		        Backbone.View.prototype.remove.apply(this, arguments);				
			},
			
			render : function() {
				Utils.changeTitle(this.portfoliomodel.get('name'));
				
				var imagewidth = 1200;
				//if ($(window).width()<800){		imagewidth = 700;			}
				//asdfasdf


				var template = _.template(portfolioTemplate, {
					portfolio : this.portfoliomodel.toJSON(),
					content : this.portfoliomodel.get('content').toJSON(),
					functions:{
						trimString : Utils.trimToWords
					},
					settings : {
						width: imagewidth,
						thumbwidth: 300,
					},
				});
				
				this.$el.prepend(template);
				this.resizeView();
				this.$('.stillprojectimage').each(function(index,element){
					var imgel = $('<img>').load(function(){
						$(element).addClass('stillprojectimageshow');return;
						$(element).css({
							'visibility' : 'visible',
							'opacity'	: '0',
						}).animate({'opacity' :1},1000);
					}).attr('src',$(element).attr('src'));
				});
			},
			onClose: function(){
				this.$el.remove();
			},
		});
		
		return PortfolioView;
});
define(['jquery','underscore','backbone','text!./../templates/contentviewer.html',
        'text!./../templates/content.html',
        './../app/models/portfolio','utils','/scripts/libs/jquery.touchSwipe.min.js'],
	function($,_,Backbone,contentviewerTemplate,contentTemplate,Portfolio){
		var ContentView = Backbone.View.extend({
			className:'contentviewer',
			resTimeout:null,
			initialize:function(){
				var self = this;
				this.contentid = this.options.contentid;
				
				$(window).on("resize",{that:this}, this.resizeevent);
				$(window).on("keydown",{that:this}, this.keydownevent);

				this.portfoliomodel = new Portfolio.portfolio({'id':this.options.id,'type' : this.options.type});
				this.portfoliomodel.on('change',function(){
					self.render();
					});				
				this.portfoliomodel.fetch({
					success : function(){
					}
				});				
			},
			events : {
				'click #previouscontent,#previouscontentoverlay' : 'previousContent',
				'click #nextcontent,#nextcontentoverlay' : 'nextContent',
				'click #closebutton' : 'closeContent',
				'click #playbutton' : 'showVideoContent',
			},
			keydownevent : function(event){
				if (event.keyCode ==39 ) event.data.that.nextContent();
				if (event.keyCode ==37 ) event.data.that.previousContent();
			},
			resizeevent : function(event){
				var that = event.data.that;
				if (that.resTimeout!= null ) clearTimeout(that.resTimeout);
				that.resTimeout = setTimeout(function(){that.resizeView();},80);				
			},
			
			resizeView : function(){

				var sizes = [$(window).width(),$(window).height()];
				//return;
				if (sizes[0]>800) {

				} else {

				}

				var heightcontent = sizes[1]-140;
				heightcontent = Math.max(heightcontent,400);

				var rightWidth = sizes[0]-75;
				if (sizes[0]<800) rightWidth = sizes[0]-25;
				this.$('.contentviewerholder').width(rightWidth).height(heightcontent);
				this.$('.contentholder').width(rightWidth).height(heightcontent);
				this.$('.contentholdercontainer').width(rightWidth-20).height(heightcontent-20);



			},
			
			remove : function(){
				$(window).off("resize", this.resizeevent);
		        Backbone.View.prototype.remove.apply(this, arguments);				
			},
			
			render : function() {
				Utils.changeTitle(this.portfoliomodel.get('name'));
				
				var imagewidth = 1200;
				if ($(window).width()<800){
					imagewidth = 700;
				}				
				var template = _.template(contentviewerTemplate, {portfolio : this.portfoliomodel.toJSON()});
				
				/*var template = _.template(contentviewerTemplate, {
					project : this.projectmodel.toJSON(),
					content : this.projectmodel.get('content').toJSON(),
					cover : this.projectmodel.get('cover').toJSON(),
					settings : {
						width: imagewidth,
						thumbwidth: 300,
					},
				});*/
				
				this.$el.prepend(template);				
				this.showContent(this.contentid);

				this.resizeView();
				return;
				
			},
			//display the content with id contentid
			showContent : function(contentid){		
				var self = this;
				var contentmodel = this.portfoliomodel.get('content').get(contentid);
				var template = _.template(contentTemplate, {
					content : contentmodel.toJSON(),
					color: this.portfoliomodel.get('color'),
				});		
				this.$('.contentholder').html(template);
				var elemcontent = this.$('#contentcontent'+contentmodel.get('id'));
				var eim = $('<img>').load(function(){
					var arrayx = $('.contentcontent');var cond =true;
					for (var i=0;i<=arrayx.length;i++){
						if ($(arrayx[i]).attr('src')==$(this).attr('src')) {
							cond=false;
							break;
						}
					}
					if (cond) return;
					elemcontent.css({
						'visibility' : 'visible',
						'opacity' : '0'
					}).animate({'opacity' : '1'},1500);
					$('.contentholdercontainer').css('background','none');
				}).attr('src',elemcontent.attr('src'));
				elemcontent.swipe({
					swipeLeft:function(){
						self.previousContent();
					},
					swipeRight:function(){
						self.nextContent();
					}
				});



				this.$('#contentindextext').html(this.portfoliomodel.get('content').getIndice(this.contentid)+ ' of '+this.portfoliomodel.get('content').length);
				this.$('#previouscontentoverlay,#nextcontentoverlay').removeClass('hidepreviousnext');

				//if the content is video disable previos next overlays
				if ((contentmodel.get('type')==2)||(contentmodel.get('type')==4)) {
					this.$('#previouscontentoverlay,#nextcontentoverlay').addClass('hidepreviousnext');
					this.$('#contentname').html(Utils.trimToWords(contentmodel.get('caption'),50));
				}
				this.resizeView();
				router.navigate(this.portfoliomodel.get('slug')+"/"+contentid,{trigger:false});
				
				//shre icons links
				this.$('#viewerfacebooklink').attr('href','https://www.facebook.com/sharer/sharer.php?u='+window.location.href);
				this.$('#viewerpinterestlink').attr('href','https://pinterest.com/pin/create/button/?url='+window.location.href+'&media='+window.location.protocol+'//'+window.location.hostname+elemcontent.attr('src')+'&description='+contentmodel.get('caption'));
				this.$('#viewertwitterlink').attr('href','https://twitter.com/home?status='+encodeURIComponent(document.title+' '+window.location.href));
				this.$('#viewergooglepluslink').attr('href','https://plus.google.com/share?url='+encodeURIComponent(window.location.href));
				this.$('#viewertumblrlink').attr('href','http://www.tumblr.com/share/link?url='+encodeURIComponent(window.location.href)+'&name='+encodeURIComponent(document.title)+'&description='+contentmodel.get('caption'));
				
			},
			previousContent : function(){
				var contentprevious = this.portfoliomodel.get('content').getPrevious(this.contentid);
				this.contentid = contentprevious.get('id');
				this.showContent(this.contentid);
			},
			nextContent : function(){
				var contentnext = this.portfoliomodel.get('content').getNext(this.contentid);
				this.contentid = contentnext.get('id');
				this.showContent(this.contentid);				
			},
			showVideoContent: function(event){
				this.$('.realcontent').show();
				this.$('.previewcontent').remove();
				this.$('#playbutton').remove();
				this.$('#previouscontent,#nextcontent').addClass('hidepreviousnext');
			},
			closeContent : function() {
				router.navigate(this.portfoliomodel.get('backslug'),{trigger:true});
			},
			onClose: function(){
				this.$el.remove();
			},
		});
		
		return ContentView;
});
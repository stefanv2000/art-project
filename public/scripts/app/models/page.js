define(['underscore','backbone'],
	function(_,Backbone){

	var PageContent = Backbone.Model.extend({
		
	});
	var PageContentCollection = Backbone.Collection.extend({
		model:PageContent
	});
	var Page = Backbone.Model.extend({
		initialize :function(){
			//this.urlRoot = '/api/getproject/'+this.id;
		},
		urlRoot:'/api/getpage/',
		parse : function(response){
			//var images = new ContentCollection(response.images);
			//images.add(response.images);
			//this.set('content',images);
			response.page.textblocks = new PageContentCollection(response.textblocks);
			response.page.cover = new PageContentCollection(response.cover);
			response.page.content = new PageContentCollection(response.content);
			return response.page;
		},
	});

	return {
		page : Page
	};
});
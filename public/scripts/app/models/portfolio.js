/**
 * 
 */

define(['underscore','backbone'],
	function(_,Backbone){

	var Content = Backbone.Model.extend({
		
	});
	var ContentCollection = Backbone.Collection.extend({
		model:Content,
		getNext:function(idcontent){
			var cindex = this.indexOf(this.get(idcontent));
			if (cindex+1==this.length) cindex = 0; else cindex++;
			return this.at(cindex);
		},
		getPrevious : function(idcontent){
			var cindex = this.indexOf(this.get(idcontent));
			if (cindex-1<0) cindex = this.length-1; else cindex--;
			return this.at(cindex);			
		},
		getIndice : function(idcontent){
			return this.indexOf(this.get(idcontent))+1;
		},
	});
	var Portfolio = Backbone.Model.extend({
		initialize :function(){
			console.log(this.urlRoot);
			if (this.get('type') == 'motion') this.urlRoot = '/api/getprojectmotion/';
			console.log(this.urlRoot);
			//this.urlRoot = '/api/getproject/'+this.id;
		},
		urlRoot:'/api/getproject/',
		parse : function(response){
			//var images = new ContentCollection(response.images);
			//images.add(response.images);
			//this.set('content',images);
			response.portfolio.content = new ContentCollection(response.content);
			return response.portfolio;
		},
	});

	return {
		portfolio : Portfolio
	};
});
define(['underscore','backbone'],
	function(_,Backbone){

	var IntroContent = Backbone.Model.extend({
		
	});
	var IntroContentCollection = Backbone.Collection.extend({
		model:IntroContent,
		url:'/api/getintro',
	});
	return IntroContentCollection;
});
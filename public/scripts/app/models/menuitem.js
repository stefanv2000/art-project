/**
 * 
 */

define(['underscore','backbone'],//,'text!./../templates/menu.html'
	function(_,Backbone){

	var MenuItem = Backbone.Model.extend({
	});
	
	var MenuCollection = Backbone.Collection.extend({
		model: MenuItem,
	});

	return MenuCollection;
});
define(['jquery','underscore','backbone','text!./../templates/menu.html','./../app/models/menuitem'],
	function($,_,Backbone,menuTemplate,MenuCollection){
		var ViewMenu = Backbone.View.extend({
			className:'',
			id:'menucontainer',	
			events:{
				'click .menuitemlink' : "gotoLinkMenu",
				'click #linklogo' : "gotoIntro",
				'click #menuicon' : "togglemenu",
			},
			render:function(){				
				var menuc = new MenuCollection(menuitems);
				var template = _.template(menuTemplate,{menucollection:menuc.toJSON()});
				this.$el.html(template);
				return this.$el;
			},
			gotoLinkMenu : function(event){
				event.preventDefault();
				var ismobile = ($(window).width()<800);
				var elem = $(event.target);
				
				$('ul.submenu').removeClass('submenuopen').addClass('submenuclosed');
				//if (elem.data['itemtype'] =='page') $('ul.submenu').removeClass('submenuopen').addClass('submenuclosed');
				if (elem.data('itemtype') =='link') {
					window.open(elem.attr('href'),'_blank');
				} else router.navigate(elem.attr('href'),{trigger:true});

				//if (ismobile) this.togglemenu(event);
			},
			gotoIntro : function(event){
				event.preventDefault();
				router.navigate("/",{trigger:true});
			},
			togglemenu : function(event){
				if (this.$('.menu-container').hasClass('menuclosed')){
					this.$('.menu-container').removeClass('menuclosed');
					this.$('.menu-container').addClass('menuopened');
				} else {
					this.$('.menu-container').removeClass('menuopened');
					this.$('.menu-container').addClass('menuclosed');					
				}
			}
		});
		
		return ViewMenu;
});
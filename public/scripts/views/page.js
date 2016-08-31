define(['jquery','underscore','backbone','./../app/models/page'
        ,'text!./../templates/cover.html'
        ,'jquery.validate'],function($,_,Backbone,Page,coverTemplate){
	return Backbone.View.extend({
		className : 'pageview',
		initialize:function(){
			$(window).on("resize", function(){
				that.resizeView();
			});
			
			this.pagemodel = new Page.page({'id': this.options.name});
			var that = this;
			this.pagemodel.on('change',function(){
				that.render();
				});				
			this.pagemodel.fetch({
				success : function(){
				}
			});				
		},
		events:{
			//submit contact form
			'click .inputsubmit':function(event){
				var that = this;
				event.preventDefault();
				var elem = $(event.target);

				//console.log($('#formcontact').valid());
				if (!$('#formcontact').valid()) return;

				
				$.get('/api/sendcontact',
						$('#formcontact').serializeArray(),
						function(data){
							if (data['code']=='1'){
								that.$('#contactmessages').html('Your message has been sent!');
								var validator = $('#formcontact').validate();
								$('#formcontact').get(0).reset();
								validator.resetForm();								
							} else {
								that.$('#contactmessages').html('An error occurred while sending the message. Please try again! ');
							}
						},
						'json'
				)
				
			}
		},
		resizeView : function(){
			var sizes = [$(window).width(),$(window).height()];
			sizes[0] = sizes[0]-75;
			this.$('.textpagecontainer ').width(sizes[0]);
		},
		remove : function(){
			$(window).off("resize", this.resizeView);
	        Backbone.View.prototype.remove.apply(this, arguments);			
		},
		render:function(){			
			var that = this;
			Utils.changeTitle(that.pagemodel.get('name'));
			require(['text!./../templates/'+this.options.name+'.html'],function(templatehtml){				
				var template = _.template(templatehtml, {
					page : that.pagemodel.toJSON(),
					textblocks : that.pagemodel.get('textblocks').toJSON(),
					cover : that.pagemodel.get('cover').toJSON(),
					content : that.pagemodel.get('content').toJSON(),
					functions :{
						getTextblock: function(name){
							var arrayc = that.pagemodel.get('textblocks').toJSON();
							for ( var key in arrayc) {
								//console.log(arrayc[key].name==name);
								if (arrayc[key].name == name) return arrayc[key];
							}
							return null;
						}
					}
				});
				that.$el.prepend(template);
				//that.$el.prepend(covertemplate);
				that.validateContact();
				that.resizeView();
				
				
			});
		
		},
		validateContact : function(){
			var validator = $('#formcontact').validate({
				rules:{
					contactname:{
						required : true,
					},
					contactemail:{
						required : true,
						email:true
					},
					contactmessage : {
						required: true,
					}
				},
				invalidHandler:function(){
					console.log(validator.numberOfInvalids());
				}
			});
		}
	});
});
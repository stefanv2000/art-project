define(['jquery','underscore','backbone','text!./../templates/motionmain.html',
        './../app/models/motionmain','utils'],
    function($,_,Backbone,motionTemplate,Motion){

        var MotionView = Backbone.View.extend({
            className:'motionmainview',
            resTimeout:null,
            initialize:function(){
                var self = this;
                $(window).on("resize", function(){
                    if (self.resTimeout!= null ) clearTimeout(self.resTimeout);
                    self.resTimeout = setTimeout(function(){self.resizeView();},80);
                });


                this.motionmodel = new Motion.motion({'id':this.options.id});
                this.motionmodel.on('change',function(){
                    self.render();
                });
                this.motionmodel.fetch({
                    success : function(){
                    }
                });
            },

            events : {
                'mouseenter .stillprojectholder' : 'showoverlay',
                'mouseleave .stillprojectholder' : 'hideoverlay',
                'click .stillprojectholder' : 'gotoProject',
            },
            showoverlay:function(event){
                $(event.target).closest('.stillprojectholder').find('.stillprojectoverlay').stop().css({
                    top:'0px'
                });
            },
            hideoverlay:function(event){
                $(event.target).closest('.stillprojectholder').find('.stillprojectoverlay').stop().css({
                    top:'-100px'
                });
            },
            gotoProject : function(event){
                router.navigate($(event.target).closest('.stillprojectholder').data('href'),{trigger:true});
            },
            resizeView : function(){

                var sizes = [$(window).width(),$(window).height()];
                //if (sizes[0]>800)                sizes[0] = sizes[0]-300;

                this.$('.portfoliorightcontainer').width(sizes[0]-75);
                return;

            },

            remove : function(){
                $(window).off("resize", this.resizeView);
                Backbone.View.prototype.remove.apply(this, arguments);
            },

            render : function() {
                Utils.changeTitle(this.motionmodel.get('name'));
                //console.log(this.stillmodel.get('subsections').at(0).get('name'));


                var template = _.template(motionTemplate, {
                    motion: this.motionmodel,
                    functions: {
                        trimString: Utils.trimToWords
                    },
                });

                this.$el.prepend(template);
                //this.$el.prepend(covertemplate);
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

        return MotionView;
    });

/**
 *
 */

define(['underscore','backbone'],
    function(_,Backbone){

        var Project = Backbone.Model.extend({
            initialize:function(){

            }
        });
        var ProjectsCollection = Backbone.Collection.extend({
            model:Project,
        });
        var MotionMain = Backbone.Model.extend({
            initialize :function(){
                //this.urlRoot = '/api/getproject/'+this.id;
            },
            urlRoot:'/api/apimainmotion',
            parse : function(response){
                response.projects = new ProjectsCollection(response.projects);
                return response;
            },
        });

        return {
            motion : MotionMain
        };
    });



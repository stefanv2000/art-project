/**
 *
 */

define(['underscore','backbone'],
    function(_,Backbone){
        var Project = Backbone.Model.extend({

        });
        var ProjectsCollection = Backbone.Collection.extend({
            model:Project,
        });

        var Subsection = Backbone.Model.extend({
            initialize:function(){

            }
        });
        var SubsectionCollection = Backbone.Collection.extend({
            model:Subsection,
        });
        var StillMain = Backbone.Model.extend({
            initialize :function(){
                //this.urlRoot = '/api/getproject/'+this.id;
            },
            urlRoot:'/api/apimainstill',
            parse : function(response){
                response.subsections = new SubsectionCollection(response.categories);
                return response;
            },
        });

        return {
            still : StillMain
        };
    });


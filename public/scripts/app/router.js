/**
 *
 */
define([
    'jquery',
    'underscore',
    'backbone'
], function ($, _, Backbone) {
    var AppRouter = Backbone.Router.extend({
        routes: {
            '(still)/:projectname/:projectid(/:contentid)(/)': 'stillmain',
            '(albums)(projects)(campaigns)(portfolio)/:name/:id(/:contentid)(/)':'portfolio',
            '(motion)(video)/:projectname/:projectid(/:contentid)(/)': 'motion',
            'biography': 'pagebio',
            'contact': 'pagecontact',
            ':pagename' : 'page',
            // Default
            '*actions': 'defaultAction'
        },
        initialize: function (options) {
            console.log('initialize router', options);
            this.appView = options.appView;
        },

        stillmain: function (projectname, projectid, contentid) {
            if (contentid) {
                this.contentviewer(projectname, projectid, contentid);
                return;
            }
            var self = this;

            require(['./../views/stillmain'], function (StillMainView) {
                var pv = new StillMainView({'id': projectid});
                self.appView.showView(pv);
                $('#content').prepend(pv.$el);
            });

        },

        portfolio: function (name, id, contentid) {

            if (contentid) {
                this.contentviewer(name, id, contentid,'portfolio');
                return;
            }
            var self = this;

            require(['./../views/portfolio'], function (PortfolioView) {
                var pv = new PortfolioView({'id': id});
                self.appView.showView(pv);
                $('#content').prepend(pv.$el);
            });

        },
        motion: function (projectname, projectid, contentid) {
            if (contentid) {
                this.contentviewer(projectname, projectid, contentid,'motion');
                return;
            }
            var self = this;

            require(['./../views/motionmain'], function (MotionMainView) {
                var pv = new MotionMainView({'id': projectid});
                self.appView.showView(pv);
                $('#content').prepend(pv.$el);
            });
        },
        contentviewer: function (projectname, projectid, contentid,type) {
            var that = this;
            require(['./../views/contentviewer'], function (ContentView) {
                var cv = new ContentView({'id': projectid, 'contentid': contentid, 'type':type});
                that.appView.showView(cv);
                $('#content').prepend(cv.$el);
            });

        },
        pagebio: function () {
            this.page('biography');
        },
        pagecontact: function () {
            this.page('contact');
        },

        page: function (name) {
            var that = this;
            require(['./../views/page'], function (PageView) {
                var pageview = new PageView({'name': name});
                that.appView.showView(pageview);
                $('#content').prepend(pageview.$el);
            });
            $('.footer').show();
        },

        defaultAction: function () {
            var that = this;
            require(['./../views/intro'], function (IntroView) {
                var introview = new IntroView();
                that.appView.showView(introview);
                $('#content').prepend(introview.$el);
            });
            $('.footer').hide();
        }
    });

    var initialize = function (options) {
        router = new AppRouter(options);
        router.on('route', function (route, params) {
            var match = window.location.pathname.substring(1);
            if (route == 'projects') {
                var elem = $('#menuitem' + params[1]).find('a.menuitemlink');
                elem.parent().parent().removeClass('submenuclosed').addClass('submenuopen');
                $('a.menuitemlink').removeClass('selectedmenuitemlink');
                elem.addClass('selectedmenuitemlink');
            } else {
                $('.menuitemlink').each(function (index, element) {
                    var elem = $(element);
                    if (('/' + match) == elem.attr('href')) {
                        elem.addClass('selectedmenuitemlink');
                    }
                    else elem.removeClass('selectedmenuitemlink');
                });
            }
        });
        Backbone.history.start({pushState: true});
    };
    return {
        initialize: initialize
    };
});
<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Frontend\Controller\Index' => 'Frontend\Controller\IndexController',
        	'Frontend\Controller\Menu' => 'Frontend\Controller\MenuController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'frontend' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Frontend\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[:controller[/:action]]',
                            //'constraints' => array(
                                //'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                //'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            //),
                            'defaults' => array(
                            		'controller'    => 'Index',
                            		'action'        => 'index',                            		
                            ),
                        ),
                    ),
                		'projects' => array(
                				'type'    => 'Segment',
                				'options' => array(
                						'route'    => '[still][albums][projects][campaigns][portfolios][portfolio][motion]/:name/:id[/:imageid]',
                						//'constraints' => array(
                						//'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                						//'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                						//),
                						'defaults' => array(
                								'controller'    => 'Index',
                								'action'        => 'index',
                						),
                				),
                		), 
                		'pages' => array(
                				'type'    => 'Segment',
                				'options' => array(
                						'route'    => ':name[/]',
                						//'constraints' => array(
                						//'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                						//'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                						//),
                						'defaults' => array(
                								'controller'    => 'Index',
                								'action'        => 'index',
                						),
                				),
                		),
                ),
            ),
        		'menurest' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						'route'    => '/api/menu',
        						'defaults' => array(
        								// Change this value to reflect the namespace in which
        								// the controllers for your module are found
        								'__NAMESPACE__' => 'Frontend\Controller',
        								'controller'    => 'Menu',
        						),
        				),
        				'may_terminate' => true,
        		),
        		'projectrest' => array(
        				'type'    => 'Segment',
        				'options' => array(
        						'route'    => '/api/getproject/:id',
        						'defaults' => array(
        								// Change this value to reflect the namespace in which
        								// the controllers for your module are found
        								'__NAMESPACE__' => 'Frontend\Controller',
        								'controller'    => 'Index',
        								'action'		=> 'apiproject',
        						),
        				),
        				'may_terminate' => true,
        		),
				'projectmotionrest' => array(
					'type'    => 'Segment',
					'options' => array(
						'route'    => '/api/getprojectmotion/:id',
						'defaults' => array(
							'__NAMESPACE__' => 'Frontend\Controller',
							'controller'    => 'Index',
							'action'		=> 'apiprojectmotion',
						),
					),
					'may_terminate' => true,
				),
        		'pagerest' => array(
        				'type'    => 'Segment',
        				'options' => array(
        						'route'    => '/api/getpage/:id',
        						'defaults' => array(
        								'__NAMESPACE__' => 'Frontend\Controller',
        								'controller'    => 'Index',
        								'action'		=> 'apipage',
        						),
        				),
        				'may_terminate' => true,
        		), 
        		'introrest' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						'route'    => '/api/getintro',
        						'defaults' => array(
        								'__NAMESPACE__' => 'Frontend\Controller',
        								'controller'    => 'Index',
        								'action'		=> 'apiintro',
        						),
        				),
        				'may_terminate' => true,
        		),
        		'sendcontactrest' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						'route'    => '/api/sendcontact',
        						'defaults' => array(
        								// Change this value to reflect the namespace in which
        								// the controllers for your module are found
        								'__NAMESPACE__' => 'Frontend\Controller',
        								'controller'    => 'Index',
        								'action'		=> 'apisendcontact',
        						),
        				),
        				'may_terminate' => true,
        		),
			'stillmain' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'    => '/api/apimainstill/:id',
					'defaults' => array(
						'__NAMESPACE__' => 'Frontend\Controller',
						'controller'    => 'Index',
						'action'		=> 'apimainstill',
					),
				),
				'may_terminate' => true,
			),

			'motionmain' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'    => '/api/apimainmotion/:id',
					'defaults' => array(
						'__NAMESPACE__' => 'Frontend\Controller',
						'controller'    => 'Index',
						'action'		=> 'apimainmotion',
					),
				),
				'may_terminate' => true,
			),


        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Frontend' => __DIR__ . '/../view',
        ),
    ),
		'view_helpers' => array(
				'factories' => array(
						'initializemodels' => 'Frontend\View\Helper\InitializeModelsHelperFactory'
				)
		),		
);

<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Section' => 'Admin\Controller\SectionController',
            'Admin\Controller\Content' => 'Admin\Controller\ContentController',
            'Admin\Controller\TextBlock' => 'Admin\Controller\TextBlockController',
        ),
    ),
    'router' => array(
        'routes' => array(
           'admin-index' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Section',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
            ),
        	'admin-dbbackup' => array(
        			'type'    => 'Literal',
        			'options' => array(
        					'route'    => '/dbbackup',
        					'defaults' => array(
        							'__NAMESPACE__' => 'Admin\Controller',
        							'controller'    => 'Index',
        							'action'        => 'dbbackup',
        					),
        			),
        			'may_terminate' => true,
        	),        		
            'admin-section' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/admin/section[/:sectionid]',
                    'constraints' => array(
                           'sectionid' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Section',
                        'action'        => 'index',
                        'sectionid'     => '0'
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'add' => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/add',
                            'defaults' => array (
                                'action' => 'addnew'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'sort'  => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/sortsections',
                            'defaults' => array (
                                'action' => 'sortsections'
                            )
                        ),
                        'may_terminate' => true,                        
                    ),
                    'changestatus'  => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/changestatus',
                            'defaults' => array (
                                'action' => 'changestatus'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'addform' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/addform[/:parentid]',
                            'constraints' => array(
                                'parentid' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'action' => 'addformsection'
                            )
                        ),
                        'may_terminate' => true,

                    ),
                    'add' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/sendadd',
                            'defaults' => array(
                                'action' => 'sendaddsection'
                            )
                        ),
                        'may_terminate' => true,

                    ),
                    'editform'  => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/edit[/:editid]',
                            'constraints' => array(
                                'editid' => '[0-9]+'
                            ),                            
                            'defaults' => array (
                                'action' => 'editsection'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'edit'  => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/sendedit',
                            'defaults' => array (
                                'action' => 'sendeditsection'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'delete'  => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/delete[/:deleteid]',
                            'constraints' => array(
                                'deleteid' => '[0-9]+'
                            ),                            
                            'defaults' => array (
                                'action' => 'deletesection'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'getsectionhtml'  => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/getsectionhtml/:sectionid',
                            'constraints' => array(
                                'sectionid' => '[0-9]+'
                            ),                            
                            'defaults' => array (
                                'action' => 'sectionhtml'
                            )
                        ),
                        'may_terminate' => true,
                    ),  
                		'sectionslist'  => array (
                				'type' => 'Segment',
                				'options' => array (
                						'route' => '/sectionslist[/]',
                						'defaults' => array (
                								'action' => 'sectionslist'
                						)
                				),
                				'may_terminate' => true,
                		),
                		'move'  => array (
                				'type' => 'Segment',
                				'options' => array (
                						'route' => '/sendmove',
                						'defaults' => array (
                								'action' => 'sendmovesection'
                						)
                				),
                				'may_terminate' => true,
                		),
                		
                		

                )
            ),    
            'admin-content' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin/content',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Content',
                    ),
                ),
                'may_terminate' => false,
                'child_routes'  => array(
                    'upload'  => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/upload',
                            'defaults' => array (
                                'action' => 'uploadfile'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                		'uploadvideolink'  => array (
                				'type' => 'Literal',
                				'options' => array (
                						'route' => '/uploadvideolink',
                						'defaults' => array (
                								'action' => 'uploadvideolink'
                						)
                				),
                				'may_terminate' => true,
                		),                		
                		'uploadcover'  => array (
                				'type' => 'Literal',
                				'options' => array (
                						'route' => '/uploadcover',
                						'defaults' => array (
                								'action' => 'uploadcover'
                						)
                				),
                				'may_terminate' => true,
                		),                		
                    'sort'  => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/sortcontent',
                            'defaults' => array (
                                'action' => 'sortcontent'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                		'delete'  => array (
                				'type' => 'Segment',
                				'options' => array (
                						'route' => '/delete[/:deleteid]',
                						'constraints' => array(
                								'deleteid' => '[0-9]+'
                						),
                						'defaults' => array (
                								'action' => 'deletecontent'
                						)
                				),
                				'may_terminate' => true,
                		),  
                		'getcontenthtml'  => array (
                				'type' => 'Segment',
                				'options' => array (
                						'route' => '/getcontenthtml/:contentid',
                						'constraints' => array(
                								'contentid' => '[0-9]+'
                						),
                						'defaults' => array (
                								'action' => 'contenthtml'
                						)
                				),
                				'may_terminate' => true,
                		),
                		'bulkdelete'  => array (
                				'type' => 'Literal',
                				'options' => array (
                						'route' => '/bulkdelete',
                						'defaults' => array (
                								'action' => 'bulkdelete'
                						)
                				),
                				'may_terminate' => true,
                		),                		
                		'bulkchangestatus'  => array (
                				'type' => 'Literal',
                				'options' => array (
                						'route' => '/bulkchangestatus',
                						'defaults' => array (
                								'action' => 'bulkchangestatus'
                						)
                				),
                				'may_terminate' => true,
                		),  
                		'editform'  => array (
                				'type' => 'Segment',
                				'options' => array (
                						'route' => '/edit[/:editid]',
                						'constraints' => array(
                								'editid' => '[0-9]+'
                						),
                						'defaults' => array (
                								'action' => 'editcontent'
                						)
                				),
                				'may_terminate' => true,
                		),
                		'edit'  => array (
                				'type' => 'Literal',
                				'options' => array (
                						'route' => '/sendedit',
                						'defaults' => array (
                								'action' => 'sendeditcontent'
                						)
                				),
                				'may_terminate' => true,
                		),
                		'getcover'  => array (
                				'type' => 'Literal',
                				'options' => array (
                						'route' => '/getcover',
                						'defaults' => array (
                								'action' => 'getcover'
                						)
                				),
                				'may_terminate' => true,
                		),
                		'removecover'  => array (
                				'type' => 'Literal',
                				'options' => array (
                						'route' => '/removecover',
                						'defaults' => array (
                								'action' => 'removecover'
                						)
                				),
                				'may_terminate' => true,
                		),
                		'bulkmove'  => array (
                				'type' => 'Literal',
                				'options' => array (
                						'route' => '/bulkmove',
                						'defaults' => array (
                								'action' => 'bulkmove'
                						)
                				),
                				'may_terminate' => true,
                		),                		
                    )
                ),
            'admin-textblock' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/admin/textblock',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'TextBlock'
                    )
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/addform/:sectionid',
                            'defaults' => array(
                                'action' => 'addformtextblock'
                            )
                        ),
                        'may_terminate' => true
                    ),
                    'sort'  => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/sorttextblock',
                            'defaults' => array (
                                'action' => 'sorttextblock'
                            )
                        ),
                        'may_terminate' => true,
                    ),  
                    'gettextblockhtml'  => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/gettextblockhtml/:textblockid',
                            'constraints' => array(
                                'textblockid' => '[0-9]+'
                            ),
                            'defaults' => array (
                                'action' => 'textblockhtml'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'delete'  => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/delete/:deleteid',
                            'constraints' => array(
                                'deleteid' => '[0-9]+'
                            ),                            
                            'defaults' => array (
                                'action' => 'deletetextblock'
                            )
                        ),
                        'may_terminate' => true,
                    ), 
                    'changestatus'  => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/changestatus',
                            'defaults' => array (
                                'action' => 'changestatus'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'editform'  => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/edit[/:editid]',
                            'constraints' => array(
                                'editid' => '[0-9]+'
                            ),                            
                            'defaults' => array (
                                'action' => 'edittextblock'
                            )
                        ),
                        'may_terminate' => true,
                    ),

                    'sendadd'  => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/sendadd',
                            'defaults' => array (
                                'action' => 'sendaddtextblock'
                            )
                        ),
                        'may_terminate' => true,
                    ),

                    'edit'  => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/sendedit',
                            'defaults' => array (
                                'action' => 'sendedittextblock'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                )
            ),    
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Admin' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),        
    ),
 
);

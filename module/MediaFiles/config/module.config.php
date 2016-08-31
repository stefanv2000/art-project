<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MediaFiles\Controller\Index' => 'MediaFiles\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            /*
            'media-deliver' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/media/:filename{._}.:extension',
                    'constraints' => array(
                        'filename' =>'[a-zA-Z0-9]+',
                        'extension' =>'[a-zA-Z0-9]+',
                        'width' => '[0-9]+',
                        'height' => '[0-9]+'
                    ),
            
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'MediaFiles\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
            ),
            //*/
            'media-deliver' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/media[/:routepath]/:filename{._}[_i:idfile][_w:width][_h:height][_:type].:extension[/]',
                    'constraints' => array(
                        'routepath' => '[a-zA-Z0-9\/]+',
                        'filename' =>'[a-zA-Z0-9]+',
                        'idfile' =>'[0-9]+',
                        'extension' =>'[a-zA-Z0-9]+',                        
                        'type' =>'[a-zA-Z]',
                        'width' => '[0-9]+',
                        'height' => '[0-9]+'
                    ),

                    'defaults' => array(
                        '__NAMESPACE__' => 'MediaFiles\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
               ),         
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Media_FileUploadsService' => 'MediaFiles\Service\FileUploadsServiceFactory',
        ),
    ),    
    'view_manager' => array(
        'template_path_stack' => array(
            'MediaFiles' => __DIR__ . '/../view',
        ),
    ),
);

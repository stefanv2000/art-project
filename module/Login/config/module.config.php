<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Login\Controller\Index' => 'Login\Controller\IndexController',
        ),
      ),  
    'router' => array(
        'routes' => array(
        		'user-login' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/login',
        						'defaults' => array (
        								'__NAMESPACE__' => 'Login\Controller',
        								'controller' => 'Index',
        								'action' => 'login'
        						)
        				),
        				'may_terminate' => true,
        		)
        		,
        		'user-logout' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/logout',
        						'defaults' => array (
        								'__NAMESPACE__' => 'Login\Controller',
        								'controller' => 'Index',
        								'action' => 'logout'
        						)
        				),
        				'may_terminate' => true,
        		)
        		,
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Login' => __DIR__ . '/../view',
        ),
    ),
);

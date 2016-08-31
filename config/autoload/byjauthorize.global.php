<?php
/**
 * configuraion file for the BjyAuthorize Module 
 */
return array (
	'bjyauthorize' => array (
		// default role for unauthenticated users
		'default_role' => 'guest',
		 
		// default role for authenticated users (if using the
		// 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider' identity provider)
		//'authenticated_role' => 'user',
		
		// identity provider service name
		'identity_provider' => 'Byj_IdentityRoleProvider',
		
		// Role providers to be used to load all available roles into Zend\Permissions\Acl\Acl
		// Keys are the provider service names, values are the options to be passed to the provider
		'role_providers' => array (
			'BjyAuthorize\Provider\Role\Config' => array (
				'guest' => array (),
				'admin' => array (),
			) 
		),
		
		// Resource providers to be used to load all available resources into Zend\Permissions\Acl\Acl
		// Keys are the provider service names, values are the options to be passed to the provider
		'resource_providers' => array (),
		
		// Rule providers to be used to load all available rules into Zend\Permissions\Acl\Acl
		// Keys are the provider service names, values are the options to be passed to the provider
		'rule_providers' => array (),
		
		// Guard listeners to be attached to the application event manager

		'guards' => array (
			'BjyAuthorize\Guard\Route' => array (
    		    ['route' => 'user-login', 'roles' => ['guest','admin']],
			    ['route' => 'media-deliver', 'roles' => ['guest','admin']],
			    ['route' => 'user-logout', 'roles' => ['admin']],
				['route' => 'admin-index', 'roles' => ['admin']],
				['route' => 'admin-dbbackup', 'roles' => ['admin']],

			    ['route' => 'admin-section', 'roles' => ['admin']],
			    ['route' => 'admin-section/sort', 'roles' => ['admin']],
			    ['route' => 'admin-section/add', 'roles' => ['admin']],
				['route' => 'admin-section/addform', 'roles' => ['admin']],
			    ['route' => 'admin-section/changestatus', 'roles' => ['admin']],
			    ['route' => 'admin-section/editform', 'roles' => ['admin']],
			    ['route' => 'admin-section/edit', 'roles' => ['admin']],
			    ['route' => 'admin-section/delete', 'roles' => ['admin']],
			    ['route' => 'admin-section/getsectionhtml', 'roles' => ['admin']],
				['route' => 'admin-section/sectionslist', 'roles' => ['admin']],
				['route' => 'admin-section/move', 'roles' => ['admin']],
			    ['route' => 'admin-content/upload', 'roles' => ['admin']],
				['route' => 'admin-content/uploadvideolink', 'roles' => ['admin']],
				['route' => 'admin-content/uploadcover', 'roles' => ['admin']],
			    ['route' => 'admin-content/sort', 'roles' => ['admin']],
				['route' => 'admin-content/getcover', 'roles' => ['admin']],
				['route' => 'admin-content/removecover', 'roles' => ['admin']],
				['route' => 'admin-content/delete', 'roles' => ['admin']],
				['route' => 'admin-content/bulkdelete', 'roles' => ['admin']],
				['route' => 'admin-content/getcontenthtml', 'roles' => ['admin']],
				['route' => 'admin-content/bulkchangestatus', 'roles' => ['admin']],
				['route' => 'admin-content/editform', 'roles' => ['admin']],
				['route' => 'admin-content/edit', 'roles' => ['admin']],
				['route' => 'admin-content/bulkmove', 'roles' => ['admin']],
			    ['route' => 'admin-textblock/delete', 'roles' => ['admin']],
			    ['route' => 'admin-textblock/edit', 'roles' => ['admin']],
			    ['route' => 'admin-textblock/changestatus', 'roles' => ['admin']],
			    ['route' => 'admin-textblock/add', 'roles' => ['admin']],
				['route' => 'admin-textblock/sendadd', 'roles' => ['admin']],
			    ['route' => 'admin-textblock/sort', 'roles' => ['admin']],
			    ['route' => 'admin-textblock/editform', 'roles' => ['admin']],
			    ['route' => 'admin-textblock/gettextblockhtml', 'roles' => ['admin']],

			    ['route' => 'home', 'roles' => ['admin']],
				['route' => 'frontend', 'roles' => ['guest','admin']],
				['route' => 'frontend/projects', 'roles' => ['guest','admin']],
				['route' => 'frontend/pages', 'roles' => ['guest','admin']],
				['route' => 'frontend/default', 'roles' => ['guest']],
				['route' => 'menurest', 'roles' => ['guest','admin']],
				['route' => 'projectrest', 'roles' => ['guest','admin']],
				['route' => 'projectmotionrest', 'roles' => ['guest','admin']],
				['route' => 'pagerest', 'roles' => ['guest','admin']],
				['route' => 'introrest', 'roles' => ['guest','admin']],
				['route' => 'sendcontactrest', 'roles' => ['guest','admin']],
				['route' => 'stillmain', 'roles' => ['guest','admin']],
				['route' => 'motionmain', 'roles' => ['guest','admin']],



			),
				 
		),
		
		// strategy service name for the strategy listener to be used when permission-related errors are detected
		'unauthorized_strategy' => 'Byj_MyRedirectStrategy',
		
	
		// cache options have to be compatible with Zend\Cache\StorageFactory::factory
		'cache_options' => array (
			'adapter' => array (
				'name' => 'memory' 
			),
			'plugins' => array (
				'serializer' 
			) 
		),
		
		// Key used by the cache for caching the acl
		'cache_key' => 'bjyauthorize_acl' 
	),
	
	'zenddevelopertools' => array (
		'profiler' => array (
			'collectors' => array (
				'bjy_authorize_role_collector' => 'BjyAuthorize\\Collector\\RoleCollector' 
			) 
		),
		'toolbar' => array (
			'entries' => array (
				'bjy_authorize_role_collector' => 'zend-developer-tools/toolbar/bjy-authorize-role' 
			) 
		) 
	) 
);
//*/

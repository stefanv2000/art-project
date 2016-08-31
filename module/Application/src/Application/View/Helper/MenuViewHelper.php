<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class MenuViewHelper extends AbstractHelper
{
	public function __construct()
	{
		
	}

	public function __invoke()
	{
		$auth = new AuthenticationService();
		$routelist=array();
		if (!$auth->hasIdentity()){
			$routelist[] = array('route' =>'home','name' => 'Home');
			$routelist[] = array('route' =>'user-login','name' => 'Login');
			
		} else {
			$identity = $auth->getIdentity();
			if ($identity['type'] == 'admin'){
				//$routelist[] = array('route' =>'admin-index','name' => 'Dashboard');
				$routelist[] = array('route' =>'home','name' => 'Home');
				$routelist[] = array('route' =>'admin-section','name' => 'Sections');
				
			}			
			$routelist[] = array('route' =>'user-logout','name' => 'Log out');
			
			
		}

		return $this->getView()->render('application/menu/display.phtml', array('routelist' => $routelist));

	}
	}
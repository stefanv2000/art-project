<?php

namespace Login\Authentication;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Entities\Mapper\AdminMapper;

/**
 * Adapter for authentication service. 
 *
 * @author Stefan Valea stefanvalea@gmail.com
 *        
 */
class CTAuthAdapter implements AdapterInterface {
	
	/**
	 *
	 * @var string
	 */
	protected $email;
	
	/**
	 * password in plain text
	 * 
	 * @var string
	 */
	protected $password;
	
	/**
	 * 
	 * @var AdminMapper
	 */
	protected $adminMapper;
	
	
	
	/**
	 * cosntructor gets a username, password, service locator
	 * 
	 * @param string $username        	
	 * @param string $password        	
	 * @param ServiceLocatorAwareInterface $serviceLocator        	
	 */
	public function __construct($email, $password, ServiceLocatorAwareInterface $serviceLocator) {
		$this->email = $email;
		$this->password = $password;
		
		$this->adminMapper = $serviceLocator->getServiceLocator ()->get ( "Entities_AdminMapper" );
	}
	
	/**
	 * Verifies credentials and returns the proper result 
	 * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
	 */
	public function authenticate() {
		
		//try to authenticate as admin
		$admin = $this->adminMapper->findAdminByEmail( $this->email );
		if ($admin != null ){
			if (! password_verify ( $this->password, $admin->getPassword () )) {
				// invalid password
				$result = new Result ( Result::FAILURE, null, array (
					"Login failed."
				) );
			} else {
				// login success
				$result = new Result ( Result::SUCCESS, array (
					'id' => $admin->getId (),
					'email' => $admin->getEmail (),
					'type' => 'admin',
					'name' => $admin->getName(),
						) );
			}
			return $result;			
		}
		
		$result = new Result ( Result::FAILURE,null,array("Login failed."));
		return $result;
	}

	
}

?>
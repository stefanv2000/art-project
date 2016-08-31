<?php

namespace Application\Provider\Identity;

use BjyAuthorize\Provider\Identity\ProviderInterface;
use Zend\Authentication\AuthenticationService;
/**
 * Identity role provider for BjyAuthorize module
 * 
 * @author Stefan Valea stefanvalea@gmail.com
 *
 */
class IdentityAuthProvider implements ProviderInterface{
	
	protected $defaultRole = 'guest';
	/* Return role for current identity (if exists)
	 * @see \BjyAuthorize\Provider\Identity\ProviderInterface::getIdentityRoles()
	 */
	public function getIdentityRoles() {
		$auth = new AuthenticationService();
		if (!$auth->hasIdentity()){
			//guest role if there's no identity
			return array($this->defaultRole);
		}
		//get identity from the auth service
		//identity is an array that contains the identity type (user,admin)
		$identity = $auth->getIdentity();
		
		if (array_key_exists("type", $identity)) {
			return array($identity['type']);
		} else {
			//if type doesn't exists in the $identity return default role
			return array($this->defaultRole);
		}
		
	}

	
}

?>
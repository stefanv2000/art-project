<?php

namespace Application\Service\Identity;

use Zend\ServiceManager\FactoryInterface;
use Application\Provider\Identity\IdentityAuthProvider;
/**
 * service class to provide identity roles provider instance
 * @author Stefan Valea stefanvalea@gmail.com
 *
 */
class IdentityAuthProviderFactory implements FactoryInterface{
	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
		$identityProvider = new IdentityAuthProvider();
		return $identityProvider;		
	}

}

?>
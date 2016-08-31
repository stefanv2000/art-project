<?php

namespace Application\Service\Identity;

use Zend\ServiceManager\FactoryInterface;
use Application\View\MyRedirectStrategy;
/**
 * service class to provide an instance of the redirect strategy for the unauthorized routes in byjauthorize
 * @author Stefan Valea stefanvalea@gmail.com
 *
 */
class MyRedirectStrategyFactory implements FactoryInterface{
	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
		return new MyRedirectStrategy();
	}

	
}

?>
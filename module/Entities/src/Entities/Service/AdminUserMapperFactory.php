<?php

namespace Entities\Service;

use Zend\ServiceManager\FactoryInterface;
use Entities\Entity\AdminUser;
use Entities\Mapper\AdminMapper;

/**
 * 
 * @author Stefan Valea stefanvalea@gmail.com
 *
 */
class AdminUserMapperFactory implements FactoryInterface{
	/**
	 * creates an instance of the AdminMapper
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
		$em = $serviceLocator->get("Doctrine\ORM\EntityManager");
	
		$mapper = new AdminMapper($em);
		
		return $mapper;		
		
	}

	
}

?>
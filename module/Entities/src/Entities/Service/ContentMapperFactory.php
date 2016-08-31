<?php

namespace Entities\Service;

use Zend\ServiceManager\FactoryInterface;
use Entities\Mapper\ContentMapper;

/**
 * 
 * @author Stefan Valea stefanvalea@gmail.com
 *
 */
class ContentMapperFactory implements FactoryInterface{
	/**
	 * creates an instance of the ContentMapper
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
		$em = $serviceLocator->get("Doctrine\ORM\EntityManager");
	
		$mapper = new ContentMapper($em);
		
		return $mapper;		
		
	}

	
}

?>
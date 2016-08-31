<?php

namespace Frontend\View\Helper;

use Zend\ServiceManager\FactoryInterface;

class InitializeModelsHelperFactory implements FactoryInterface{

	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
		$sectionMapper = $serviceLocator->getServiceLocator()->get('Entities_SectionMapper');
		return new InitializeModelsHelper($sectionMapper);
	}

	
}

?>
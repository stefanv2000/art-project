<?php
namespace MediaFiles\Service;

use Zend\ServiceManager\FactoryInterface;

/**
 * 
 * @author Stefan Valea stefanvalea@gmail.com
 *
 */
class FileUploadsServiceFactory implements FactoryInterface{
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
	    
		$fus = new FileUploadsService($serviceLocator);
		
		return $fus;		
		
	}

	
}

?>
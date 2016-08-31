<?php
namespace Entities\Service;


use Zend\ServiceManager\FactoryInterface;
use Entities\Mapper\TextBlockMapper;


/**
 *
 * @author Stefan Valea stefanvalea@gmail.com
 *
 */
class TextBlockMapperFactory implements FactoryInterface{
    /**
     * creates an instance of the TextBlockMapper
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $em = $serviceLocator->get("Doctrine\ORM\EntityManager");

        $mapper = new TextBlockMapper($em);

        return $mapper;

    }


}

?>
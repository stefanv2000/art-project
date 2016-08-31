<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Entities/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Entities\Entity' => 'application_entities'
                )
                	
            ),
        ),
    ),    
    'service_manager' => array(
        'factories' => array(
            'Entities_AdminMapper' => 'Entities\Service\AdminUserMapperFactory',
            'Entities_SectionMapper' => 'Entities\Service\SectionMapperFactory',
            'Entities_ContentMapper' => 'Entities\Service\ContentMapperFactory',
            'Entities_TextBlockMapper' => 'Entities\Service\TextBlockMapperFactory',
        ),
    ),    
    'view_manager' => array(
        'template_path_stack' => array(
            'Entities' => __DIR__ . '/../view',
        ),
    ),
);

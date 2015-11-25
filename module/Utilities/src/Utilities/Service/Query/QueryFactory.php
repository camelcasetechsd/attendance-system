<?php

namespace Utilities\Service\Query;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Utilities\Service\Query\Query;

class QueryFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        // Get the entity manager through our service manager
        $entitymanager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $query = new Query($entitymanager);
        return $query;
    }

}

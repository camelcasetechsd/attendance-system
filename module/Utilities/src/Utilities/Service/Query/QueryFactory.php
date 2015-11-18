<?php

namespace Utilities\Service\Query;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Utilities\Service\Query\Query;

class QueryFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        // Get the entity manager through our service manager
        $entitymanager = $serviceLocator->get('entitymanager');
        $query = new Query($entitymanager);
        return $query;
    }

}

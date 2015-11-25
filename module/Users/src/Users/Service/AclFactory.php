<?php

namespace Users\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Users\Acl\Acl;

class AclFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Configuration');
        $acl = new Acl($config);
        return $acl;
    }
}

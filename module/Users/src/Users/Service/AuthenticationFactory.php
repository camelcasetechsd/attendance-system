<?php

namespace Users\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Users\Auth\Authentication;

class AuthenticationFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $wrapperQuery = $serviceLocator->get('wrapperQuery');
        
        $authentication = new Authentication($wrapperQuery);

        return $authentication;
    }
}

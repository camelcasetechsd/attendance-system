<?php

namespace Users\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Users\Event\Authentication;

class AuthenticationFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $acl = $serviceLocator->get('Users\Acl\Acl');
        
        $authentication = new Authentication();
        $authentication->setAclClass($acl);

        return $authentication;
    }
}

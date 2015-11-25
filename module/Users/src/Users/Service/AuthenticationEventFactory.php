<?php

namespace Users\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Users\Event\AuthenticationEvent;

class AuthenticationEventFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $acl = $serviceLocator->get('Users\Acl\Acl');
        
        $authenticationEvent = new AuthenticationEvent();
        $authenticationEvent->setAclClass($acl);

        return $authenticationEvent;
    }
}

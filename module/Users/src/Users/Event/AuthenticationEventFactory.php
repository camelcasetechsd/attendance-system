<?php

namespace Users\Event;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Users\Event\AuthenticationEvent;

/**
 * AuthenticationEvent Factory
 * 
 * Prepare AuthenticationEvent service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @property AclClass $_aclClass
 * 
 * @package users
 * @subpackage event
 */
class AuthenticationEventFactory implements FactoryInterface {

    /**
     * Prepare AuthenticationEvent service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses AuthenticationEvent
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthenticationEvent
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $acl = $serviceLocator->get('Users\Acl\Acl');
        
        $authenticationEvent = new AuthenticationEvent();
        $authenticationEvent->setAclClass($acl);

        return $authenticationEvent;
    }
}

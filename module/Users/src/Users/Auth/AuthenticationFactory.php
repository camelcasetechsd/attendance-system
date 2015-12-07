<?php

namespace Users\Auth;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Users\Auth\Authentication;

/**
 * Authentication Factory
 * 
 * Prepare Authentication service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package users
 * @subpackage auth
 */
class AuthenticationFactory implements FactoryInterface {

    /**
     * Prepare Authentication service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Authentication
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Authentication
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $wrapperQuery = $serviceLocator->get('wrapperQuery');
        
        $authentication = new Authentication($wrapperQuery);

        return $authentication;
    }
}

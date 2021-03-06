<?php

namespace Users\Acl;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Users\Acl\Acl;

/**
 * Acl Factory
 * 
 * Prepare Acl service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package users
 * @subpackage acl
 */
class AclFactory implements FactoryInterface {

    /**
     * Prepare Acl service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Acl
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Acl
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Configuration');
        $acl = new Acl($config);
        return $acl;
    }
}

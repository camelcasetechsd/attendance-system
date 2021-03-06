<?php

namespace Users\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Users\Model\User;

/**
 * User Factory
 * 
 * Prepare User service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package users
 * @subpackage model
 */
class UserFactory implements FactoryInterface {

    /**
     * Prepare User service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses User
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return User
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Users\Entity\User');
        return new User($query);
    }

}

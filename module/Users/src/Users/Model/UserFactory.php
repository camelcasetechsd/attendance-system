<?php

namespace Users\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Users\Model\User;

class UserFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Users\Entity\User');
        return new User($query);
    }

}

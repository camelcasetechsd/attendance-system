<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\Permission;

class PermissionFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\Permission');
        $notificationsModel = $serviceLocator->get('Notifications\Model\Notifications');
        return new Permission($query, $notificationsModel);
    }

}

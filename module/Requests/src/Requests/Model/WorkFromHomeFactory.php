<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\WorkFromHome;

class WorkFromHomeFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\WorkFromHome');
        $notificationsModel = $serviceLocator->get('Notifications\Model\Notifications');
        return new WorkFromHome($query, $notificationsModel);
    }

}

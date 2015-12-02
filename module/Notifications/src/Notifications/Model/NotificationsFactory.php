<?php

namespace Notifications\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Notifications\Model\Notifications;

class NotificationsFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Notifications\Entity\Notification');
        return new Notifications($query);
    }

}

<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\Vacation;

class VacationFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\VacationRequest');
        $notificationsModel = $serviceLocator->get('Notifications\Model\Notifications');
        return new Vacation($query, $notificationsModel);
    }

}

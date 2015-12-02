<?php

namespace Myattendance\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Myattendance\Model\Vacation;

class VacationFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\VacationRequest');
        return new Vacation($query);
    }

}

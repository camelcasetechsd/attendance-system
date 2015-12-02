<?php

namespace Myattendance\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Myattendance\Model\Attendance;

class AttendanceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Settings\Entity\AttendanceRecord');
        return new Attendance($query);
    }

}

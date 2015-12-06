<?php

namespace Settings\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Settings\Model\Attendance;

/**
 * Attendance Factory
 * 
 * Prepare Attendance service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class AttendanceFactory implements FactoryInterface {

    /**
     * Prepare Attendance service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Attendance
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Settings\Entity\Attendance');
        return new Attendance($query);
    }

}

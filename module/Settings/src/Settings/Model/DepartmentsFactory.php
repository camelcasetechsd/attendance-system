<?php

namespace Settings\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Settings\Model\Departments;

/**
 * Departments Factory
 * 
 * Prepare Departments service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class DepartmentsFactory implements FactoryInterface {

    /**
     * Prepare Departments service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Departments
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Settings\Entity\Department');
        return new Departments($query);
    }

}

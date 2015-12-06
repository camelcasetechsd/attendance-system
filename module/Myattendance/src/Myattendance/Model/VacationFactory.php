<?php

namespace Myattendance\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Myattendance\Model\Vacation;

/**
 * Vacation Factory
 * 
 * Prepare Vacation service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class VacationFactory implements FactoryInterface {

    /**
     * Prepare Vacation service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Vacation
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\VacationRequest');
        return new Vacation($query);
    }

}

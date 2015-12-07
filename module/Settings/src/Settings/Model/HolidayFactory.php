<?php

namespace Settings\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Settings\Model\Holiday;

/**
 * Holiday Factory
 * 
 * Prepare Holiday service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package settings
 * @subpackage model
 */
class HolidayFactory implements FactoryInterface {

    /**
     * Prepare Holiday service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Holiday
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Holiday
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Settings\Entity\Holiday');
        return new Holiday($query);
    }

}

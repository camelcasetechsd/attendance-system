<?php

namespace Settings\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Settings\Model\Branches;

/**
 * Branches Factory
 * 
 * Prepare Branches service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package settings
 * @subpackage model
 */
class BranchesFactory implements FactoryInterface {

    /**
     * Prepare Branches service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Branches
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Branches
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Settings\Entity\Branch');
        return new Branches($query);
    }

}

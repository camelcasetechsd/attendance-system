<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\WorkFromHome;

/**
 * WorkFromHome Factory
 * 
 * Prepare WorkFromHome service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package requests
 * @subpackage model
 */
class WorkFromHomeFactory implements FactoryInterface {

    /**
     * Prepare WorkFromHome service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses WorkFromHome
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return WorkFromHome
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\WorkFromHome');
        $notificationsModel = $serviceLocator->get('Notifications\Model\Notifications');
        return new WorkFromHome($query, $notificationsModel);
    }

}

<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\Vacation;

/**
 * Vacation Factory
 * 
 * Prepare Vacation service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package requests
 * @subpackage model
 */
class VacationFactory implements FactoryInterface {

    /**
     * Prepare Vacation service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Vacation
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Vacation
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\VacationRequest');
        $notificationsModel = $serviceLocator->get('Notifications\Model\Notifications');
        return new Vacation($query, $notificationsModel);
    }

}

<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\Permission;

/**
 * Permission Factory
 * 
 * Prepare Permission service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package requests
 * @subpackage model
 */
class PermissionFactory implements FactoryInterface {

    /**
     * Prepare Permission service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Permission
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Permission
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Requests\Entity\Permission');
        $notificationsModel = $serviceLocator->get('Notifications\Model\Notifications');
        return new Permission($query, $notificationsModel);
    }

}

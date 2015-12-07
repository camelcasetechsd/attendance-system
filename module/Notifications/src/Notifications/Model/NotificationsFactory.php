<?php

namespace Notifications\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Notifications\Model\Notifications;

/**
 * Notifications Factory
 * 
 * Prepare Notifications service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package notifications
 * @subpackage model
 */
class NotificationsFactory implements FactoryInterface {

    /**
     * Prepare Notifications service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Notification
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Notifications
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery')->setEntity('Notifications\Entity\Notification');
        return new Notifications($query);
    }

}

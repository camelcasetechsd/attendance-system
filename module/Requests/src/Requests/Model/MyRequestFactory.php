<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\MyRequest;

/**
 * MyRequest Factory
 * 
 * Prepare MyRequest service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class MyRequestFactory implements FactoryInterface {

    /**
     * Prepare MyRequest service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return MyRequest
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery');
        $notifications = $serviceLocator->get('Notifications\Model\Notifications');
        $router = $serviceLocator->get('HttpRouter');
        return new MyRequest($query, $router, $notifications);
    }

}

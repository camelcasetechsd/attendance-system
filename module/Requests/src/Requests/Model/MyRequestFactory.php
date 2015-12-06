<?php

namespace Requests\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Requests\Model\MyRequest;

class MyRequestFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $query = $serviceLocator->get('wrapperQuery');
        $notifications = $serviceLocator->get('Notifications\Model\Notifications');
        $router = $serviceLocator->get('HttpRouter');
        return new MyRequest($query, $router, $notifications);
    }

}

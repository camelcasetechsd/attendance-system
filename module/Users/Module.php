<?php

namespace Users;

// Our main imports that we want to use
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface,AutoloaderProviderInterface {

    public function onBootstrap(MvcEvent $event) {
        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach( MvcEvent::EVENT_DISPATCH, array($this, 'mvcPreDispatch'), 100);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * MVC preDispatch Event
     *
     * @param $event
     * @return mixed
     */
    public function mvcPreDispatch($event) {
        $serviceManager = $event->getTarget()->getServiceManager();
        $auth = $serviceManager->get('Users\Event\AuthenticationEvent');

        return $auth->preDispatch($event);
    }

}

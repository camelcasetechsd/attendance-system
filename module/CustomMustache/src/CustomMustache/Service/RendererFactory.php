<?php

namespace CustomMustache\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use CustomMustache\View\Renderer;
use Zend\Authentication\AuthenticationService;

/**
 * Renderer Factory
 * 
 * Prepare Renderer service factory
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class RendererFactory implements FactoryInterface {

    /**
     * Prepare Renderer service
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param ServiceLocatorInterface $serviceLocator
     * @return Renderer
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $config = $serviceLocator->get('Configuration');
        $config = $config['mustache'];
        $config['helpers'] = array();
        $config['helpers']['unseenNotificationsCount'] = FALSE;
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {
            $config['helpers']['visible'] = TRUE;
            $storage = $auth->getIdentity();
            $role = $storage['rolename'];
            $userId = $storage['id'];
            $username = $storage['name'];
            $config['helpers']['name'] = $username;
            $acl = $serviceLocator->get('Users\Acl\Acl');
            // hide modules that are not allowed
            if ($acl->isAllowed($role, 'Users\Controller\Index')) {
                $config['helpers']['visibleUserModule'] = TRUE;
            } else {
                $config['helpers']['visibleUserModule'] = FALSE;
            }
            if ($acl->isAllowed($role, 'Settings\Controller\Index')) {
                $config['helpers']['visibleSettingsModule'] = TRUE;
            } else {
                $config['helpers']['visibleSettingsModule'] = FALSE;
            }
            // update notification icon with unseen notifications count
            $notificationsModel = $serviceLocator->get('Notifications\Model\Notifications');
            $unseenNotificationsCount = $notificationsModel->listNotifications($userId, /*$status =*/ 2, /*$countFlag =*/ true);
            $config['helpers']['unseenNotificationsCount'] = ($unseenNotificationsCount == 0)? false : $unseenNotificationsCount;
            
        } else {
            $config['helpers']['visible'] = FALSE;
        }

        /** @var $pathResolver \Zend\View\Resolver\TemplatePathStack */
        $pathResolver = clone $serviceLocator->get('ViewTemplatePathStack');
        $pathResolver->setDefaultSuffix($config['suffix']);

        /** @var $resolver \Zend\View\Resolver\AggregateResolver */
        $resolver = $serviceLocator->get('ViewResolver');
        $resolver->attach($pathResolver, 2);

        $engine = new \Mustache_Engine($this->setConfigs($config));

        $renderer = new Renderer();
        $renderer->setEngine($engine);
        $renderer->setSuffix(isset($config['suffix']) ? $config['suffix'] : 'mustache');
        $renderer->setSuffixLocked((bool) $config['suffixLocked']);
        $renderer->setResolver($resolver);

        return $renderer;
    }

    /**
     * Prepare config array
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access private
     * @param array $config
     * @return array configuration array for mustache
     */
    private function setConfigs(array $config) {
        $options = array("extension" => ".phtml");
        if (isset($config["partials_loader"])) {
            $path = $config["partials_loader"];
            if (is_array($config["partials_loader"])) {
                $path = $config["partials_loader"][0];
            }
            $config["partials_loader"] = new \Mustache_Loader_FilesystemLoader($path, $options);
        }

        if (isset($config["loader"])) {
            $config["loader"] = new \Mustache_Loader_FilesystemLoader($config["loader"][0], $options);
        }
        return $config;
    }

}

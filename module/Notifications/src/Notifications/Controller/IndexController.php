<?php

namespace Notifications\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

class IndexController extends ActionController
{

    public function indexAction()
    {
        $variables = array();
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $userId = $storage['id'];
        $notificationsModel = $this->getServiceLocator()->get('Notifications\Model\Notifications');
        $userUnSeenNotifications = $notificationsModel->listNotifications($userId, /*$status =*/ 2);
        $userSeenNotifications = $notificationsModel->listNotifications($userId, /*$status =*/ 1);
                
        $variables['unseenNotification'] = $userUnSeenNotifications;
        $variables['seenNotification'] = $userSeenNotifications;
        return new ViewModel($variables);
    }

    public function seenAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $notificationObj = $query->find('Notifications\Entity\Notification', $id);

        $notificationObj->status = 1;

        $query->save($notificationObj);
    }


}


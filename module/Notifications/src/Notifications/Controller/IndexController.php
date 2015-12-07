<?php

namespace Notifications\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

/**
 * Notifications Controller
 * 
 * notifications entries listing for current user
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package notifications
 * @subpackage controller
 */
class IndexController extends ActionController
{

    /**
     * List current user notification entries
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses AuthenticationService
     * 
     * @return ViewModel
     */
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

    /**
     * Set notification seen
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
    public function seenAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $notificationObj = $query->find('Notifications\Entity\Notification', $id);

        $notificationObj->status = 1;

        $query->save($notificationObj);
    }


}


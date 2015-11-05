<?php

use Attendance\Entity\Role;

/**
 * Listener Check if user is logged in
 * Then related business would be attached to proper events
 * Notifications for all users are triggered using proper events
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 */
class NotificationListener
{
    
    /**
     * Register event listeners
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @param Zend_EventManager_EventCollection $events
     */
    public function __construct(Zend_EventManager_EventCollection $events)
    {
        // EVENT_REQUEST_POST event listener
        $events->attach(/*$eventName = */ Bootstrap::EVENT_REQUEST_PRE,/*$callback = */ array($this, 'loadRecentNotifications'));
    }
    
    /**
     * Check if a user is logged in
     * A user is logged in, then a check for new notifications since last seen date would run 
     * Providing proper display with new notifications
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @param Zend_EventManager_Event $event
     */
    public function loadRecentNotifications(Zend_EventManager_Event $event)
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $sessionBag = $storage->read();
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        $view->unseenNotificationsCount = false;
        if(isset($sessionBag["id"])){
            $userId = $sessionBag["id"];
            $bootstrap = $event->getTarget();
            $entityManager = $bootstrap->getResource('entityManager');
            $notificationsModel = new Notifications_Model_Notifications($entityManager);
            $unseenNotificationsCount = $notificationsModel->listNotificationsCount($userId, /*$status =*/ 2);
            $view->unseenNotificationsCount = ($unseenNotificationsCount == 0)? false : $unseenNotificationsCount;
        }
    }
    
}
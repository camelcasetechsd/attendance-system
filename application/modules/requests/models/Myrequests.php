<?php

/**
 * Description of Myrequests
 *
 * @author Ahmed
 */
class Requests_Model_Myrequests
{

    public function __construct($em)
    {
        $this->_em = $em;
        $this->userRepository = $em->getRepository('Attendance\Entity\User');
    }

    public function approvalNotification($request)
    {
        // send the request to the user
        $reciver = $this->userRepository->find(array('id' => $request->user));
        $notificationData = array(
            'text' => 'Your request has been approved '
            , 'url' => '/requests/myrequests'
            , 'user' => $reciver
        );

        $notificationModel = new Notifications_Model_Notifications($this->_em);
        $notificationModel->newNotification($notificationData);
    }

    public function rejectionNotification($request)
    {
        // send the request to the user
        $reciver = $this->userRepository->find(array('id' => $request->user));
        $notificationData = array(
            'text' => 'Sorry ... your request has been rejected  '
            , 'url' => '/requests/myrequests'
            , 'user' => $reciver
        );

        $notificationModel = new Notifications_Model_Notifications($this->_em);
        $notificationModel->newNotification($notificationData);
    }

    public function zeroVacationBalanceNotification($userId)
    {
        // send the request to the user
        $reciver = $this->userRepository->find(array('id' => $userId));
        $notificationData = array(
            'text' => "You've reached your balance of vacations limit ( casual & annual )"
            , 'url' => '/myattendance/vacation'
            , 'user' => $reciver
        );

        $notificationModel = new Notifications_Model_Notifications($this->_em);
        $notificationModel->newNotification($notificationData);
    }

    public function lessThanZeroVacationBalanceNotification($userId)
    {
        // send the request to the user
        $reciver = $this->userRepository->find(array('id' => $userId));
        $notificationData = array(
            'text' => "You've exceeded your available balance of vacations ( casual & annual )"
            , 'url' => '/myattendance/vacation'
            , 'user' => $reciver
        );

        $notificationModel = new Notifications_Model_Notifications($this->_em);
        $notificationModel->newNotification($notificationData);
    }
    public function vacationBalanceAlarmNotification($user){
        $reciver = $this->userRepository->find(array('id' => 28));
        $notificationData = array(
            'text' => $user->name."have exceeded his/her available balance of vacations ( casual & annual )"
            , 'url' => '/myattendance/vacation'
            , 'user' => $reciver
        );

        $notificationModel = new Notifications_Model_Notifications($this->_em);
        $notificationModel->newNotification($notificationData);
    }
}

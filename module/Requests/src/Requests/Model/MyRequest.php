<?php

namespace Requests\Model;

use Requests\Entity\Permission;

class MyRequest {

    protected $query;
    protected $notificationsModel;
    protected $router;

    public function __construct($query, $router, $notificationsModel) {
        $this->query = $query;
        $this->router = $router;
        $this->notificationsModel = $notificationsModel;
    }

    public function approve($requestId, $requestType) {
        $request = $this->getRequestEntity($requestId, $requestType);
        $previousRequestState = $request->status;
        $request->status = Permission::STATUS_APPROVED;
        $this->query->save($request);
        // affecting user's vacation balance
        $user = $request->user;
        switch ($requestType) {
            case "VacationRequest" :
                $vacationUrl = $this->router->assemble(array('action' => 'index'), array('name' => 'myattendanceVacation'));
                if ($request->vacationType->description == 'Casual' || $request->vacationType->description == 'Annual') {
                    //to make sure its not approved twice
                    $vacationPeriod = $request->fromDate->diff($request->toDate);
                    if ($previousRequestState == Permission::STATUS_SUBMITTED) {
                        $user->vacationBalance = $user->vacationBalance - ($vacationPeriod->days + 1);
                        $this->query->setEntity('Users\Entity\User')->save($user);
                    }
                }
                if ($user->vacationBalance == 0) {
                    //sending notification to the one who asked for the vacation
                    $text = "You've reached your balance of vacations limit ( casual & annual )";
                    $this->notificationsModel->create($text, $vacationUrl, $user->id);
                } if ($user->vacationBalance < 0) {
                    //sending notification to the one who asked for the vacation
                    $text = "You've exceeded your available balance of vacations ( casual & annual )";
                    $this->notificationsModel->create($text, $vacationUrl, $user->id);

                    //sending to the manager that perivious one exceeded his/her limit
                    $text = $user->name . " have exceeded his/her available balance of vacations ( casual & annual )";
                    $this->notificationsModel->create($text, $vacationUrl);
                }
                break;
        }
        $myRequestsUrl = $this->router->assemble(array('action' => 'index'), array('name' => 'requestsMyrequests'));
        $text = 'Your request has been approved ';
        $this->notificationsModel->create($text, $myRequestsUrl, $user->id);
    }
    
    public function decline($requestId, $requestType) {
        $request = $this->getRequestEntity($requestId, $requestType);
        $request->status = Permission::STATUS_DENIED;
        $this->query->save($request);
        
        // affecting user's vacation balance
        $user = $request->user;
        $myRequestsUrl = $this->router->assemble(array('action' => 'index'), array('name' => 'requestsMyrequests'));
        $text = 'Sorry ... your request has been rejected  ';
        $this->notificationsModel->create($text, $myRequestsUrl, $user->id);
    }
    
    public function cancel($requestId, $requestType) {
        $request = $this->getRequestEntity($requestId, $requestType);
        $request->status = Permission::STATUS_CANCELLED;
        $this->query->save($request);
    }

    public function getRequestEntity($requestId, $requestType) {
        switch ($requestType) {
            case "Permission" :
                $this->query->setEntity('Requests\Entity\Permission');
                break;
            case "VacationRequest" :
                $this->query->setEntity('Requests\Entity\VacationRequest');
                break;
            case "WorkFromHome" :
                $this->query->setEntity('Requests\Entity\WorkFromHome');
                break;
        }

        return $this->query->find(/* $entityName = */null, $requestId);
    }

}

<?php

namespace Myattendance\Model;

use Requests\Entity\VacationRequest;

class Vacation {

    protected $query;

    public function __construct($query) {
        $this->query = $query;
    }

    public function getVacationBalance($userId)
    {
        $user = $this->query->find('Users\Entity\User', $userId);
        return $user->vacationBalance;
    }
    
    public function getVacation($userId, $vacationType)
    {
        $result = $this->query->findBy('Requests\Entity\VacationRequest',array(
            'user' => $userId,
            'vacationType' => $vacationType,
        ));
        foreach ($result as $key) {
            $key->dateOfSubmission = date_format($key->dateOfSubmission, 'm/d/Y');
            $key->fromDate = date_format($key->fromDate, 'm/d/Y');
            $key->toDate = date_format($key->toDate, 'm/d/Y');

            switch ($key->status) {
                case VacationRequest::STATUS_SUBMITTED :
                    $key->status = 'Submitted';
                    break;
                case VacationRequest::STATUS_CANCELLED :
                    $key->status = 'Cancelled';
                    break;
                case VacationRequest::STATUS_APPROVED :
                    $key->status = 'Approved';
                    break;
                case VacationRequest::STATUS_DENIED :
                    $key->status = 'Denied';
                    break;
            }
        }
        return $result;
    }
    
    public function getVacationNumber($userId, $vacationType)
    {
        $result = $this->query->findBy('Requests\Entity\VacationRequest', array(
            'user' => $userId,
            'vacationType' => $vacationType,
            'status' => 3
        ));
       
        $startArray = array();
        $endArray = array();
        foreach ($result as $key) {
            array_push($startArray, $key->fromDate);
            array_push($endArray, $key->toDate);
        }
        $sum = 0;
        for ($index = 0; $index < count($startArray); $index++) {
            $startTemp = explode('/', $startArray[$index]);
            $endTemp = explode('/', $endArray[$index]);
            $sum = ($endTemp[1] - $startTemp[1] + 1) + $sum;
        }
        return $sum;
    }
}

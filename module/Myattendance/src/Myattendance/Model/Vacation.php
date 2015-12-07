<?php

namespace Myattendance\Model;

use Requests\Entity\VacationRequest;

/**
 * Vacation Model
 * 
 * Handles VacationRequest Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @property Utilities\Service\Query\Query $query wrapper query
 * @package myattendance
 * @subpackage model
 */
class Vacation {

    /**
     *
     * @var Utilities\Service\Query\Query 
     */
    protected $query;

    /**
     * set needed properties
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Utilities\Service\Query\Query $query
     */
    public function __construct($query) {
        $this->query = $query;
    }

    /**
     * Get user remaining vacation balance
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $userId logged in user id
     * @return int vacation balance
     */
    public function getVacationBalance($userId)
    {
        $user = $this->query->find('Users\Entity\User', $userId);
        return $user->vacationBalance;
    }
    
    /**
     * Get user taken vacations
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $userId logged in user id
     * @param int $vacationType
     * 
     * @return array vacations
     */
    public function getVacation($userId, $vacationType)
    {
        $result = $this->query->findBy('Requests\Entity\VacationRequest',array(
            'user' => $userId,
            'vacationType' => $vacationType,
        ));
        // prepare data for display
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
    
    /**
     * Get user taken vacations count
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $userId logged in user id
     * @param int $vacationType
     * 
     * @return int vacations count
     */
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
        // get days summation for taken vacations
        $sum = 0;
        for ($index = 0; $index < count($startArray); $index++) {
            $startTemp = explode('/', $startArray[$index]);
            $endTemp = explode('/', $endArray[$index]);
            $sum = ($endTemp[1] - $startTemp[1] + 1) + $sum;
        }
        return $sum;
    }
}

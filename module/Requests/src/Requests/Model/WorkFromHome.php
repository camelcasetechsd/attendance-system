<?php

namespace Requests\Model;

use Requests\Entity\WorkFromHome as WorkFromHomeEntity;

/**
 * WorkFromHome Model
 * 
 * Handles WorkFromHome Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @property Utilities\Service\Query\Query $query
 * @property Notifications\Model\Notifications $notificationsModel
 * 
 * @package requests
 * @subpackage model
 */
class WorkFromHome {

    /**
     *
     * @var Utilities\Service\Query\Query 
     */
    protected $query;
    /**
     *
     * @var Notifications\Model\Notifications 
     */
    protected $notificationsModel;

    /**
     * Set needed properties
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Utilities\Service\Query\Query $query
     * @param Notifications\Model\Notifications $notificationsModel
     */
    public function __construct($query, $notificationsModel) {
        $this->query = $query;
        $this->notificationsModel = $notificationsModel;
    }

    /**
     * Create new vacation
     * notify manager with new request
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Requests\Entity\workFromHome $workfromhomeObj
     * @param array $data
     * @param int $userId
     * @param string $url
     */
    public function create($workfromhomeObj, $data, $userId, $url) {
        $user = $this->query->find('Users\Entity\User', $userId);
        $data['user'] = $user;
        $data['dateOfSubmission'] = "now";
        $data['status'] = WorkFromHomeEntity::STATUS_SUBMITTED;
        $this->query->setEntity('Requests\Entity\WorkFromHome')->save($workfromhomeObj, $data);
        $text = $user->name . ' is Asking for a work from home request  from ' . $data['startDate'] . ' to ' . $data['endDate'];
        $this->notificationsModel->create($text, $url);
    }

    /**
     * Prepare WorkFromHome Entities for display
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param array $workFromHomeEntities
     * @return array WorkFromHome Entities array after being prepared for display
     */
    public function prepareForDisplay($workFromHomeEntities) {
        foreach ($workFromHomeEntities as $workFromHome) {
            $workFromHome->dateOfSubmission = date_format($workFromHome->dateOfSubmission, 'm/d/Y');
            $workFromHome->startDate = date_format($workFromHome->startDate, 'm/d/Y');
            if (empty($workFromHome->endDate)) {
                $workFromHome->endDate = NULL;
            } else {
                $workFromHome->endDate = date_format($workFromHome->endDate, 'm/d/Y');
            }
            $workFromHome->user = $workFromHome->user->getName();
            switch ($workFromHome->status) {
                case WorkFromHomeEntity::STATUS_SUBMITTED :
                    $workFromHome->status = 'Submitted';
                    break;
                case WorkFromHomeEntity::STATUS_CANCELLED :
                    $workFromHome->status = 'Cancelled';
                    break;
                case WorkFromHomeEntity::STATUS_APPROVED :
                    $workFromHome->status = 'Approved';
                    break;
                case WorkFromHomeEntity::STATUS_DENIED :
                    $workFromHome->status = 'Denied';
                    break;
            }
        }
        return $workFromHomeEntities;
    }

}

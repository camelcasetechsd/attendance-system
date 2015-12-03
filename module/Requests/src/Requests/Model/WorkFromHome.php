<?php

namespace Requests\Model;

use Requests\Entity\WorkFromHome as WorkFromHomeEntity;

class WorkFromHome {

    protected $query;
    protected $notificationsModel;

    public function __construct($query, $notificationsModel) {
        $this->query = $query;
        $this->notificationsModel = $notificationsModel;
    }

    public function create($permissionObj, $data, $userId, $url) {
        $user = $this->query->find('Users\Entity\User', $userId);
        $data['user'] = $user;
        $data['dateOfSubmission'] = "now";
        $data['status'] = WorkFromHomeEntity::STATUS_SUBMITTED;
        $this->query->setEntity('Requests\Entity\WorkFromHome')->save($permissionObj, $data);
        $text = $user->name . ' is Asking for a work from home request  from ' . $data['startDate'] . ' to ' . $data['endDate'];
        $this->notificationsModel->create($text, $url);
    }

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

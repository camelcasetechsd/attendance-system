<?php

namespace Requests\Model;

use Requests\Entity\VacationRequest as VacationEntity;
use Utilities\Service\Random;
use Zend\File\Transfer\Adapter\Http;
use Settings\Entity\Vacation as VacationType ;

/**
 * Vacation Model
 * 
 * Handles Vacation Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author mohamed ramadan
 * 
 * @property Utilities\Service\Query\Query $query
 * @property Notifications\Model\Notifications $notificationsModel
 * @property Utilities\Service\Random $random
 * 
 * @package requests
 * @subpackage model
 */
class Vacation {

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
     *
     * @var Utilities\Service\Random 
     */
    protected $random;

    /**
     * Set needed properties
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param type $query
     * @param type $notificationsModel
     * 
     * @uses Random
     */
    public function __construct($query, $notificationsModel) {
        $this->query = $query;
        $this->notificationsModel = $notificationsModel;
        $this->random = new Random();
    }

    /**
     * Create new vacation
     * notify manager with new request
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Requests\Entity\VacationRequest $vacationObj
     * @param array $data
     * @param int $userId
     * @param string $url
     */
    public function create($vacationObj, $data, $userId, $url) {
        $user = $this->query->find('Users\Entity\User', $userId);
        $vacationType = $this->query->find('Settings\Entity\Vacation', $data['type']);
        $data['user'] = $user;
        $data['dateOfSubmission'] = "now";
        $data['status'] = VacationEntity::STATUS_SUBMITTED;
        $data['attachment'] = $this->saveAttachement();
        $data['vacationType'] = $vacationType;
        $this->query->setEntity('Requests\Entity\VacationRequest')->save($vacationObj, $data);
        switch ($data['type']) {
            case VacationType::SICK_LEAVE:
                $vacationName = "Sick leave";
                break;
            case VacationType::CASUAL:
                $vacationName = "casual vacation";
                break;
            case VacationType::ANNUAL:
                $vacationName = "annual vacation";
                break;
        }
        $text = $user->name . ' is Asking for a ' . $vacationName . ' on ' . $data['fromDate'] . ' to ' . $data['toDate'];
        $this->notificationsModel->create($text, $url);
    }

    /**
     * Save vacation attachment
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access protected
     * @uses Http
     * 
     * @return string new attachment file name
     */
    protected function saveAttachement() {
        $uploadResult = null;
        $upload = new Http();
        $options = array('ignoreNoFile' => true);
        $upload->setOptions($options);
        $attachmentPath = 'public/upload/vacation_attachments/';
        if (!file_exists($attachmentPath)) {
            mkdir($attachmentPath, 0777);
        }
        $upload->setDestination($attachmentPath);

        try {
            // upload received file(s)
            $upload->receive();
        } catch (\Exception $e) {
            $uploadResult = 'null';
        }

        $name = $upload->getFileName('attachment');
        if (empty($name)) {
            $uploadResult = null;
        } else {
            $extention = pathinfo($name, PATHINFO_EXTENSION);
            //get random new name
            $newName = $this->random->getRandomUniqueName();

            rename($name, 'public/upload/vacation_attachments/' . $newName . '.' . $extention);

            $uploadResult = '/upload/vacation_attachments/' . $newName . '.' . $extention;
        }
        return $uploadResult;
    }

    /**
     * Prepare vacations for display
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param array $vacations
     * @return array vacations array after being prepared for display
     */
    public function prepareForDisplay($vacations) {
        
        foreach ($vacations as $vacation) {
            $vacation->dateOfSubmission = date_format($vacation->dateOfSubmission, 'm/d/Y');
            $vacation->fromDate = date_format($vacation->fromDate, 'm/d/Y');
            if (!is_null($vacation->toDate)) {
                $vacation->toDate = date_format($vacation->toDate, 'm/d/Y');
            }
            $vacation->user = $vacation->user->getName();
            $vacation->vacationType = $vacation->vacationType->getType();
            switch ($vacation->status) {
                case VacationEntity::STATUS_SUBMITTED :
                    $vacation->status = 'Submitted';
                    break;
                case VacationEntity::STATUS_CANCELLED :
                    $vacation->status = 'Cancelled';
                    break;
                case VacationEntity::STATUS_APPROVED :
                    $vacation->status = 'Approved';
                    break;
                case VacationEntity::STATUS_DENIED :
                    $vacation->status = 'Denied';
                    break;
            }
        }

        return $vacations;
    }

}

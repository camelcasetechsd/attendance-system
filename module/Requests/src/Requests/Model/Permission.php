<?php

namespace Requests\Model;

use Requests\Entity\Permission as PermissionEntity;

/**
 * Permission Model
 * 
 * Handles Permission Entity related business
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
class Permission {

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
     * Create new permission
     * notify manager with new request
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Requests\Entity\Permission $permissionObj
     * @param array $data
     * @param int $userId
     * @param string $url
     */
    public function create($permissionObj, $data, $userId, $url) {
        $user = $this->query->find('Users\Entity\User', $userId);
        $data['user'] = $user;
        $data['dateOfSubmission'] = "now";
        $data['status'] = PermissionEntity::STATUS_SUBMITTED;
        $this->query->setEntity('Requests\Entity\Permission')->save($permissionObj, $data);
        $text = $user->name . ' is Asking for a permission on ' . $data['date'] . ' from ' . $data['fromTime'] . ' to ' . $data['toTime'];
        $this->notificationsModel->create($text, $url);
    }
    
    /**
     * Prepare permissions for display
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param array $permissions
     * @return array permissions array after being prepared for display
     */
    public function prepareForDisplay($permissions)
    {
        foreach ($permissions as $permission) {
            $permission->dateOfSubmission = date_format($permission->dateOfSubmission, 'm/d/Y');
            $permission->date = date_format($permission->date, 'm/d/Y');
            $permission->fromTime = date_format($permission->fromTime, 'H:i:s');
            $permission->toTime = date_format($permission->toTime, 'H:i:s');
            $permission->user = $permission->user->getName();
            switch ($permission->status) {
                case PermissionEntity::STATUS_SUBMITTED :
                    $permission->status = 'Submitted';
                    break;
                case PermissionEntity::STATUS_CANCELLED :
                    $permission->status = 'Cancelled';
                    break;
                case PermissionEntity::STATUS_APPROVED :
                    $permission->status = 'Approved';
                    break;
                case PermissionEntity::STATUS_DENIED :
                    $permission->status = 'Denied';
                    break;
            }
        }

        return $permissions;
    }

}

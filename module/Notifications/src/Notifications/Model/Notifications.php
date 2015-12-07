<?php

namespace Notifications\Model;

use Notifications\Entity\Notification;

/**
 * Notification Model
 * 
 * Handles Notification Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @property Utilities\Service\Query\Query $query wrapper query
 * @property int $managerId ,default value is 28
 * 
 * @package notifications
 * @subpackage model
 */
class Notifications {

    /**
     *
     * @var Utilities\Service\Query\Query 
     */
    protected $query;
    /**
     *
     * @var int 
     */
    protected $managerId = 28;

    /**
     * Set needed properties
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Utilities\Service\Query\Query $query
     */
    public function __construct($query) {
        $this->query = $query;
    }

    /**
     * Create new notification
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $text
     * @param string $url
     * @param mixed $userId ,int with default is bool false where manager user id is used
     * 
     * @uses Notification
     * 
     */
    public function create($text, $url, $userId = false){
    
        if($userId === false){
            // send the request to the Manager
            $userId = $this->managerId;
        }
        $reciver = $this->query->find('Users\Entity\User', $userId);
        $notification = new Notification();
        $notification->status = Notification::STATUS_UNSEEN;
        $notification->text = $text;
        $notification->url = $url;
        $notification->user = $reciver;
        $this->query->setEntity('Notifications\Entity\Notification')->save($notification);
    }
    
    /**
     * Get Notifications
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * 
     * @param int $userId logged in user id
     * @param int $status
     * @param bool $countFlag ,default is bool false
     * @return mixed int|array Notifications Count or array of notifications according to countFlag value
     */
    public function listNotifications($userId, $status, $countFlag = false) {
        $repository = $this->query->entityRepository;
        $queryBuilder = $repository->createQueryBuilder("n");
        $selector = 'n';
        if($countFlag === true){
            $selector = 'count(n.id)';
        }
        $notificationsQuery = $queryBuilder->select($selector)
                ->andWhere($queryBuilder->expr()->eq('n.user', ':user'))
                ->andWhere($queryBuilder->expr()->eq('n.status', ':status'))
                ->setParameters(array('user' => $userId, 'status' => $status))
                ->getQuery();
        if($countFlag === true){
            $result = $notificationsQuery->getSingleScalarResult();
        }else{
            $result = $notificationsQuery->getResult();
        }
        return $result;
    }
}

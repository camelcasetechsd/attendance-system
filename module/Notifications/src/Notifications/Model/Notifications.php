<?php

namespace Notifications\Model;

use Notifications\Entity\Notification;

class Notifications {

    protected $query;
    protected $managerId = 28;

    public function __construct($query) {
        $this->query = $query;
    }

    public function create($text, $url){
    
        // send the request to the Manager
        $reciver = $this->query->find('Users\Entity\User', $this->managerId);
        $notification = new Notification();
        $notification->status = Notification::STATUS_UNSEEN;
        $notification->text = $text;
        $notification->url = $url;
        $notification->user = $reciver;
        $this->query->save($notification);
    }
    
    /**
     * get Notifications
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
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

<?php

namespace Notifications\Model;

class Notifications {

    protected $query;

    public function __construct($query) {
        $this->query = $query;
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

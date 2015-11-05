<?php

/**
 * Description of Notifications
 *
 * @author ahmed
 */
class Notifications_Model_Notifications
{

    protected $repository;

    public function __construct($em)
    {
        $this->entityManager = $em;
        $this->repository = $em->getRepository('Attendance\Entity\Notification');
    }

    public function newNotification($notificationData)
    {
        $entity = new Attendance\Entity\Notification();
        $entity->user=$notificationData['user'];
        $entity->text=$notificationData['text'];
        $entity->url=$notificationData['url'];
        $entity->status = 2;
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
    // function called to list all notification  seen or un seen
    public function listSeenNotifications($userId){
       $notifications = $this->repository->findBy(array('user'=>$userId,'status'=>1), array('id' => 'DESC'));
       return $notifications;
    }
    public function listUnSeenNotifications($userId){
       $notifications = $this->repository->findBy(array('user'=>$userId,'status'=>2), array('id' => 'DESC'));
       return $notifications;
    }
    /**
     * get Notifications Count
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @param int $userId logged in user id
     * @return int Notifications Count
     */
    public function listNotificationsCount($userId, $status){
       $queryBuilder = $this->repository->createQueryBuilder("n");
       $notificationsCount =  $queryBuilder->select('count(n.id)')
               ->where("n.user = :userId")
               ->andWhere("n.status = :status")
               ->setParameters(array('userId'=>$userId,'status'=>$status))
               ->getQuery()
               ->getSingleScalarResult();
       return $notificationsCount;
    }
    public function seenNotification($notificationId){
        $notification = $this->repository->find(array('id'=>$notificationId));
        $notification->status = 1;
        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }
    
}

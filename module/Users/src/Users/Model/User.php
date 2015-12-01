<?php

namespace Users\Model;

use Users\Entity\User as UserEntity;
use Zend\Paginator\Paginator;
use Utilities\Service\Query\PaginatorAdapter;
use Utilities\Service\Random;
use Zend\File\Transfer\Adapter\Http;
use DateTime;

class User {

    protected $query;
    protected $random;
    protected $paginator = NULL;
    protected $numberPerPage = 10.0;

    public function __construct($query)
    {
        $this->query = $query;
        $this->paginator = new Paginator(new PaginatorAdapter($query));
        $this->random = new Random();
    }
    
    public function setPage($currentPage)
    {
        $this->paginator->setCurrentPageNumber($currentPage);
    }

    public function setNumberPerPage($numberPerPage)
    {
        $this->numberPerPage = $numberPerPage;
    }

    public function setItemCountPerPage($numberPerPage)
    {
        $this->paginator->setItemCountPerPage($numberPerPage);
    }

    public function getNumberOfPages()
    {
        return (int) $this->paginator->count();
    }

    public function getCurrentItems()
    {
        return $this->paginator;
    }

    
    public function prepareForDisplay($data) {
        foreach ($data as $user) {
            switch ($user->status) {
                case UserEntity::STATUS_ACTIVE :
                    $user->status = 'Active';
                    $user->active = TRUE;
                    break;
                case UserEntity::STATUS_DELETED :
                    $user->status = 'Deleted';
                    break;
            }
        }
        return $data;
    }

    public function saveUser($userInfo , $userObj = null)
    {
        $em       = $this->query->entityManager;

        if (is_null($userObj)) {
            $entity = new UserEntity();
        } else {
            $entity = $userObj;
        }

        $entity->username = $userInfo['username'];
        $entity->name     = $userInfo['name'];
        if (is_null($userObj)) {
            $entity->password = UserEntity::hashPassword($userInfo['password']);
        }
        $dateString = $userInfo['dateOfBirth'];
        $date       = new DateTime($dateString);
        $entity->dateOfBirth = $date;
        $entity->mobile      = $userInfo['mobile'];
        $entity->description = $userInfo['description'];

        $thisPosition = $this->query->find('Settings\Entity\Position',$userInfo['position']);
        $entity->position = $thisPosition;

        $startDateString = $userInfo['startDate'];
        $startDateObj    = new DateTime($startDateString);
        $entity->startDate     = $startDateObj;
        $entity->maritalStatus = $userInfo['maritalStatus'];

        $thisBranch = $this->query->find('Settings\Entity\Branch',$userInfo["branch"]);
        $entity->branch = $thisBranch;

        $thisDepartment = $this->query->find('Settings\Entity\Department',$userInfo['department']);
        $entity->department = $thisDepartment;

        $thisManager = $this->query->find('Users\Entity\User',$userInfo['manager']);
        $entity->manager = $thisManager;

        $entity->vacationBalance = UserEntity::DEFAULT_VACATION_BALANCE;
        $entity->totalWorkingHoursThisMonth = 0;

        $entity->role = $this->query->find('Users\Entity\Role',1);

        if (!empty($userInfo['photo']['name'])) {
            $entity->photo = $this->savePhoto();
        }
        $entity->status = UserEntity::STATUS_ACTIVE;

        $em->persist($entity);

        $em->flush($entity);
    }

    protected function savePhoto()
    {
        $uploadResult = null;
        $upload       = new Http();
        $imagesPath   = 'public/upload/images/';
        $upload->setDestination($imagesPath);

        try {
            // upload received file(s)
            $upload->receive();
        } catch (\Exception $e) {
            $uploadResult = '/upload/images/defaultpic.png';
        }

        $name      = $upload->getFileName('photo');
        $extention = pathinfo($name, PATHINFO_EXTENSION);
        //get random new namez
        $newName = $this->random->getRandomName();

        rename($name, 'public/upload/images/' . $newName . '.' . $extention);

        $uploadResult = '/upload/images/' . $newName . '.' . $extention;
        return $uploadResult;
    }

   

    public function deleteUser($id)
    {
        $user         = $this->query->find(/*$entityName =*/ 'Users\Entity\User', $id);
        $user->status = UserEntity::STATUS_DELETED;
        $this->query->entityManager->merge($user);
        $this->query->entityManager->flush($user);
    }
}

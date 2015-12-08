<?php

namespace Users\Model;

use Users\Entity\User as UserEntity;
use Zend\Paginator\Paginator;
use Utilities\Service\Query\PaginatorAdapter;
use Utilities\Service\Random;
use Zend\File\Transfer\Adapter\Http;
use DateTime;

/**
 * User Model
 * 
 * Handles User Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @property Utilities\Service\Query\Query $query
 * @property Utilities\Service\Random $random
 * @property Zend\Paginator\Paginator $paginator ,default value is null
 * @property int $numberPerPage ,default value is 10.0
 * 
 * @package users
 * @subpackage model
 */
class User {

    /**
     *
     * @var Utilities\Service\Query\Query 
     */
    protected $query;

    /**
     *
     * @var Utilities\Service\Random 
     */
    protected $random;

    /**
     *
     * @var Zend\Paginator\Paginator 
     */
    protected $paginator = NULL;

    /**
     *
     * @var int 
     */
    protected $numberPerPage = 10.0;

    /**
     * Set needed properties
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses Paginator
     * @uses PaginatorAdapter
     * @uses Random
     * 
     * @param Utilities\Service\Query\Query $query
     */
    public function __construct($query) {
        $this->query = $query;
        $this->paginator = new Paginator(new PaginatorAdapter($query));
        $this->random = new Random();
    }

    /**
     * Set current page
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $currentPage
     */
    public function setPage($currentPage) {
        $this->paginator->setCurrentPageNumber($currentPage);
    }

    /**
     * Set number of pages
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $numberPerPage
     */
    public function setNumberPerPage($numberPerPage) {
        $this->numberPerPage = $numberPerPage;
    }

    /**
     * Set number of items per page
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $itemsCountPerPage
     */
    public function setItemCountPerPage($itemsCountPerPage) {
        $this->paginator->setItemCountPerPage($itemsCountPerPage);
    }

    /**
     * Get number of pages
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int number of pages
     */
    public function getNumberOfPages() {
        return (int) $this->paginator->count();
    }

    /**
     * Get number of items per page
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int number of items per page
     */
    public function getCurrentItems() {
        return $this->paginator;
    }

    /**
     * Prepare users for display
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param array $data
     * @return array users array after being prepared for display
     */
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

    /**
     * Save User
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses UserEntity
     * 
     * @param array $userInfo
     * @param Users\Entity\User $userObj ,default is null in case new user is being created
     */
    public function saveUser($userInfo, $userObj = null) {
        $em = $this->query->entityManager;

        if (is_null($userObj)) {
            $entity = new UserEntity();
        } else {
            $entity = $userObj;
        }

        $entity->username = $userInfo['username'];
        $entity->name = $userInfo['name'];
        if (is_null($userObj)) {
            $entity->password = UserEntity::hashPassword($userInfo['password']);
        }
        $dateString = $userInfo['dateOfBirth'];
        $date = new DateTime($dateString);
        $entity->dateOfBirth = $date;
        $entity->mobile = $userInfo['mobile'];
        $entity->description = $userInfo['description'];

        $thisPosition = $this->query->find('Settings\Entity\Position', $userInfo['position']);
        $entity->position = $thisPosition;

        $startDateString = $userInfo['startDate'];
        $startDateObj = new DateTime($startDateString);
        $entity->startDate = $startDateObj;
        $entity->maritalStatus = $userInfo['maritalStatus'];

        $thisBranch = $this->query->find('Settings\Entity\Branch', $userInfo["branch"]);
        $entity->branch = $thisBranch;

        $thisDepartment = $this->query->find('Settings\Entity\Department', $userInfo['department']);
        $entity->department = $thisDepartment;

        $thisManager = $this->query->find('Users\Entity\User', $userInfo['manager']);
        $entity->manager = $thisManager;

        $entity->vacationBalance = UserEntity::DEFAULT_VACATION_BALANCE;
        $entity->totalWorkingHoursThisMonth = 0;

        $entity->role = $this->query->find('Users\Entity\Role', 1);

        if (!empty($userInfo['photo']['name'])) {
            $entity->photo = $this->savePhoto();
        }
        $entity->status = UserEntity::STATUS_ACTIVE;

        $em->persist($entity);

        $em->flush($entity);
    }

    /**
     * Save user photo
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access protected
     * @uses Http
     * 
     * @return string new attachment file name
     */
    protected function savePhoto() {
        $uploadResult = null;
        $upload = new Http();
        $imagesPath = 'public/upload/images/';
        $upload->setDestination($imagesPath);

        try {
            // upload received file(s)
            $upload->receive();
        } catch (\Exception $e) {
            $uploadResult = '/upload/images/defaultpic.png';
        }

        $name = $upload->getFileName('photo');
        $extention = pathinfo($name, PATHINFO_EXTENSION);
        //get random new name
        $newName = $this->random->getRandomUniqueName();

        rename($name, 'public/upload/images/' . $newName . '.' . $extention);

        $uploadResult = '/upload/images/' . $newName . '.' . $extention;
        return $uploadResult;
    }

    /**
     * Delete User
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $userId
     */
    public function deleteUser($userId) {
        $user = $this->query->find(/* $entityName = */ 'Users\Entity\User', $userId);
        $user->status = UserEntity::STATUS_DELETED;
        $this->query->entityManager->merge($user);
        $this->query->entityManager->flush($user);
    }

}

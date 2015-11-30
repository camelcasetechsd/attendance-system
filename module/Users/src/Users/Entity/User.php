<?php

namespace Users\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @package Users\Entity
 */
class User {

    const DEFAULT_VACATION_BALANCE = 21;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    const SAME_PASSWORD = "SAME_PASSWORD";
    
    private $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public $id;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $name;

    /**
     *
     * @ORM\Column(type="string" , unique=true)
     * @var string
     */
    public $username;

    /**
     *
     * @ORM\Column(type="string" , length =64)
     * @var string
     */
    public $password;

    /**
     *
     * @ORM\Column(type="string" , length = 11 )
     * @var string
     */
    public $mobile;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateOfBirth;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $photo;

    /**
     *
     * @ORM\Column(type="string" )
     * @var string
     */
    public $maritalStatus;

    /**
     *
     * @ORM\Column(type="string" , length = 1024 )
     * @var string
     */
    public $description;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Users\Entity\Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * @var Users\Entity\Role
     */
    public $role;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Branch")
     * @ORM\JoinColumn(name="branch_id", referencedColumnName="id")
     * @var Settings\Entity\Branch
     */
    public $branch;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Department")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     * @var Settings\Entity\Department
     */
    public $department;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="manager_id", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $manager;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Position")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * @var Settings\Entity\Position
     */
    public $position;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $startDate;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $vacationBalance;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $totalWorkingHoursThisMonth;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $status;

    static public function hashPassword($password) {
        if (function_exists("password_hash")) {
            return password_hash($password, PASSWORD_BCRYPT);
        } else {
            return crypt($password);
        }
    }

    static public function verifyPassword($givenPassword, $savedPassword) {
        if (function_exists('password_verify')) {
            return password_verify($givenPassword, $savedPassword);
        } else {
            return crypt($givenPassword, $savedPassword) == $savedPassword;
        }
    }

    public function getBranch() {
        return $this->branch;
    }

    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }

    public function getDepartment() {
        return $this->department;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getManager() {
        return $this->manager;
    }

    public function getMaritalStatus() {
        return $this->maritalStatus;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function getName() {
        return $this->name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getPosition() {
        return $this->position;
    }

    public function getRole() {
        return $this->role;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getTotalWorkingHoursThisMonth() {
        return $this->totalWorkingHoursThisMonth;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getVacationBalance() {
        return $this->vacationBalance;
    }
    
    public function setBranch($branch) {
        $this->branch = $branch;
        return $this;
    }

    public function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function setDepartment($department) {
        $this->department = $department;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setManager($manager) {
        $this->manager = $manager;
        return $this;
    }

    public function setMaritalStatus($maritalStatus) {
        $this->maritalStatus = $maritalStatus;
        return $this;
    }

    public function setMobile($mobile) {
        $this->mobile = $mobile;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
        return $this;
    }

    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setTotalWorkingHoursThisMonth($totalWorkingHoursThisMonth) {
        $this->totalWorkingHoursThisMonth = $totalWorkingHoursThisMonth;
        return $this;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setVacationBalance($vacationBalance) {
        $this->vacationBalance = $vacationBalance;
        return $this;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function exchangeArray($data = array()) {
        if(array_key_exists('role', $data)){
            $this->setRole($data["role"]);
        }
        if(array_key_exists('status', $data)){
            $this->setRole($data["status"]);
        }
        if(array_key_exists('totalWorkingHoursThisMonth', $data)){
            $this->setRole($data["totalWorkingHoursThisMonth"]);
        }
        $this->setBranch($data["branch"])
                ->setDateOfBirth($data["dateOfBirth"])
                ->setDepartment($data["department"])
                ->setDescription($data["description"])
                ->setManager($data["manager"])
                ->setMaritalStatus($data["maritalStatus"])
                ->setMobile($data["mobile"])
                ->setName($data["name"])
                ->setPassword($data["password"])
                ->setPosition($data["position"])
                ->setStartDate($data["startDate"])
                ->setUsername($data["username"])
                ->setVacationBalance($data["vacationBalance"]);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'username',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'password',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 8
                        )
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'confirmPassword',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 8
                        )
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'mobile',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'Digits',
                    ),
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
                            'messages' => array(Regex::NOT_MATCH => 'This is not a mobile number!')
                        )
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'dateOfBirth',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'date',
                        'options' => array(
                            'format' => 'm/d/Y',
                        )
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'startDate',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'date',
                        'options' => array(
                            'format' => 'm/d/Y',
                        )
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'vacationBalance',
                'required' => true,
            ));
            $inputFilter->add(array(
                'name' => 'description',
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    )
                ),
            ));

            $inputFilter->add(array(
                'name' => 'photo',
                'required' => true,
                'validators' => array(
                    array('name' => 'Filesize',
                        'options' => array(
                            'max' => 2097152
                        )
                    ),
                    array('name' => 'Fileextension',
                        'options' => array(
                            'extension' => 'gif,jpg,png'
                        )
                    ),
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

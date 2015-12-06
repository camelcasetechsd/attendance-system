<?php

namespace Users\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;

/**
 * User Entity
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class User {

    /**
     * default vacation balance per year per user
     */
    const DEFAULT_VACATION_BALANCE = 21;
    /**
     * User is active
     */
    const STATUS_ACTIVE = 1;
    /**
     * User is deleted
     */
    const STATUS_DELETED = 2;
    
    /**
     *
     * @var InputFilter validation constraints 
     */
    private $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
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
     * @var int
     */
    public $vacationBalance;

    /**
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    public $totalWorkingHoursThisMonth;

    /**
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    public $status;

    /**
     * hash password
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $password
     * @return string hashed password
     */
    static public function hashPassword($password) {
        if (function_exists("password_hash")) {
            return password_hash($password, PASSWORD_BCRYPT);
        } else {
            return crypt($password);
        }
    }

    /**
     * verify submitted password matches the saved one
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $givenPassword
     * @param string $givenPassword hashed password
     * @return bool true if passwords mathced, false else
     */
    static public function verifyPassword($givenPassword, $givenPassword) {
        if (function_exists('password_verify')) {
            return password_verify($givenPassword, $savedPassword);
        } else {
            return crypt($givenPassword, $savedPassword) == $savedPassword;
        }
    }

    /**
     * Get branch
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return Settings\Entity\Branch branch
     */
    public function getBranch() {
        return $this->branch;
    }

    /**
     * Get dateOfBirth
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime dateOfBirth
     */
    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }

    /**
     * Get department
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return Settings\Entity\Department department
     */
    public function getDepartment() {
        return $this->department;
    }

    /**
     * Get description
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Get manager
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return Users\Entity\User manager
     */
    public function getManager() {
        return $this->manager;
    }

    /**
     * Get maritalStatus
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string maritalStatus
     */
    public function getMaritalStatus() {
        return $this->maritalStatus;
    }

    /**
     * Get mobile
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string mobile
     */
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * Get name
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get password
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Get photo
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string photo
     */
    public function getPhoto() {
        return $this->photo;
    }

    /**
     * Get position
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return Settings\Entity\Position position
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * Get role
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return Users\Entity\Role role
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Get startDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime startDate
     */
    public function getStartDate() {
        return $this->startDate;
    }

    /**
     * Get status
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int status
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Get totalWorkingHoursThisMonth
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int totalWorkingHoursThisMonth
     */
    public function getTotalWorkingHoursThisMonth() {
        return $this->totalWorkingHoursThisMonth;
    }

    /**
     * Get username
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string username
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Get vacationBalance
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int vacationBalance
     */
    public function getVacationBalance() {
        return $this->vacationBalance;
    }
    
    /**
     * Set branch
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Settings\Entity\Branch $branch
     * @return User current entity
     */
    public function setBranch($branch) {
        $this->branch = $branch;
        return $this;
    }

    /**
     * Set dateOfBirth
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $dateOfBirth
     * @return User current entity
     */
    public function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    /**
     * Set department
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Settings\Entity\Department $department
     * @return User current entity
     */
    public function setDepartment($department) {
        $this->department = $department;
        return $this;
    }

    /**
     * Set description
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $description
     * @return User current entity
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Set manager
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param User $manager
     * @return User current entity
     */
    public function setManager($manager) {
        $this->manager = $manager;
        return $this;
    }

    /**
     * Set maritalStatus
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $maritalStatus
     * @return User current entity
     */
    public function setMaritalStatus($maritalStatus) {
        $this->maritalStatus = $maritalStatus;
        return $this;
    }

    /**
     * Set mobile
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $mobile
     * @return User current entity
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * Set name
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $name
     * @return User current entity
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Set password
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $password
     * @return User current entity
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * Set photo
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $photo
     * @return User current entity
     */
    public function setPhoto($photo) {
        $this->photo = $photo;
        return $this;
    }

    /**
     * Set position
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Settings/Entity/Position $position
     * @return User current entity
     */
    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }

    /**
     * Set role
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Users/Entity/Role $role
     * @return User current entity
     */
    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    /**
     * Set startDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $startDate
     * @return User current entity
     */
    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * Set status
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $status
     * @return User current entity
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Set totalWorkingHoursThisMonth
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $totalWorkingHoursThisMonth
     * @return User current entity
     */
    public function setTotalWorkingHoursThisMonth($totalWorkingHoursThisMonth) {
        $this->totalWorkingHoursThisMonth = $totalWorkingHoursThisMonth;
        return $this;
    }

    /**
     * Set username
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $username
     * @return User current entity
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     * Set vacationBalance
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $vacationBalance
     * @return User current entity
     */
    public function setVacationBalance($vacationBalance) {
        $this->vacationBalance = $vacationBalance;
        return $this;
    }

    /**
     * Convert the object to an array.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return array current entity properties
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param array $data ,default is empty array
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

    /**
     * setting inputFilter is forbidden
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param InputFilterInterface $inputFilter
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    /**
     * set validation constraints
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return InputFilter validation constraints
     */
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

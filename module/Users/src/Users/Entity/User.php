<?php

namespace Users\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @package Users\Entity
 */
class User
{

    const DEFAULT_VACATION_BALANCE = 21;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

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

    static public function hashPassword($password)
    {
        if (function_exists("password_hash")) {
            return password_hash($password, PASSWORD_BCRYPT);
        } else {
            return crypt($password);
        }
    }

    static public function verifyPassword($givenPassword, $savedPassword)
    {
        if (function_exists('password_verify')) {
            return password_verify($givenPassword, $savedPassword);
        } else {
            return crypt($givenPassword , $savedPassword) == $savedPassword;
        }
    }

}
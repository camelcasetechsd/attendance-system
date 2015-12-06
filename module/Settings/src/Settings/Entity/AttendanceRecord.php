<?php

namespace Settings\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * AttendanceRecord Entity
 * @ORM\Entity
 * @ORM\Table(name="attendancerecord")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */

class AttendanceRecord
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    public $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $user;
   
    /**
     *
     * @ORM\Column(type="datetime")
     * @var time
     */
    public $timeIn;
    
    /**
     *
     * @ORM\Column(type="datetime")
     * @var time
     */
    public $timeOut;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Branch")
     * @ORM\JoinColumn(name="branch_id", referencedColumnName="id")
     * @var Settings\Entity\Branch
     */
    public $branch;
}

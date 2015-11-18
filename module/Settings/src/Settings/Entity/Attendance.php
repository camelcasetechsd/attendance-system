<?php

namespace Settings\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Branche
 * @ORM\Entity
 * @ORM\Table(name="attendance")
 * @package Settings\Entity
 */

class Attendance
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public $id;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $branch;
    
    /**
     *
     * @ORM\Column(type="time")
     * @var time
     */
    public $startTime;
    
    /**
     *
     * @ORM\Column(type="time")
     * @var time
     */
    public $endTime;
    
    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $active  = 1;

}

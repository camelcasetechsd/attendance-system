<?php

namespace Requests\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class VacationRequest
 * @ORM\Entity
 * @ORM\Table(name="vacationRequest")
 * @package Requests\Entity
 */
class VacationRequest
{

    const STATUS_SUBMITTED =1;
    const STATUS_CANCELLED =2;
    const STATUS_APPROVED =3;
    const STATUS_DENIED =4;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $user;

    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Vacation")
     * @ORM\JoinColumn(name="vacation_type", referencedColumnName="id")
     * @var Settings\Entity\Vacation
     */
    public $vacationType;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $fromDate;

    /**
     *
     * @ORM\Column(type="date" , nullable=true)
     * @var date
     */
    public $toDate;

    /**
     * @ORM\Column(type="string" , nullable=true)
     * @var string
     */
    public $attachment;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateOfSubmission;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $status;

}

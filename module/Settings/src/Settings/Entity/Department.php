<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Department
 * @ORM\Entity
 * @ORM\Table(name="department")
 * @package Settings\Entity
 */
class Department
{

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
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    public $name;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $description;

    /**
     *
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    public $address;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="manager_id", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $manager;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $status;

}

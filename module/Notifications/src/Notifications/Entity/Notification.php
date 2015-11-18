<?php

namespace Notifications\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Notification
 * @ORM\Entity
 * @ORM\Table(name="notification")
 * @package Notifications\Entity
 */

class Notification
{
    const STATUS_SEEN   = 1;
    const STATUS_UNSEEN = 2;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public $id;

   /**
     *
     * @ORM\Column(type="string" , length = 1024 )
     * @var string
     */
    public $text;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $url;

     /**
     *
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="user_id ", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $user;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $status;
}
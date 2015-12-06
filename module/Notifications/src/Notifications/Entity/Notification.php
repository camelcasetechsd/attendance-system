<?php

namespace Notifications\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notification Entity
 * @ORM\Entity
 * @ORM\Table(name="notification")
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class Notification
{
    /**
     * Notification is seen
     */
    const STATUS_SEEN   = 1;
    /**
     * Notification is unseen
     */
    const STATUS_UNSEEN = 2;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
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
     * @var int
     */
    public $status;
}
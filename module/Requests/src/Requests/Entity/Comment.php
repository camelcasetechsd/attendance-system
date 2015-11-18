<?php

namespace Requests\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 * @ORM\Entity
 * @ORM\Table(name="comment")
 * @package Requests\Entity
 */

class Comment
{
    const REQUEST_TYPE_PERMISSION = 1;    
    const REQUEST_TYPE_VACATIONREQUEST = 2;
    const REQUEST_TYPE_WORKFROMHOME = 3;
    
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
    public $body;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $user;
    
    /**
     * @ORM\Column(type="integer");
     * @var integer
     */
    public $request_id;
    
    /**
     *
     * @ORM\Column(type="integer");
     * @var integer
     */
    public $request_type;
    
    /**
     *
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    public $created;
    
}   
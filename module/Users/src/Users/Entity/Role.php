<?php

namespace Users\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Position
 * @ORM\Entity
 * @ORM\Table(name="role")
 * @package Users\Entity
 */

class Role
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
     * @ORM\Column(type="string")
     * @var string
     */
    public $name;

}
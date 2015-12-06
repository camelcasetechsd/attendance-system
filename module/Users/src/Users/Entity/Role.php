<?php

namespace Users\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Role Entity
 * @ORM\Entity
 * @ORM\Table(name="role")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class Role
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
     * @ORM\Column(type="string")
     * @var string
     */
    public $name;

}
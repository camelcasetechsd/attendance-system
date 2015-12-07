<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Branch Entity
 * @ORM\Entity
 * @ORM\Table(name="branch")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @property InputFilter $inputFilter validation constraints 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $address
 * @property Users\Entity\User $manager
 * @property int $status
 * 
 * @package settings
 * @subpackage entity
 */
class Branch {

    /**
     * Branch is active
     */
    const STATUS_ACTIVE = 1;
    /**
     * Branch is inactive
     */
    const STATUS_INACTIVE = 2;

    /**
     *
     * @var InputFilter validation constraints 
     */
    private $inputFilter;
    
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

    /**
     *
     * @ORM\Column(type="string" , length = 1024 )
     * @var string
     */
    public $description;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $address;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="manager_id ", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $manager;

    /**
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    public $status;

    /**
     * Get address
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string address
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Get description
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Get manager
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return Users\Entity\User manager
     */
    public function getManager() {
        return $this->manager;
    }

    /**
     * Get name
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get status
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int status
     */
    public function getStatus() {
        return $this->status;
    }
    
    /**
     * Set address
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $address
     * @return Branch current entity
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * Set description
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $description
     * @return Branch current entity
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Set manager
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Users\Entity\User $manager
     * @return Branch current entity
     */
    public function setManager($manager) {
        $this->manager = $manager;
        return $this;
    }

    /**
     * Set name
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $name
     * @return Branch current entity
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Set status
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $status
     * @return Branch current entity
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Convert the object to an array.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return array current entity properties
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param array $data ,default is empty array
     */
    public function exchangeArray($data = array()) {
        if(array_key_exists('status', $data)){
            $this->setStatus($data['status']);
        }
        $this->setAddress($data['address'])
                ->setDescription($data['description'])
                ->setManager($data['manager'])
                ->setName($data['name']);
    }

    /**
     * setting inputFilter is forbidden
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param InputFilterInterface $inputFilter
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    /**
     * set validation constraints
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses InputFilter
     * 
     * @access public
     * @return InputFilter validation constraints
     */
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'name',
                'required' => true,
            ));
            $inputFilter->add(array(
                'name' => 'description',
                'required' => true,
            ));
            $inputFilter->add(array(
                'name' => 'address',
                'required' => true,
            ));
            $inputFilter->add(array(
                'name' => 'manager',
                'required' => true,
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

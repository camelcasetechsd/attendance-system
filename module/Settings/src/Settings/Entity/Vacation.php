<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Vacation Entity
 * @ORM\Entity
 * @ORM\Table(name="vacation")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @property InputFilter $inputFilter validation constraints 
 * @property int $id
 * @property string $type
 * @property string $description
 * @property int $balance
 * @property int $active ,default is 1
 * 
 * @package settings
 * @subpackage entity
 */
class Vacation {

    /**
     * Vacation type is sick leave
     */
    const SICK_LEAVE = 1;
    /**
     * Vacation type is casual
     */
    const CASUAL = 2;
    /**
     * Vacation type is annual
     */
    const ANNUAL = 3;
           
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
    public $type;

    /**
     *
     * @ORM\Column(type="string" , length = 1024)
     * @var string
     */
    public $description;

    /**
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    public $balance;

    /**
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    public $active = 1;

    /**
     * Get type
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string type
     */
    public function getType() {
        return $this->type;
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
     * Get balance
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int balance
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * Get active
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int active
     */
    public function isActive() {
        return $this->active;
    }
    
    /**
     * Set type
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $type
     * @return Vacation current entity
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Set description
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $description
     * @return Vacation current entity
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Set balance
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $balance
     * @return Vacation current entity
     */
    public function setBalance($balance) {
        $this->balance = $balance;
        return $this;
    }

    /**
     * Set active
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $active
     * @return Vacation current entity
     */
    public function setActive($active) {
        $this->active = $active;
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
        if(array_key_exists('active', $data)){
            $this->setActive($data["active"]);
        }
        $this->setBalance($data['balance'])
                ->setDescription($data['description'])
                ->setType($data['type']);
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
                'name' => 'type',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'description',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    )
                ),
                'validators' => array(
                    array('name' => 'stringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 512
                        )
                    ),
                )
            ));
            $inputFilter->add(array(
                'name' => 'balance',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    )
                ),
                'validators' => array(
                    array('name' => 'Digits',
                    ),
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

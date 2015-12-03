<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class Branche
 * @ORM\Entity
 * @ORM\Table(name="vacation")
 * @package Settings\Entity
 */
class Vacation {

    const SICK_LEAVE = 1;
    const CASUAL = 2;
    const ANNUAL = 3;
                
    private $inputFilter;
    
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
     * @var integer
     */
    public $balance;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $active = 1;

    public function getType() {
        return $this->type;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function isActive() {
        return $this->active;
    }
    
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setBalance($balance) {
        $this->balance = $balance;
        return $this;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function exchangeArray($data = array()) {
        if(array_key_exists('active', $data)){
            $this->setActive($data["active"]);
        }
        $this->setBalance($data['balance'])
                ->setDescription($data['description'])
                ->setType($data['type']);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

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

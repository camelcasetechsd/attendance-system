<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class Holiday
 * @ORM\Entity
 * @ORM\Table(name="holiday")
 * @package Settings\Entity
 */
class Holiday {

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
    public $name;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateFrom;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateTo;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $active = 1;

    public function getName() {
        return $this->name;
    }

    public function getDateTo() {
        return $this->dateTo;
    }

    public function getDateFrom() {
        return $this->dateFrom;
    }

    public function isActive() {
        return $this->active;
    }
    
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDateTo($dateTo) {
        $this->dateTo = $dateTo;
        return $this;
    }

    public function setDateFrom($dateFrom) {
        $this->dateFrom = $dateFrom;
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
        $this->setName($data['name'])
                ->setDateFrom(new \DateTime($data['dateFrom']))
                ->setDateTo(new \DateTime($data['dateTo']));
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'dateFrom',
                'required' => true,
            ));
            $inputFilter->add(array(
                'name' => 'dateTo',
                'required' => true,
                'validators' => array(
                    array('name' => 'Utilities\Service\Validator\DateValidator',
                        'options' => array(
                            'token' => 'dateFrom'
                        )
                    ),
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Holiday Entity
 * @ORM\Entity
 * @ORM\Table(name="holiday")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class Holiday {

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
     * @var int
     */
    public $active = 1;

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
     * Get dateTo
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime dateTo
     */
    public function getDateTo() {
        return $this->dateTo;
    }

    /**
     * Get dateFrom
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime dateFrom
     */
    public function getDateFrom() {
        return $this->dateFrom;
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
     * Set name
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $name
     * @return Holiday current entity
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Set dateTo
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $dateTo
     * @return Holiday current entity
     */
    public function setDateTo($dateTo) {
        $this->dateTo = $dateTo;
        return $this;
    }

    /**
     * Set dateFrom
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $dateFrom
     * @return Holiday current entity
     */
    public function setDateFrom($dateFrom) {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    /**
     * Set active
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $active
     * @return Holiday current entity
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
        $this->setName($data['name'])
                ->setDateFrom(new \DateTime($data['dateFrom']))
                ->setDateTo(new \DateTime($data['dateTo']));
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
     * @access public
     * @return InputFilter validation constraints
     */
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

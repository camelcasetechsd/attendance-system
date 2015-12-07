<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;

/**
 * Attendance Entity
 * @ORM\Entity
 * @ORM\Table(name="attendance")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @property InputFilter $inputFilter validation constraints 
 * @property int $id
 * @property int $branch
 * @property \DateTime $startTime
 * @property \DateTime $endTime
 * @property int $active ,default is 1
 * 
 * @package settings
 * @subpackage entity
 */
class Attendance {

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
     * @ORM\Column(type="integer")
     * @var int
     */
    public $branch;

    /**
     *
     * @ORM\Column(type="time")
     * @var \DateTime
     */
    public $startTime;

    /**
     *
     * @ORM\Column(type="time")
     * @var \DateTime
     */
    public $endTime;

    /**
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    public $active = 1;

    /**
     * Get branch
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int branch
     */
    public function getBranch() {
        return $this->branch;
    }

    /**
     * Get startTime
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime startTime
     */
    public function getStartTime() {
        return $this->startTime;
    }

    /**
     * Get endTime
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime endTime
     */
    public function getEndTime() {
        return $this->endTime;
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
     * Set branch
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $branch
     * @return Attendance current entity
     */
    public function setBranch($branch) {
        $this->branch = $branch;
        return $this;
    }

    /**
     * Set startTime
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $startTime
     * @return Attendance current entity
     */
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * Set endTime
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $endTime
     * @return Attendance current entity
     */
    public function setEndTime($endTime) {
        $this->endTime = $endTime;
        return $this;
    }

    /**
     * Set active
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $active
     * @return Attendance current entity
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
        $this->setBranch($data['branch'])
                ->setEndTime(new \DateTime($data['endTime']))
                ->setStartTime(new \DateTime($data['startTime']));
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
                'name' => 'startTime',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '/^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/',
                            'messages' => array(Regex::NOT_MATCH => 'please pick time from the menu .... ')))
                )
            ));
            $inputFilter->add(array(
                'name' => 'endTime',
                'required' => true,
                'validators' => array(
                    array('name' => 'regex',
                        'options' => array(
                            'pattern' => '/^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/',
                            'messages' => array(Regex::NOT_MATCH => 'please pick time from the menu .... '))
                    ),
                    array('name' => 'Utilities\Service\Validator\TimeValidator',
                        'options' => array(
                            'token' => 'startTime'
                        )
                    ),
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

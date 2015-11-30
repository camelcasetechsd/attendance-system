<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;

/**
 * Class Branche
 * @ORM\Entity
 * @ORM\Table(name="attendance")
 * @package Settings\Entity
 */
class Attendance {

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
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $branch;

    /**
     *
     * @ORM\Column(type="time")
     * @var time
     */
    public $startTime;

    /**
     *
     * @ORM\Column(type="time")
     * @var time
     */
    public $endTime;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $active = 1;

    public function getBranch() {
        return $this->branch;
    }

    public function getStartTime() {
        return $this->startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }

    public function isActive() {
        return $this->active;
    }
    
    public function setBranch($branch) {
        $this->branch = $branch;
        return $this;
    }

    public function setStartTime($startTime) {
        $this->startTime = $startTime;
        return $this;
    }

    public function setEndTime($endTime) {
        $this->endTime = $endTime;
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
        $this->setBranch($data['branch'])
                ->setEndTime($data['endTime'])
                ->setStartTime($data['startTime'])
                ->isActive($data['active']);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

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

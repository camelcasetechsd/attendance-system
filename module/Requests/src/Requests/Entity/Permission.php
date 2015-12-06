<?php

namespace Requests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;

/**
 * Permission Entity
 * @ORM\Entity
 * @ORM\Table(name="permission")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class Permission {

    /**
     * Request is submitted
     */
    const STATUS_SUBMITTED = 1;
    /**
     * Request is cancelled
     */
    const STATUS_CANCELLED = 2;
    /**
     * Request is approved
     */
    const STATUS_APPROVED = 3;
    /**
     * Request is denied
     */
    const STATUS_DENIED = 4;

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
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $user;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $date;

    /**
     *
     * @ORM\Column(type="time")
     * @var time
     */
    public $fromTime;

    /**
     *
     * @ORM\Column(type="time")
     * @var time
     */
    public $toTime;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateOfSubmission;

    /**
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    public $status;

    /**
     * Get date
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Get dateOfSubmission
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime dateOfSubmission
     */
    public function getDateOfSubmission() {
        return $this->dateOfSubmission;
    }

    /**
     * Get fromTime
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime fromTime
     */
    public function getFromTime() {
        return $this->fromTime;
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
     * Get toTime
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime toTime
     */
    public function getToTime() {
        return $this->toTime;
    }

    /**
     * Get user
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return Users\Entity\User user
     */
    public function getUser() {
        return $this->user;
    }
    
    /**
     * Set date
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $date
     * @return Permission current entity
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Set dateOfSubmission
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $dateOfSubmission
     * @return Permission current entity
     */
    public function setDateOfSubmission($dateOfSubmission) {
        $this->dateOfSubmission = $dateOfSubmission;
        return $this;
    }

    /**
     * Set fromTime
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $fromTime
     * @return Permission current entity
     */
    public function setFromTime($fromTime) {
        $this->fromTime = $fromTime;
        return $this;
    }

    /**
     * Set status
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $status
     * @return Permission current entity
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Set toTime
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $toTime
     * @return Permission current entity
     */
    public function setToTime($toTime) {
        $this->toTime = $toTime;
        return $this;
    }

    /**
     * Set user
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Users\Entity\User $user
     * @return Permission current entity
     */
    public function setUser($user) {
        $this->user = $user;
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
        $this->setDate(new \DateTime($data['date']))
                ->setDateOfSubmission(new \DateTime($data['dateOfSubmission']))
                ->setFromTime(new \DateTime($data['fromTime']))
                ->setStatus($data['status'])
                ->setToTime(new \DateTime($data['toTime']))
                ->setUser($data['user']);
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
                'name' => 'date',
                'required' => true,
                'validators' => array(
                    array('name' => 'date',
                        'options' => array(
                            'format' => 'm/d/Y',
                        )
                    ),
                )
            ));
            $inputFilter->add(array(
                'name' => 'fromTime',
                'required' => true,
                'validators' => array(
                    array('name' => 'regex',
                        'options' => array(
                            'pattern' => '/^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/',
                            'messages' => array(Regex::NOT_MATCH => 'please pick time from the menu .... ')
                        )
                    ),
                )
            ));
            $inputFilter->add(array(
                'name' => 'toTime',
                'required' => true,
                'validators' => array(
                    array('name' => 'Utilities\Service\Validator\TimeValidator',
                        'options' => array(
                            'token' => 'fromTime'
                        )),
                    array('name' => 'regex',
                        'options' => array(
                            'pattern' => '/^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/',
                            'messages' => array(Regex::NOT_MATCH => 'please pick time from the menu .... ')
                        )
                    ),
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

<?php

namespace Requests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;

/**
 * Class Permission
 * @ORM\Entity
 * @ORM\Table(name="permission")
 * @package Requests\Entity
 */
class Permission {

    const STATUS_SUBMITTED = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_APPROVED = 3;
    const STATUS_DENIED = 4;

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
     * @var integer
     */
    public $status;

    public function getDate() {
        return $this->date;
    }

    public function getDateOfSubmission() {
        return $this->dateOfSubmission;
    }

    public function getFromTime() {
        return $this->fromTime;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getToTime() {
        return $this->toTime;
    }

    public function getUser() {
        return $this->user;
    }
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function setDateOfSubmission($dateOfSubmission) {
        $this->dateOfSubmission = $dateOfSubmission;
        return $this;
    }

    public function setFromTime($fromTime) {
        $this->fromTime = $fromTime;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setToTime($toTime) {
        $this->toTime = $toTime;
        return $this;
    }

    public function setUser($user) {
        $this->user = $user;
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
        $this->setDate(new \DateTime($data['date']))
                ->setDateOfSubmission(new \DateTime($data['dateOfSubmission']))
                ->setFromTime(new \DateTime($data['fromTime']))
                ->setStatus($data['status'])
                ->setToTime(new \DateTime($data['toTime']))
                ->setUser($data['user']);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

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

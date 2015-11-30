<?php

namespace Requests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class Branche
 * @ORM\Entity
 * @ORM\Table(name="workfromhome")
 * @package Requests\Entity
 */
class WorkFromHome {

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
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $user;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $startDate;

    /**
     *
     * @ORM\Column(type="date", nullable=true)
     * @var date
     */
    public $endDate;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $reason;

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

    public function getDateOfSubmission() {
        return $this->dateOfSubmission;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getUser() {
        return $this->user;
    }

    public function getReason() {
        return $this->reason;
    }
    
    public function setDateOfSubmission($dateOfSubmission) {
        $this->dateOfSubmission = $dateOfSubmission;
        return $this;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setReason($reason) {
        $this->reason = $reason;
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
        $this->setDateOfSubmission($data['dateOfSubmission'])
                ->setEndDate($data['endDate'])
                ->setStatus($data['status'])
                ->setStartDate($data['startDate'])
                ->setUser($data['user'])
                ->setReason($data['reason']);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'startDate',
                'required' => true,
            ));

            $inputFilter->add(array(
                'name' => 'endDate',
                'validators' => array(
                    array('name' => 'Utilities\Service\Validator\DateValidator',
                        'options' => array(
                            'token' => 'startDate'
                        )
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'reason',
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
                            'max' => 4000
                        )
                    )
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

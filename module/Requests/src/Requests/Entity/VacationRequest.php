<?php

namespace Requests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class VacationRequest
 * @ORM\Entity
 * @ORM\Table(name="vacationRequest")
 * @package Requests\Entity
 */
class VacationRequest {

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
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $user;

    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Vacation")
     * @ORM\JoinColumn(name="vacation_type", referencedColumnName="id")
     * @var Settings\Entity\Vacation
     */
    public $vacationType;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $fromDate;

    /**
     *
     * @ORM\Column(type="date" , nullable=true)
     * @var date
     */
    public $toDate;

    /**
     * @ORM\Column(type="string" , nullable=true)
     * @var string
     */
    public $attachment;

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

    public function getAttachment() {
        return $this->attachment;
    }

    public function getDateOfSubmission() {
        return $this->dateOfSubmission;
    }

    public function getFromDate() {
        return $this->fromDate;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getToDate() {
        return $this->toDate;
    }

    public function getUser() {
        return $this->user;
    }

    public function getVacationType() {
        return $this->vacationType;
    }
    
    public function setAttachment($attachment) {
        $this->attachment = $attachment;
        return $this;
    }

    public function setDateOfSubmission($dateOfSubmission) {
        $this->dateOfSubmission = $dateOfSubmission;
        return $this;
    }

    public function setFromDate($fromDate) {
        $this->fromDate = $fromDate;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setToDate($toDate) {
        if (!is_null($toDate)) {
            $toDate = new \DateTime($toDate);
        }
        $this->toDate = $toDate;
        return $this;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setVacationType($vacationType) {
        $this->vacationType = $vacationType;
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
        $this->setDateOfSubmission(new \DateTime($data['dateOfSubmission']))
                ->setFromDate(new \DateTime($data['fromDate']))
                ->setStatus($data['status'])
                ->setToDate($data['toDate'])
                ->setUser($data['user'])
                ->setAttachment($data['attachment'])
                ->setVacationType($data['vacationType']);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'fromDate',
                'required' => true,
            ));

            $inputFilter->add(array(
                'name' => 'attachment',
                'required' => true,
                'validators' => array(
                    array('name' => 'Filesize',
                        'options' => array(
                            'max' => 2097152
                        )
                    ),
                    array('name' => 'Fileextension',
                        'options' => array(
                            'extension' => 'gif,jpg,png'
                        )
                    ),
                )
            ));
            
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

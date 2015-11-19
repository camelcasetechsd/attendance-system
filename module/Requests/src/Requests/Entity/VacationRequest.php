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
        $this->setAttachment($data['attachment'])
                ->setDateOfSubmission($data['dateOfSubmission'])
                ->setFromDate($data['fromDate'])
                ->setStatus($data['status'])
                ->setToDate($data['toDate'])
                ->setUser($data['user'])
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
                'validators' => array(
                    array('name' => 'Count',
                        'options' => array(
                            'max' => 1
                        )
                    ),
                    array('name' => 'Size',
                        'options' => array(
                            'max' => 2097152
                        )
                    ),
                    array('name' => 'Extension',
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

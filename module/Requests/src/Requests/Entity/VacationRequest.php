<?php

namespace Requests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * VacationRequest Entity
 * @ORM\Entity
 * @ORM\Table(name="vacationRequest")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @property InputFilter $inputFilter validation constraints 
 * @property int $id 
 * @property Users\Entity\User $user 
 * @property Settings\Entity\Vacation $vacationType 
 * @property \DateTime $fromDate 
 * @property \DateTime $toDate 
 * @property string $attachment
 * @property \DateTime $dateOfSubmission 
 * @property int $status
 * 
 * @package requests
 * @subpackage entity
 */
class VacationRequest {

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
     * @var \DateTime
     */
    public $fromDate;

    /**
     *
     * @ORM\Column(type="date" , nullable=true)
     * @var \DateTime
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
     * @var \DateTime
     */
    public $dateOfSubmission;

    /**
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    public $status;

    /**
     * Get attachment
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string attachment
     */
    public function getAttachment() {
        return $this->attachment;
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
     * Get fromDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime fromDate
     */
    public function getFromDate() {
        return $this->fromDate;
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
     * Get toDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime toDate
     */
    public function getToDate() {
        return $this->toDate;
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
     * Get vacationType
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int vacationType
     */
    public function getVacationType() {
        return $this->vacationType;
    }
    
    /**
     * Set attachment
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $attachment
     * @return VacationRequest current entity
     */
    public function setAttachment($attachment) {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * Set dateOfSubmission
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $dateOfSubmission
     * @return VacationRequest current entity
     */
    public function setDateOfSubmission($dateOfSubmission) {
        $this->dateOfSubmission = $dateOfSubmission;
        return $this;
    }

    /**
     * Set fromDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $fromDate
     * @return VacationRequest current entity
     */
    public function setFromDate($fromDate) {
        $this->fromDate = $fromDate;
        return $this;
    }

    /**
     * Set status
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $status
     * @return VacationRequest current entity
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Set toDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $toDate
     * @return VacationRequest current entity
     */
    public function setToDate($toDate) {
        if (!is_null($toDate) && !is_object($toDate)) {
            $toDate = new \DateTime($toDate);
        }
        $this->toDate = $toDate;
        return $this;
    }

    /**
     * Set user
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Users\Entity\User $user
     * @return VacationRequest current entity
     */
    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    /**
     * Set vacationType
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $vacationType
     * @return VacationRequest current entity
     */
    public function setVacationType($vacationType) {
        $this->vacationType = $vacationType;
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
        $this->setDateOfSubmission(new \DateTime($data['dateOfSubmission']))
                ->setFromDate(new \DateTime($data['fromDate']))
                ->setStatus($data['status'])
                ->setToDate($data['toDate'])
                ->setUser($data['user'])
                ->setAttachment($data['attachment'])
                ->setVacationType($data['vacationType']);
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

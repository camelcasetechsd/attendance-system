<?php

namespace Requests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * WorkFromHome Entity
 * @ORM\Entity
 * @ORM\Table(name="workfromhome")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class WorkFromHome {

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
     * @var int
     */
    public $status;

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
     * Get endDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime endDate
     */
    public function getEndDate() {
        return $this->endDate;
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
     * Get startDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime startDate
     */
    public function getStartDate() {
        return $this->startDate;
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
     * Get reason
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string reason
     */
    public function getReason() {
        return $this->reason;
    }
    
    /**
     * Set dateOfSubmission
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $dateOfSubmission
     * @return WorkFromHome current entity
     */
    public function setDateOfSubmission($dateOfSubmission) {
        $this->dateOfSubmission = $dateOfSubmission;
        return $this;
    }

    /**
     * Set endDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $endDate
     * @return WorkFromHome current entity
     */
    public function setEndDate($endDate) {
        if (!is_null($endDate)) {
            $endDate = new \DateTime($endDate);
        }
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * Set status
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $status
     * @return WorkFromHome current entity
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Set startDate
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $startDate
     * @return WorkFromHome current entity
     */
    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * Set user
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Users\Entity\User $user
     * @return WorkFromHome current entity
     */
    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    /**
     * Set reason
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $reason
     * @return WorkFromHome current entity
     */
    public function setReason($reason) {
        $this->reason = $reason;
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
                ->setEndDate($data['endDate'])
                ->setStatus($data['status'])
                ->setStartDate(new \DateTime($data['startDate']))
                ->setUser($data['user'])
                ->setReason($data['reason']);
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

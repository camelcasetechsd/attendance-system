<?php

namespace Requests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Comment Entity
 * @ORM\Entity
 * @ORM\Table(name="comment")
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class Comment {

    /**
     * Request type is permission
     */
    const REQUEST_TYPE_PERMISSION = 1;
    /**
     * Request type is vacation
     */
    const REQUEST_TYPE_VACATIONREQUEST = 2;
    /**
     * Request type is work from home
     */
    const REQUEST_TYPE_WORKFROMHOME = 3;

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
    public $body;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $user;

    /**
     * @ORM\Column(type="integer");
     * @var int
     */
    public $request_id;

    /**
     *
     * @ORM\Column(type="integer");
     * @var int
     */
    public $request_type;

    /**
     *
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    public $created;
    
    /**
     * Get body
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string body
     */
    public function getBody() {
        return $this->body;
    }
    
    /**
     * Get created
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return \DateTime created
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Get request_id
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return int request_id
     */
    public function getRequestId() {
        return $this->request_id;
    }

    /**
     * Get request_type
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string request_type
     */
    public function getRequestType() {
        return $this->request_type;
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
     * Set body
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $body
     * @return Comment current entity
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }
    
    /**
     * Set created
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \DateTime $created
     * @return Comment current entity
     */
    public function setCreated($created) {
        $this->created = $created;
        return $this;
    }
    
    /**
     * Set request_id
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param int $request_id
     * @return Comment current entity
     */
    public function setRequestId($request_id) {
        $this->request_id = $request_id;
        return $this;
    }
    
    /**
     * Set request_type
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $request_type
     * @return Comment current entity
     */
    public function setRequestType($request_type) {
        $this->request_type = $request_type;
        return $this;
    }

    /**
     * Set user
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Users\Entity\User $user
     * @return Comment current entity
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
        $this->setBody($data['body'])
                ->setCreated(new \DateTime($data['created']))
                ->setRequestId($data['request_id'])
                ->setRequestType($data['request_type'])
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
                'name' => 'body',
                'required' => true,
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

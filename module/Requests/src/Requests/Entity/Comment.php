<?php

namespace Requests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class Comment
 * @ORM\Entity
 * @ORM\Table(name="comment")
 * @package Requests\Entity
 */
class Comment {

    const REQUEST_TYPE_PERMISSION = 1;
    const REQUEST_TYPE_VACATIONREQUEST = 2;
    const REQUEST_TYPE_WORKFROMHOME = 3;

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
     * @var integer
     */
    public $request_id;

    /**
     *
     * @ORM\Column(type="integer");
     * @var integer
     */
    public $request_type;

    /**
     *
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    public $created;
    
    public function getBody() {
        return $this->body;
    }
    
    public function getCreated() {
        return $this->created;
    }

    public function getRequestId() {
        return $this->request_id;
    }

    public function getRequestType() {
        return $this->request_type;
    }

    public function getUser() {
        return $this->user;
    }
    
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }
    
    public function setCreated($created) {
        $this->created = $created;
        return $this;
    }
    
    public function setRequestId($request_id) {
        $this->request_id = $request_id;
        return $this;
    }
    
    public function setRequestType($request_type) {
        $this->request_type = $request_type;
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
        $this->setBody($data['body'])
                ->setCreated(new \DateTime($data['created']))
                ->setRequestId($data['request_id'])
                ->setRequestType($data['request_type'])
                ->setUser($data['user']);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

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

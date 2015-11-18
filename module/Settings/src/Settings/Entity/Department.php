<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Department
 * @ORM\Entity
 * @ORM\Table(name="department")
 * @package Settings\Entity
 */
class Department {

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public $id;

    /**
     *
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    public $name;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $description;

    /**
     *
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    public $address;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="manager_id", referencedColumnName="id")
     * @var Users\Entity\User
     */
    public $manager;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $status;

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setManager($manager) {
        $this->manager = $manager;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
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
        $this->setAddress($data['address'])
                ->setDescription($data['description'])
                ->setManager($data['manager'])
                ->setName($data['name'])
                ->setStatus($data['status']);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'name',
                'required' => true,
            ));
            $inputFilter->add(array(
                'name' => 'description',
                'required' => true,
            ));
            $inputFilter->add(array(
                'name' => 'address',
                'required' => true,
            ));
            $inputFilter->add(array(
                'name' => 'manager',
                'required' => true,
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

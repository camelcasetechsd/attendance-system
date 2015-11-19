<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * Class Holiday
 * @ORM\Entity
 * @ORM\Table(name="holiday")
 * @package Settings\Entity
 */
class Holiday {

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
    public $name;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateFrom;

    /**
     *
     * @ORM\Column(type="date")
     * @var date
     */
    public $dateTo;

    /**
     *
     * @ORM\Column(type="integer")
     * @var integer
     */
    public $active = 1;

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDateTo($dateTo) {
        $this->dateTo = $dateTo;
        return $this;
    }

    public function setDateFrom($dateFrom) {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    public function isActive($active) {
        $this->active = $active;
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
        $this->setName($data['name'])
                ->setDateFrom($data['dateFrom'])
                ->setDateTo($data['dateTo'])
                ->isActive($data['active']);
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
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'dateFrom',
                'required' => true,
            ));
            $inputFilter->add(array(
                'name' => 'dateTo',
                'required' => true,
                'validators' => array(
                    array('name' => 'Utilities\Service\Validator\DateValidator',
                        'options' => array(
                            'token' => 'dateFrom'
                        )
                    ),
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

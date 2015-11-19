<?php

namespace DefaultModule\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class FilterByYearForm extends Form {

    private $_inputFilter;

    public function __construct($name = null, $options = null) {
        parent::__construct($name, $options);

        $this->setAttribute('class', 'form form-horizontal');

        $this->add(array(
            'name' => 'year',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Year: ',
            ),
        ));

        $this->add(array(
            'name' => 'dateFrom',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
                'required' => 'required',
                'class' => 'form-control date',
            ),
            'options' => array(
                'label' => 'From Date: ',
            ),
        ));

        $this->add(array(
            'name' => 'dateTo',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
                'required' => 'required',
                'class' => 'form-control date',
            ),
            'options' => array(
                'label' => 'To Date: ',
            ),
        ));

        $this->add(array(
            'name' => 'Filter',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Filter!',
            ),
            'options' => array(
                'label' => 'Filter!',
            ),
        ));

        $this->setInputFilter($this->getInputFilter());
    }

    private function getInputFilter() {
        if (!$this->_inputFilter) {
            $inputFilter = new InputFilter();

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

            $this->_inputFilter = $inputFilter;
        }

        return $this->_inputFilter;
    }

}

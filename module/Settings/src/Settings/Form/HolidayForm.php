<?php

namespace Settings\Form;

use Zend\Form\Form;

class HolidayForm extends Form {

    public function __construct($name = null, $options = null) {
        parent::__construct($name, $options);

        $this->setAttribute('class', 'form form-horizontal');

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'placeholder' => 'Enter Holiday Name',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Holiday Name: ',
            ),
        ));
        $this->add(array(
            'name' => 'dateFrom',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
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
                'required' => 'required',
                'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
                'class' => 'form-control date',
            ),
            'options' => array(
                'label' => 'To Date: ',
            ),
        ));

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'Create',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
            ),
            'options' => array(
                'label' => 'Create',
            ),
        ));
    }

}

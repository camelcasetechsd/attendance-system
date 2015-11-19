<?php

namespace Requests\Form;

use Zend\Form\Form;

/**
 * Vacation Request Form Class using Zend_Form
 * @author Mohamed Ramadan
 * 
 */
class VacationRequestForm extends Form {

    public function __construct($name = null, $options = null) {
        parent::__construct($name, $options);

        $this->setAttribute('class', 'form form-horizontal');
        $this->setAttribute('id', 'VacationRequestForm');

        $this->add(array(
            'name' => 'fromDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'placeholder' => 'Example: 10/22/2010',
                'class' => 'form-control date',
            ),
            'options' => array(
                'label' => 'From Date: ',
            ),
        ));

        $this->add(array(
            'name' => 'toDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Example: 10/22/2010',
                'class' => 'form-control date',
                'id' => 'toDate',
            ),
            'options' => array(
                'label' => 'To Date: ',
            ),
        ));

        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'type',
            ),
            'options' => array(
                'label' => 'VacationType: ',
                'value_options' => array(
                    '2' => 'Casual',
                    '3' => 'Annual',
                    '1' => 'Sick'
                ),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Submit',
            )
        ));

        $this->add(array(
            'name' => 'attachment',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'class' => 'attach_hide',
                'value' => null,
            ),
            'options' => array(
                'label' => 'Attachment:',
            ),
        ));
    }

}

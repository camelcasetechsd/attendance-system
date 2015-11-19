<?php

namespace Requests\Form;

use Zend\Form\Form;

/**
 * WorkFromHome Request Form Class using Zend_Form
 * @author Ahmed
 * 
 */
class WorkfromhomeForm extends Form {

    public function __construct($name = null, $options = null) {
        parent::__construct($name, $options);

        $this->setAttribute('class', 'form form-horizontal');

        $this->add(array(
            'name' => 'startDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'date form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Start Date',
            ),
        ));

        $this->add(array(
            'name' => 'endDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'date form-control',
            ),
            'options' => array(
                'label' => 'End Date',
            ),
        ));

        $this->add(array(
            'name' => 'reason',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control',
                'rows' => '5',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Reason',
            ),
        ));

        $this->add(array(
            'name' => 'vacationCreate',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Create',
            )
        ));
    }

}

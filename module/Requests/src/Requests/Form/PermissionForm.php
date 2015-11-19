<?php

namespace Requests\Form;

use Zend\Form\Form;

/**
 * Permission Request Form Class using Zend_Form
 * @author Moataz Mohamed
 * 
 */
class PermissionForm extends Form {

    public function __construct($name = null, $options = null) {
        parent::__construct($name, $options);

        $this->setAttribute('class', 'form form-horizontal');

        $this->add(array(
            'name' => 'date',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control date',
            ),
            'options' => array(
                'label' => 'Date: ',
            ),
        ));

        $this->add(array(
            'name' => 'fromTime',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control time',
            ),
            'options' => array(
                'label' => 'From Time: ',
            ),
        ));

        $this->add(array(
            'name' => 'toTime',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control time',
            ),
            'options' => array(
                'label' => 'To Time: ',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Submit!',
            )
        ));
    }

}

<?php

namespace Requests\Form;

use Utilities\Form\Form;

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
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control date',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Date: ',
                'format' => 'm/d/Y',
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

<?php

namespace Settings\Form;

use Zend\Form\Form;

class VacationForm extends Form {

    public function __construct($name = null, $options = null) {
        parent::__construct($name, $options);

        $this->setAttribute('class', 'form form-horizontal');

        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Type:',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
                'rows' => '5',
            ),
            'options' => array(
                'label' => 'Description:',
            ),
        ));
        $this->addElement('text', 'balance', array(
            'label' => 'Balance: ',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array('Digits'),
            'class' => 'form-control'
        ));


        $this->add(array(
            'name' => 'balance',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Balance: ',
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

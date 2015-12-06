<?php

namespace Settings\Form;

use Utilities\Form\Form;

/**
 * Holiday Form
 * 
 * Handles Holiday form setup
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class HolidayForm extends Form {

    /**
     * setup form
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $name ,default is null
     * @param array $options ,default is null
     */
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
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'required' => 'required',
                'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
                'class' => 'form-control date',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'From Date: ',
                'format' => 'm/d/Y',
            ),
        ));
        $this->add(array(
            'name' => 'dateTo',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'required' => 'required',
                'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
                'class' => 'form-control date',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'To Date: ',
                'format' => 'm/d/Y',
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
                'value' => 'Create',
            )
        ));
    }

}

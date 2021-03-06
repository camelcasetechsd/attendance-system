<?php

namespace Requests\Form;

use Utilities\Form\Form;

/**
 * Workfromhome Form
 * 
 * Handles Workfromhome form setup
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author Ahmed
 * 
 * @package requests
 * @subpackage form
 */
class WorkfromhomeForm extends Form {

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
            'name' => 'startDate',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'class' => 'date form-control',
                'required' => 'required',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Start Date',
                'format' => 'm/d/Y',
            ),
        ));

        $this->add(array(
            'name' => 'endDate',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'class' => 'date form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'End Date',
                'format' => 'm/d/Y',
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

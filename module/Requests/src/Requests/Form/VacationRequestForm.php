<?php

namespace Requests\Form;

use Utilities\Form\Form;

/**
 * VacationRequest Form
 * 
 * Handles VacationRequest form setup
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author Mohamed Ramdan
 * 
 * @package requests
 * @subpackage form
 */
class VacationRequestForm extends Form {

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
        $this->setAttribute('id', 'VacationRequestForm');

        $this->add(array(
            'name' => 'fromDate',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'required' => 'required',
                'placeholder' => 'Example: 10/22/2010',
                'class' => 'form-control date',
                'id' => 'fromDate',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'From Date: ',
                'format' => 'm/d/Y',
            ),
        ));

        $this->add(array(
            'name' => 'toDate',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'placeholder' => 'Example: 10/22/2010',
                'class' => 'form-control date',
                'id' => 'toDate',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'To Date: ',
                'format' => 'm/d/Y',
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
            'name' => 'attachment',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'class' => 'attach_hide',
                'value' => null,
                'id' => 'attachment',
            ),
            'options' => array(
                'label' => 'Attachment:',
                'label_attributes' => array(
                    'id' => 'attachment-label'
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Create',
            )
        ));
    }

}

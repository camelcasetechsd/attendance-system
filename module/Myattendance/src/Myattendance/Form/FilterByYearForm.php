<?php

namespace Myattendance\Form;

use Utilities\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * FilterByYear Form
 * 
 * Handles attendance entries filtration form setup and validation
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @property InputFilter $_inputFilter validation constraints 
 * @package myattendance
 * @subpackage form
 */
class FilterByYearForm extends Form {

    /**
     *
     * @var InputFilter validation constraints 
     */
    private $_inputFilter;

    /**
     * setup form and add validation constraints
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
            'name' => 'dateFrom',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
                'required' => 'required',
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
                'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
                'required' => 'required',
                'class' => 'form-control date',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'To Date: ',
                'format' => 'm/d/Y',
            ),
        ));

        $this->add(array(
            'name' => 'Filter',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Filter!',
            )
        ));

        $this->setInputFilter($this->getInputFilter());
    }

    /**
     * set validation constraints
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses InputFilter
     * 
     * @access public
     * @return InputFilter validation constraints
     */
    public function getInputFilter() {
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

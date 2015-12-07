<?php

namespace Settings\Form;

use Utilities\Form\Form;

/**
 * Attendance Form
 * 
 * Handles Attendance form setup
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author Ahmed
 * 
 * @property Utilities\Service\Query\Query $query
 * 
 * @package settings
 * @subpackage form
 */
class AttendanceForm extends Form {

    /**
     *
     * @var Utilities\Service\Query\Query 
     */
    protected $query;

    /**
     * setup form
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $name ,default is null
     * @param array $options ,default is null
     */
    public function __construct($name = null, $options = null) {
        $this->query = $options['query'];
        unset($options['query']);
        parent::__construct($name, $options);

        $this->add(array(
            'name' => 'startTime',
            'type' => 'Zend\Form\Element\Time',
            'attributes' => array(
                'placeholder' => 'Start time here...',
                'required' => 'required',
                'class' => 'time form-control',
                'id' => 'starttimeformat',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Start Time',
            ),
        ));

        $this->add(array(
            'name' => 'endTime',
            'type' => 'Zend\Form\Element\Time',
            'attributes' => array(
                'placeholder' => 'End time here...',
                'required' => 'required',
                'class' => 'time form-control',
                'id' => 'endtimeformat',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'End Time',
            ),
        ));

        $this->add(array(
            'name' => 'branch',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Branch: ',
                'object_manager' => $this->query->entityManager,
                'target_class' => 'Settings\Entity\Branch',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                ),
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

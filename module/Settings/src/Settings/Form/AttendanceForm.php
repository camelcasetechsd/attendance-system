<?php

namespace Settings\Form;

use Utilities\Form\Form;

/**
 * Description of AttendanceForm
 *
 * @author ahmed
 */
class AttendanceForm extends Form {

    protected $query;

    public function __construct($name = null, $options = null) {
        $this->query = $options['query'];
        unset($options['query']);
        parent::__construct($name, $options);

        $this->add(array(
            'name' => 'startTime',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Your name here...',
                'required' => 'required',
                'class' => 'time form-control',
                'id' => 'starttimeformat',
            ),
            'options' => array(
                'label' => 'Start Time',
            ),
        ));

        $this->add(array(
            'name' => 'endTime',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Your name here...',
                'required' => 'required',
                'class' => 'time form-control',
                'id' => 'endtimeformat',
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

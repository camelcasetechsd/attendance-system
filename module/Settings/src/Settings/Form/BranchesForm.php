<?php

namespace Settings\Form;

use Utilities\Form\Form;

/**
 * Description of Branches
 *
 * @author AbdEl-Moneim
 */
class BranchesForm extends Form {

    protected $query;

    public function __construct($name = null, $options = null) {
        $this->query = $options['query'];
        unset($options['query']);
        parent::__construct($name, $options);

        $this->setAttribute('class', 'form form-horizontal');

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'class' => 'time form-control',
            ),
            'options' => array(
                'label' => 'Branch title',
            ),
        ));

        
        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'required' => 'required',
                'class' => 'time form-control',
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));
       
        $this->add(array(
            'name' => 'address',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'class' => 'time form-control',
            ),
            'options' => array(
                'label' => 'Address',
            ),
        ));
        $this->add(array(
            'name' => 'manager',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'required' => 'required',
                'class' => 'time form-control',
            ),
            'options' => array(
                'label' => 'Manager',
                'object_manager' => $this->query->entityManager,
                'target_class' => 'Users\Entity\User',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'role' => '3'
                        )
                    )
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

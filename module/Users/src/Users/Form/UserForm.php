<?php

namespace Users\Form;

use Utilities\Form\Form;

/**
 * User Form
 * 
 * Handles User form setup
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author Mohamed Ramadan
 * 
 * @property Utilities\Service\Query\Query $query
 * 
 * @package users
 * @subpackage form
 */
class UserForm extends Form {

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

        $this->setAttribute('class', 'form form-horizontal');

        $this->add(array(
            'name' => 'username',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Enter User Name',
                'required' => 'required',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'UserName: ',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder' => 'Enter User Password',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Password: ',
            ),
        ));

        $this->add(array(
            'name' => 'confirmPassword',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder' => 'Confirm User Password',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'ConfirmPassword: ',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Enter User\'s appeared name',
                'required' => 'required',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'YourName: ',
            ),
        ));

        $this->add(array(
            'name' => 'mobile',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Enter User Mobile #',
                'required' => 'required',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Mobile: ',
            ),
        ));

        $this->add(array(
            'name' => 'dateOfBirth',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'placeholder' => 'Example: 10/10/2010',
                'required' => 'required',
                'class' => 'form-control date',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'DateOfBirth: ',
                'format' => 'm/d/Y',
            ),
        ));

        $this->add(array(
            'name' => 'startDate',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'placeholder' => 'Example: 10/10/2010',
                'required' => 'required',
                'class' => 'form-control date',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'StartDate: ',
                'format' => 'm/d/Y',
            ),
        ));

        $this->add(array(
            'name' => 'vacationBalance',
            'type' => 'Zend\Form\Element\Number',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
                'min' => '0',
                'max' => '21',
            ),
            'options' => array(
                'label' => 'VacationBalance: ',
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control',
                'rows' => '5',
                'placeholder' => 'Enter User description'
            ),
            'options' => array(
                'label' => 'Description: ',
            ),
        ));

        $this->add(array(
            'name' => 'maritalStatus',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'MaritalStatus: ',
                'value_options' => array(
                    'single' => 'Single',
                    'married' => 'Married'
                ),
            ),
        ));

        $this->add(array(
            'name' => 'department',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Department: ',
                'object_manager' => $this->query->entityManager,
                'target_class' => 'Settings\Entity\Department',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                ),
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
            'name' => 'position',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Position: ',
                'object_manager' => $this->query->entityManager,
                'target_class' => 'Settings\Entity\Position',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'manager',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Manager: ',
                'object_manager' => $this->query->entityManager,
                'target_class' => 'Users\Entity\User',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'photo',
            'type' => 'Zend\Form\Element\File',
            'options' => array(
                'label' => 'Picture',
            ),
        ));
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Create',
            )
        ));
        $this->add(array(
            'name' => 'reset',
            'type' => 'Zend\Form\Element',
            'attributes' => array(
                'class' => 'btn btn-danger resetButton',
                'value' => 'Reset',
                'type' => 'button',
            )
        ));
    }

}

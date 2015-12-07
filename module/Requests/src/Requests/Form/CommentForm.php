<?php

namespace Requests\Form;

use Utilities\Form\Form;

/**
 * Comment Form
 * 
 * Handles Comment form setup
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author Mohamed Ramdan
 * 
 * @package requests
 * @subpackage form
 */
class CommentForm extends Form {

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
            'name' => 'body',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'required' => 'required',
                'rows' => '1',
                'class' => 'form-control',
                'id' => 'comment',
            ),
            'options' => array(
                'label' => 'Add Comment: ',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Submit',
                'id' => 'submit',
            )
        ));
    }

}

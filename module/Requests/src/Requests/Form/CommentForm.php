<?php

namespace Requests\Form;

use Utilities\Form\Form;

/**
 * add comment Form Class using Zend_Form
 * @author Mohamed Ramdan
 *  
 */
class CommentForm extends Form {

    public function __construct($name = null, $options = null) {
        parent::__construct($name, $options);

        $this->setAttribute('class', 'form form-horizontal');

        $this->add(array(
            'name' => 'comment',
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

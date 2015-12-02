<?php

namespace Utilities\Form;

use Zend\Form\Form as ZendForm;
use Utilities\Service\Inflector;
use Zend\Form\FormInterface;

class Form extends ZendForm {

    public $isEditForm = false;
    
    public function __construct($name = null, $options = null) {
        if(is_null($name)){
            $reflection = new \ReflectionClass($this);
            $inflector = new Inflector();
            $name = $inflector->underscore($reflection->getShortName());
        }
        parent::__construct($name, $options);
    }
    
    /**
     * Bind an object to the form
     *
     * Ensures the object is populated with validated values.
     *
     * @param  object $object
     * @param  int $flags
     * @return mixed|void
     * @throws Exception\InvalidArgumentException
     */
    public function bind($object, $flags = FormInterface::VALUES_NORMALIZED)
    {
        $this->isEditForm = true;
        parent::bind($object, $flags);
    }

}

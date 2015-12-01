<?php

namespace Utilities\Form;

use Zend\Form\Form as ZendForm;
use Utilities\Service\Inflector;

class Form extends ZendForm {

    public function __construct($name = null, $options = null) {
        if(is_null($name)){
            $reflection = new \ReflectionClass($this);
            $inflector = new Inflector();
            $name = $inflector->underscore($reflection->getShortName());
        }
        parent::__construct($name, $options);
    }

}

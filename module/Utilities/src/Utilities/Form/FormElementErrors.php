<?php

namespace Utilities\Form;

use Zend\Form\View\Helper\FormElementErrors as OriginalFormElementErrors;

class FormElementErrors extends OriginalFormElementErrors  
{
    protected $messageCloseString     = '</li></ul>';
    protected $messageOpenFormat      = '<ul%s><li class="errors">';
    protected $messageSeparatorString = '</li><li class="errors">';
}

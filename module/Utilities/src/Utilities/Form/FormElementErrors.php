<?php

namespace Utilities\Form;

use Zend\Form\View\Helper\FormElementErrors as OriginalFormElementErrors;

/**
 * FormElementErrors
 * 
 * Handles form errors display
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class FormElementErrors extends OriginalFormElementErrors  
{
    /**
     *
     * @var string 
     */
    protected $messageCloseString     = '</li></ul>';
    
    /**
     *
     * @var string 
     */
    protected $messageOpenFormat      = '<ul%s><li class="errors">';
    
    /**
     *
     * @var string 
     */
    protected $messageSeparatorString = '</li><li class="errors">';
}

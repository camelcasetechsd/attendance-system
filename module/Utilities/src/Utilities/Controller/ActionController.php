<?php

namespace Utilities\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Utilities\Form\FormViewHelper;
use Zend\Form\FormInterface;

/**
 * Action Controller
 * 
 * Being extended by all controllers, 
 * It provides helpers for all controllers
 * And control how all controllers behave
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @package utilities
 * @subpackage controller
 */
class ActionController extends AbstractActionController
{
    /**
     * Get form HTML content
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses FormViewHelper
     * 
     * @param FormInterface $form
     * @return string form HTML content
     */
    public function getFormView(FormInterface $form)
    {
        $formHelper = new FormViewHelper();
        $view = $this->getServiceLocator()->get('ViewRenderer');
        $formHelper->setView($view);
        return $formHelper->render($form);
    }

}


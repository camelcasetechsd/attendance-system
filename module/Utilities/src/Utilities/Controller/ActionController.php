<?php

namespace Utilities\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Utilities\Form\FormViewHelper;
use Zend\Form\FormInterface;

class ActionController extends AbstractActionController
{
    public function getFormView(FormInterface $form)
    {
        $formHelper = new FormViewHelper();
        $view = $this->getServiceLocator()->get('ViewRenderer');
        $formHelper->setView($view);
        return $formHelper->render($form);
    }

}


<?php

namespace DefaultModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ErrorController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function deactivatedAction()
    {
        return new ViewModel();
    }

    public function errorAction()
    {
        return new ViewModel();
    }


}


<?php

namespace DefaultModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SignController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function inAction()
    {
        return new ViewModel();
    }

    public function outAction()
    {
        return new ViewModel();
    }


}


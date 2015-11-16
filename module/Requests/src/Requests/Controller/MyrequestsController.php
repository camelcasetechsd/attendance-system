<?php

namespace Requests\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MyrequestsController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function approveAction()
    {
        return new ViewModel();
    }

    public function cancelAction()
    {
        return new ViewModel();
    }

    public function declineAction()
    {
        return new ViewModel();
    }


}


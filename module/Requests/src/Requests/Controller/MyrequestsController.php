<?php

namespace Requests\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;

class MyrequestsController extends ActionController
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


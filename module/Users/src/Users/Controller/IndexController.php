<?php

namespace Users\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;

class IndexController extends ActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function newAction()
    {
        return new ViewModel();
    }

    public function editAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }


}


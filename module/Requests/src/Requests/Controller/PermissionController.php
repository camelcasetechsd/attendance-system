<?php

namespace Requests\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PermissionController extends AbstractActionController
{

    public function indexAction()
    {
        echo "perm";die;
        return new ViewModel();
    }

    public function newAction()
    {
        return new ViewModel();
    }

    public function showAction()
    {
        return new ViewModel();
    }

    public function deletecommentAction()
    {
        return new ViewModel();
    }


}


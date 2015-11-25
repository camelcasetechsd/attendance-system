<?php

namespace Requests\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;

class PermissionController extends ActionController
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


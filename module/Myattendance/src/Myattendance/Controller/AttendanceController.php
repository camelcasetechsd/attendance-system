<?php

namespace Myattendance\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;

class AttendanceController extends ActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}


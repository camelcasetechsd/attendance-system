<?php

namespace Myattendance\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AttendanceController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

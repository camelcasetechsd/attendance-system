<?php

namespace Notifications\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;

class IndexController extends ActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function seenAction()
    {
        return new ViewModel();
    }


}


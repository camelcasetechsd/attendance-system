<?php

namespace Calendar\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;

/**
 * Calender Index controller
 * 
 * controller responsible for displaying holiday calender
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class IndexController extends ActionController
{

    /**
     * Display holiday calender 
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }


}


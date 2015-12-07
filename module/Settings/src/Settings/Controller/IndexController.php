<?php

namespace Settings\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;

/**
 * Default Controller
 * 
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @package settings
 * @subpackage controller
 */
class IndexController extends ActionController
{

    /**
     * Default action
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


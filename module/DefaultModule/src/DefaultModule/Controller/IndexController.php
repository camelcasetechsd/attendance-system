<?php

namespace DefaultModule\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;

/**
 * Index Controller
 * 
 * Handles Application homepage
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package defaultModule
 * @subpackage controller
 */
class IndexController extends ActionController
{

    /**
     * Application homepage
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


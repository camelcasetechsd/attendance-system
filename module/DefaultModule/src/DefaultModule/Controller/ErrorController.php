<?php

namespace DefaultModule\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Application;
use Zend\Log\Logger;

/**
 * Error Controller
 * 
 * Handles Errors display
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @package defaultModule
 * @subpackage controller
 */
class ErrorController extends ActionController
{

    /**
     * Error due to Access denied for current user
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * Error due to current user being deactivated
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return ViewModel
     */
    public function deactivatedAction()
    {
        return new ViewModel();
    }

    /**
     * Default Error display
     * @todo get error display overriden by this action, As now it is handled by original ZF2 exception strategy 
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Logger
     * 
     * @access public
     * @return ViewModel
     */
    public function errorAction()
    {
        $errors = $this->params('error_handler');
        $variables = array();
        // default message when actual error is not accessible
        if (!$errors || !$errors instanceof \ArrayObject) {
            $variables['message'] = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Application::ERROR_CONTROLLER_NOT_FOUND:
            case Application::ERROR_CONTROLLER_INVALID:
            case Application::ERROR_ROUTER_NO_MATCH:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Logger::NOTICE;
                $variables['message'] = 'Page not found';
                break;
            default:
                // 500 error -- application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Logger::CRIT;
                $variables['message'] = 'Application error';
                break;
        }
        
        // Log exception to keep it for future investigation
        $log = new Logger();
        $log->log($priority, $variables['message'], $errors->exception);
        $log->log($priority, 'Request Parameters', $errors->request->getParams());
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $variables['exception'] = $errors->exception;
            $variables['exceptionmessage'] = $variables['exception']->getMessage();
            $variables['stacktrace'] = $variables['exception']->getTraceAsString();
        }
        
        // display request parameters
        $variables['request']   = $errors->request;
        $variables['requestparams'] = var_export($errors->request->getParams(), true);
        
        return new ViewModel($variables);
    }
}


<?php

namespace DefaultModule\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Application;
use Zend\Log\Logger;

class ErrorController extends ActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function deactivatedAction()
    {
        return new ViewModel();
    }

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        $variables = array();
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
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Logger::CRIT;
                $variables['message'] = 'Application error';
                break;
        }
        
        // Log exception
        $log = new Logger();
        $log->log($priority, $variables['message'], $errors->exception);
        $log->log($priority, 'Request Parameters', $errors->request->getParams());
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $variables['exception'] = $errors->exception;
            $variables['exceptionmessage'] = $variables['exception']->getMessage();
            $variables['stacktrace'] = $variables['exception']->getTraceAsString();
        }
        
        $variables['request']   = $errors->request;
        $variables['requestparams'] = var_export($errors->request->getParams(), true);
        
        return new ViewModel($variables);
    }
}


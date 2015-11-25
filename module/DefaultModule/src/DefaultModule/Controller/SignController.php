<?php

namespace DefaultModule\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use DefaultModule\Form\SigninForm;
use Zend\Authentication\AuthenticationService;

class SignController extends ActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function inAction()
    {
        $variables = array();
        $form = new SigninForm();
        $request = $this->getRequest();
        //checking if we got a new post request
        if ($request->isPost()) {
            $form->setData($request->getPost());
            // checking if the form is valid
            if ($form->isValid()) {
                $auth = $this->getServiceLocator()->get('Users\Auth\Authentication')->setRequest($request);
                $result = $auth->authenticateMe();
                if ($result->isValid()) {
                    $auth->newSession();
                    $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'home'));
                    $this->redirect()->toUrl($url);
                } else {
                    $errorMessages = array();
                    $errorMessages[]['message'] = "Username and password are invalid !";
                    $variables['message'] = $errorMessages;
                }
            }
        }
        $variables['form'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function outAction()
    {
        $auth = new AuthenticationService();
        $auth->clearIdentity();
        //Redirect to login page again 
        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'in'), array('name' => 'defaultSign'));
        $this->redirect()->toUrl($url);
    }


}


<?php

namespace Myattendance\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

class VacationController extends ActionController
{

    public function indexAction()
    {
        $variables = array();
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $userId = $storage['id'];
        
        $vacationModel = $this->getServiceLocator()->get('Myattendance\Model\Vacation');
        
        $sickVacation = $vacationModel->getVacation($userId, /*$vacationType =*/ 1);
        $variables['sick'] = $sickVacation;

        $casualVacation = $vacationModel->getVacation($userId, /*$vacationType =*/ 2);
        $variables['casual'] = $casualVacation;

        $annualVacation = $vacationModel->getVacation($userId, /*$vacationType =*/ 3);
        $variables['annual'] = $annualVacation;
    
        $sicks = $vacationModel->getVacationNumber($userId, /*$vacationType =*/ 1);
        $variables['sicks'] = $sicks;
        
        $casuals = $vacationModel->getVacationNumber($userId, /*$vacationType =*/ 2);
        $variables['casuals'] = $casuals;
    
        $annuals = $vacationModel->getVacationNumber($userId, /*$vacationType =*/ 3);
        $variables['annuals'] = $annuals;
        
        $balance = $vacationModel->getVacationBalance($userId);
        $variables['balance'] = $balance;
        
        return new ViewModel($variables);
    }


}


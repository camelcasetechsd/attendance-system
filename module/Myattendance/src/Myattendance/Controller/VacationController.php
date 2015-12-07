<?php

namespace Myattendance\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

/**
 * Vacation Controller
 * 
 * Vacation entries listing for current user
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @package myattendance
 * @subpackage controller
 */
class VacationController extends ActionController
{

    /**
     * List current user vacation entries
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses AuthenticationService
     * 
     * @access public
     * @return ViewModel
     */
    public function indexAction()
    {
        $variables = array();
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $userId = $storage['id'];
        
        $vacationModel = $this->getServiceLocator()->get('Myattendance\Model\Vacation');
        
        // get taken vacations
        $sickVacation = $vacationModel->getVacation($userId, /*$vacationType =*/ 1);
        $variables['sick'] = $sickVacation;

        $casualVacation = $vacationModel->getVacation($userId, /*$vacationType =*/ 2);
        $variables['casual'] = $casualVacation;

        $annualVacation = $vacationModel->getVacation($userId, /*$vacationType =*/ 3);
        $variables['annual'] = $annualVacation;
    
        // get number of taken vacations
        $sicks = $vacationModel->getVacationNumber($userId, /*$vacationType =*/ 1);
        $variables['sicks'] = $sicks;
        
        $casuals = $vacationModel->getVacationNumber($userId, /*$vacationType =*/ 2);
        $variables['casuals'] = $casuals;
    
        $annuals = $vacationModel->getVacationNumber($userId, /*$vacationType =*/ 3);
        $variables['annuals'] = $annuals;
        
        // get current remaining vacation balance
        $balance = $vacationModel->getVacationBalance($userId);
        $variables['balance'] = $balance;
        
        return new ViewModel($variables);
    }


}


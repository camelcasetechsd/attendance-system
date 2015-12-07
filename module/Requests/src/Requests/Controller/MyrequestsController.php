<?php

namespace Requests\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Requests\Entity\Permission;
use Requests\Entity\VacationRequest;
use Requests\Entity\WorkFromHome;

/**
 * Myrequests Controller
 * 
 * requests entries listing for current user or all users with processing capabilities
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @package requests
 * @subpackage controller
 */
class MyrequestsController extends ActionController {

    /**
     * List current user or all users requests entries
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses AuthenticationService
     * 
     * @return ViewModel
     */
    public function indexAction() {
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $permissionModel = $this->getServiceLocator()->get('Requests\Model\Permission');
        $vacationModel = $this->getServiceLocator()->get('Requests\Model\Vacation');
        $workFromHomeModel = $this->getServiceLocator()->get('Requests\Model\WorkFromHome');
        $acl = $this->getServiceLocator()->get('Users\Acl\Acl');
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $resource = 'Requests\Controller\Myrequests';

        $criteria = array();
        if ($acl->isAllowed($storage['rolename'], $resource, 'viewall')) {
            $criteria['user'] = $storage['id'];
        }
        $cancelActionAllowed = $acl->isAllowed($storage['rolename'], $resource, 'cancel');
        $approveActionAllowed = $acl->isAllowed($storage['rolename'], $resource, 'approve');
        $declineActionAllowed = $acl->isAllowed($storage['rolename'], $resource, 'decline');

        $permissionsEntities = $query->findBy('Requests\Entity\Permission', $criteria);
        foreach ($permissionsEntities as $request) {
            $request->cancelActionAllowed = ($cancelActionAllowed && ($request->status == Permission::STATUS_SUBMITTED));
            $request->approveActionAllowed = $approveActionAllowed && ($request->status == Permission::STATUS_SUBMITTED);
            $request->declineActionAllowed = $declineActionAllowed && ($request->status == Permission::STATUS_SUBMITTED);
        }
        $preparedPermissions = $permissionModel->prepareForDisplay($permissionsEntities);

        $vacationRequestsEntities = $query->findBy('Requests\Entity\VacationRequest', $criteria);
        foreach ($vacationRequestsEntities as $request) {
            $request->cancelActionAllowed = $cancelActionAllowed && ($request->status == VacationRequest::STATUS_SUBMITTED);
            $request->approveActionAllowed = $approveActionAllowed && ($request->status == VacationRequest::STATUS_SUBMITTED);
            $request->declineActionAllowed = $declineActionAllowed && ($request->status == VacationRequest::STATUS_SUBMITTED);
        }
        $preparedVacationRequests = $vacationModel->prepareForDisplay($vacationRequestsEntities);

        $workFromHomeRequestsEntities = $query->findBy('Requests\Entity\WorkFromHome', $criteria);
        foreach ($workFromHomeRequestsEntities as $request) {
            $request->cancelActionAllowed = $cancelActionAllowed && ($request->status == WorkFromHome::STATUS_SUBMITTED);
            $request->approveActionAllowed = $approveActionAllowed && ($request->status == WorkFromHome::STATUS_SUBMITTED);
            $request->declineActionAllowed = $declineActionAllowed && ($request->status == WorkFromHome::STATUS_SUBMITTED);
        }
        $preparedWorkFromHomeRequests = $workFromHomeModel->prepareForDisplay($workFromHomeRequestsEntities);

        $variables = array(
            'permissions' => $preparedPermissions,
            'vacationRequests' => $preparedVacationRequests,
            'workFromHomeRequests' => $preparedWorkFromHomeRequests,
        );
        return new ViewModel($variables);
    }

    /**
     * Approve request
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
    public function approveAction() {
        $requestId = $this->params('id');
        $requestType = $this->params('requestType');
        $myRequestModel = $this->getServiceLocator()->get('Requests\Model\MyRequest');
        $myRequestModel->approve($requestId, $requestType);
        
        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'requestsMyrequests'));
        $this->redirect()->toUrl($url);
    }

    /**
     * Cancel request
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
    public function cancelAction() {
        $requestId = $this->params('id');
        $requestType = $this->params('requestType');
        $myRequestModel = $this->getServiceLocator()->get('Requests\Model\MyRequest');
        $myRequestModel->cancel($requestId, $requestType);
        
        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'requestsMyrequests'));
        $this->redirect()->toUrl($url);
    }

    /**
     * Decline request
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
    public function declineAction() {
        $requestId = $this->params('id');
        $requestType = $this->params('requestType');
        $myRequestModel = $this->getServiceLocator()->get('Requests\Model\MyRequest');
        $myRequestModel->decline($requestId, $requestType);
        
        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'requestsMyrequests'));
        $this->redirect()->toUrl($url);
    }

}

<?php

namespace Requests\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Requests\Entity\WorkFromHome;
use Requests\Form\WorkfromhomeForm;
use Zend\Authentication\AuthenticationService;
use Requests\Form\CommentForm;
use Requests\Entity\Comment;

/**
 * Workfromhome Controller
 * 
 * Workfromhome requests entries listing for current user
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @package requests
 * @subpackage controller
 */
class WorkfromhomeController extends ActionController
{

    /**
     * Default Action
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
     * Delete request comment
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
    public function deletecommentAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $comment = $query->find('Requests\Entity\Comment', $id);
        $requestId = $comment->request_id;
        $query->remove($comment);

        $url = $this->getEvent()->getRouter()->assemble(array('id' => $requestId), array('name' => 'showRequestsWorkfromhome'));
        $this->redirect()->toUrl($url);
    }

    /**
     * Request new WorkFromHome
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses AuthenticationService
     * @uses WorkFromHome
     * @uses WorkfromhomeForm
     * 
     * @return ViewModel
     */
    public function newAction()
    {
        $variables = array();
        $workFromHomeModel = $this->getServiceLocator()->get('Requests\Model\WorkFromHome');
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $workFromHomeObj = new WorkFromHome();

        $form = new WorkfromhomeForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($workFromHomeObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'requestsMyrequests'));
                $workFromHomeModel->create($workFromHomeObj, $data, /* $userId = */ $storage['id'], $url);
                $this->redirect()->toUrl($url);
            }
        }

        $variables['newform'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    /**
     * Show WorkFromHome and comments on it
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses AuthenticationService
     * @uses CommentForm
     * @uses Comment
     * 
     * @return ViewModel
     */
    public function showAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $workFromHomeModel = $this->getServiceLocator()->get('Requests\Model\WorkFromHome');
        $commentModel = $this->getServiceLocator()->get('Requests\Model\Comment');
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $userId = $storage['id'];
                
        $workFromHome = $query->find('Requests\Entity\WorkFromHome', $id);
        $preparedWorkFromHomeEntities = $workFromHomeModel->prepareForDisplay(array($workFromHome));
        $preparedWorkFromHome = reset($preparedWorkFromHomeEntities);
        $currentUserRole = $storage['role'];

        $variables = array(
            'creator' => $preparedWorkFromHome->user,
            'startDate' => $preparedWorkFromHome->startDate,
            'endDate' => $preparedWorkFromHome->endDate,
            'reason' => $preparedWorkFromHome->reason,
            'dateOfSubmission' => $preparedWorkFromHome->dateOfSubmission,
            'status' => $preparedWorkFromHome->status,
        );

        if ($currentUserRole === 1) {
            $variables['role'] = TRUE;
        }

        $form = new CommentForm();
        $commentObj = new Comment();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($commentObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $commentModel->create($commentObj, $data, $userId, /*$requestId =*/$id ,/*$requestType =*/ 3);
            }
        }
        
        $comments = $commentModel->listRequestComments($userId, /*$requestId =*/$id, /*$requestType =*/ 3);
        $variables['requestComments'] = $comments;
        $variables['commentForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }


}


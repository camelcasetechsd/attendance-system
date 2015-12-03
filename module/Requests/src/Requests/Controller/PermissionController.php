<?php

namespace Requests\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Requests\Form\PermissionForm;
use Requests\Form\CommentForm;
use Requests\Entity\Permission;
use Requests\Entity\Comment;
use Zend\Authentication\AuthenticationService;

class PermissionController extends ActionController {

    public function indexAction() {
        return new ViewModel();
    }

    public function newAction() {
        $variables = array();
        $permissionModel = $this->getServiceLocator()->get('Requests\Model\Permission');
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $permissionObj = new Permission();

        $form = new PermissionForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($permissionObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'requestsMyrequests'));
                $permissionModel->create($permissionObj, $data, /* $userId = */ $storage['id'], $url);
                $this->redirect()->toUrl($url);
            }
        }

        $variables['form'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function showAction() {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $permissionModel = $this->getServiceLocator()->get('Requests\Model\Permission');
        $commentModel = $this->getServiceLocator()->get('Requests\Model\Comment');
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $userId = $storage['id'];
                
        $permission = $query->find('Requests\Entity\Permission', $id);
        $preparedPermissions = $permissionModel->prepareForDisplay(array($permission));
        $preparedPermission = reset($preparedPermissions);
        $currentUserRole = $storage['role'];

        $variables = array(
            'permissionCreator' => $preparedPermission->user,
            'permissionDate' => $preparedPermission->date,
            'fromTime' => $preparedPermission->fromTime,
            'toTime' => $preparedPermission->toTime,
            'dateOfSubmission' => $preparedPermission->dateOfSubmission,
            'status' => $preparedPermission->status,
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
                $commentModel->create($commentObj, $data, $userId, /*$requestId =*/$id ,/*$requestType =*/ 1);
            }
        }
        
        $comments = $commentModel->listRequestComments($userId, /*$requestId =*/$id, /*$requestType =*/ 1);
        $variables['requestComments'] = $comments;
        $variables['commentForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function deletecommentAction() {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $comment = $query->find('Requests\Entity\Comment', $id);
        $requestId = $comment->request_id;
        $query->remove($comment);

        $url = $this->getEvent()->getRouter()->assemble(array('id' => $requestId), array('name' => 'showRequestsPermission'));
        $this->redirect()->toUrl($url);
    }

}

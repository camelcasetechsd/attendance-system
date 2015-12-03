<?php

namespace Requests\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Requests\Form\VacationRequestForm;
use Requests\Form\CommentForm;
use Requests\Entity\VacationRequest;
use Requests\Entity\Comment;
use Zend\Authentication\AuthenticationService;
use Settings\Entity\Vacation as VacationType;

class VacationController extends ActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function newAction()
    {
        $variables = array();
        $vacationModel = $this->getServiceLocator()->get('Requests\Model\Vacation');
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $vacationObj = new VacationRequest();

        $form = new VacationRequestForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            // Make certain to merge the files info!
            $fileData = $request->getFiles()->toArray();
            $data = array_merge_recursive(
                    $request->getPost()->toArray(), $fileData
            );
            $form->setInputFilter($vacationObj->getInputFilter());
            $inputFilter = $form->getInputFilter();
            $form->setData($data);
            if ($data['type'] != VacationType::SICK_LEAVE) {
                // Change required flag to false for any previously uploaded files
                $input = $inputFilter->get('attachment');
                $input->setRequired(false);
            }
            if ($form->isValid()) {
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'requestsMyrequests'));
                $vacationModel->create($vacationObj, $data, /* $userId = */ $storage['id'], $url);
                $this->redirect()->toUrl($url);
            }
        }

        $variables['vacationRequestForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function showAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $vacationModel = $this->getServiceLocator()->get('Requests\Model\Vacation');
        $commentModel = $this->getServiceLocator()->get('Requests\Model\Comment');
        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        $userId = $storage['id'];
                
        $vacation = $query->find('Requests\Entity\VacationRequest', $id);
        $preparedVacations = $vacationModel->prepareForDisplay(array($vacation));
        $preparedVacation = reset($preparedVacations);
        $currentUserRole = $storage['role'];

        $variables = array(
            'vacationCreator' => $preparedVacation->user,
            'vacationType' => $preparedVacation->vacationType,
            'fromDate' => $preparedVacation->fromDate,
            'toDate' => $preparedVacation->toDate,
            'dateOfSubmission' => $preparedVacation->dateOfSubmission,
            'status' => $preparedVacation->status,
            'attachment' => $preparedVacation->attachment,
        );
        if (is_null($preparedVacation->attachment)) {
            $variables['attchNullFlag'] = TRUE;
        } else {
            $variables['attachImgFlag'] = TRUE;
        }

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
                $commentModel->create($commentObj, $data, $userId, /*$requestId =*/$id ,/*$requestType =*/ 2);
            }
        }
        
        $comments = $commentModel->listRequestComments($userId, /*$requestId =*/$id, /*$requestType =*/ 2);
        $variables['requestComments'] = $comments;
        $variables['commentForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function deletecommentAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $comment = $query->find('Requests\Entity\Comment', $id);
        $requestId = $comment->request_id;
        $query->remove($comment);

        $url = $this->getEvent()->getRouter()->assemble(array('id' => $requestId), array('name' => 'showRequestsVacation'));
        $this->redirect()->toUrl($url);
    }


}


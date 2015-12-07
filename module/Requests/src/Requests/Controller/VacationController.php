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

/**
 * Vacation Controller
 * 
 * Vacation requests entries listing for current user
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author mohamed ramadan
 * 
 * @package requests
 * @subpackage controller
 */
class VacationController extends ActionController
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
     * Request new vacation
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses AuthenticationService
     * @uses VacationRequest
     * @uses VacationRequestForm
     * 
     * @return ViewModel
     */
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

    /**
     * Show vacation and comments on it
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

        $url = $this->getEvent()->getRouter()->assemble(array('id' => $requestId), array('name' => 'showRequestsVacation'));
        $this->redirect()->toUrl($url);
    }


}


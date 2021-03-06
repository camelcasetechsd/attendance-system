<?php

namespace Users\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Users\Form\UserForm;
use Users\Entity\User;

/**
 * Index Controller
 * 
 * users entries listing for adminstration
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package users
 * @subpackage controller
 */
class IndexController extends ActionController {

    /**
     * List users paginated
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return ViewModel
     */
    public function indexAction() {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $userModel = $this->getServiceLocator()->get('Users\Model\User');

        $data = $query->findAll('Users\Entity\User');
        // process data that will be displayed later
        $processedData = $userModel->prepareForDisplay($data);

        $pageNumber = $this->getRequest()->getQuery('page');
        $userModel->setPage($pageNumber);

        // know the number of pages
        $numberOfPages = $userModel->getNumberOfPages();
        //create an array of page numbers
        if ($numberOfPages > 1) {
            $pageNumbers = range(1, $numberOfPages);
        } else {
            $pageNumbers = array();
        }

        $variables['userList'] = $userModel->getCurrentItems();
        $variables['pageNumbers'] = $pageNumbers;
        return new ViewModel($variables);
    }

    /**
     * Edit user
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses UserForm
     * 
     * @return ViewModel
     */
    public function editAction() {
        $variables = array();
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $userModel = $this->getServiceLocator()->get('Users\Model\User');
        $userObj = $query->find('Users\Entity\User', $id);
        $photo = $userObj->photo;

        $options = array();
        $options['query'] = $query;
        $form = new UserForm(/* $name = */ null, $options);
        $form->bind($userObj);

        $request = $this->getRequest();
        if ($request->isPost()) {

            // Make certain to merge the files info!
            $fileData = $request->getFiles()->toArray();

            $data = array_merge_recursive(
                    $request->getPost()->toArray(), $fileData
            );

            $form->setInputFilter($userObj->getInputFilter());
            $inputFilter = $form->getInputFilter();
            $form->setData($data);
            // file not updated
            if (isset($fileData['photo']['name']) && empty($fileData['photo']['name'])) {
                // Change required flag to false for any previously uploaded files
                $input = $inputFilter->get('photo');
                $input->setRequired(false);
            }
            if (empty($data['password'])) {
                $password = $inputFilter->get('password');
                $password->setRequired(false);
                $confirmPassword = $inputFilter->get('confirmPassword');
                $confirmPassword->setRequired(false);
            }
            if ($form->isValid()) {
                $userModel->saveUser($data, $userObj);

                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'users'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['photo'] = $photo;
        $variables['userForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    /**
     * Create new user
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses User
     * @uses UserForm
     * 
     * @return ViewModel
     */
    public function newAction() {

        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery')->setEntity('Users\Entity\User');
        $userModel = $this->getServiceLocator()->get('Users\Model\User');
        $userObj = new User();
        $options = array();
        $options['query'] = $query;
        $form = new UserForm(/* $name = */ null, $options);

        $request = $this->getRequest();
        if ($request->isPost()) {

            // Make certain to merge the files info!
            $fileData = $request->getFiles()->toArray();

            $data = array_merge_recursive(
                    $request->getPost()->toArray(), $fileData
            );

            $form->setInputFilter($userObj->getInputFilter());
            $form->setData($data);
            if ($data['password'] != $data['confirmPassword']) {
                $form->get('confirmPassword')->setMessages(array("password doesnt match"));
            }
            if ($form->isValid()) {
                $userModel->saveUser($data);

                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'users'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['userForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    /**
     * Delete user
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
    public function deleteAction() {
        $id = $this->params('id');
        $userModel = $this->getServiceLocator()->get('Users\Model\User');
        $userModel->deleteUser($id);
        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'users'));
        $this->redirect()->toUrl($url);
    }

}

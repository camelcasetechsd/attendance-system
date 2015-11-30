<?php

namespace Users\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Users\Form\UserForm;
use Users\Entity\User;

class IndexController extends ActionController {

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
            var_dump($fileData);
            if (empty($data['password'])) {
                $samePassword = User::SAME_PASSWORD;
                $data['password'] = $data['confirmPassword'] = $samePassword;
                $form->get("password")->setValue($samePassword);
                $form->get("confirmPassword")->setValue($samePassword);
            }

            $form->setInputFilter($userObj->getInputFilter());
            $form->setData($data);
            // file not updated
            if(isset($fileData['photo']['name']) && empty($fileData['photo']['name'])){
                // Change required flag to false for any previously uploaded files
                $inputFilter   = $form->getInputFilter();
                $input = $inputFilter->get('photo');
                $input->setRequired(false);
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

    public function newAction() {
        return new ViewModel();
    }

    public function deleteAction() {
        return new ViewModel();
    }

}

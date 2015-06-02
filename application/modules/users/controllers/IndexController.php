<?php

class Users_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {

        // get all databases entities
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $UserModel = new Users_Model_User($em);

        // know the desired page and get specified entities
        $UserModel->setPage($this->_getParam('page'));

        // know the number of pages
        $numberOfPages = $UserModel->getNumberOfPages();

        //create an array of page numbers
        if ($numberOfPages > 1) {
            $pageNumbers = range(1, $numberOfPages);
        } else {
            $pageNumbers = array();
        }

        //setting view varaiables
        $this->view->userList = $UserModel->getCurrentItems();
        $this->view->pageNumbers = $pageNumbers;
    }

    public function editAction()
    {
        $form = new Users_Form_User();
        $this->view->userForm = $form;
    }

}

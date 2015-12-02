<?php

namespace Settings\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Settings\Entity\Department;
use Settings\Form\DepartmentForm;

class DepartmentsController extends ActionController
{

    public function indexAction()
    {
        $variables = array();
        $departmentModel = $this->getServiceLocator()->get('Settings\Model\Departments');
        
        $data = $departmentModel->listDepartments();
        $variables['departments'] = $data;
        return new ViewModel($variables);
    }

    public function newAction()
    {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery')->setEntity('Settings\Entity\Department');
        $departmentObj = new Department();

        $options = array();
        $options['query'] = $query;
        $form = new DepartmentForm(/* $name = */ null, $options);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($departmentObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $departmentObj->setStatus(Department::STATUS_ACTIVE);
                $query->save($departmentObj, $data);
                
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsDepartments'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['departmentForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function editAction()
    {
        $variables = array();
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $departmentObj = $query->find('Settings\Entity\Department', $id);

        $options = array();
        $options['query'] = $query;
        $form = new DepartmentForm(/* $name = */ null, $options);
        $form->bind($departmentObj);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($departmentObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $query->save($departmentObj);
                
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsDepartments'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['departmentForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $departmentObj = $query->find('Settings\Entity\Department', $id);
        
        $departmentObj->setStatus(Department::STATUS_DELETED);

        $query->save($departmentObj);
        
        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsDepartments'));
        $this->redirect()->toUrl($url);
    }


}


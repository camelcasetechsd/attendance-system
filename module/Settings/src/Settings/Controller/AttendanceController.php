<?php

namespace Settings\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Settings\Form\AttendanceForm;
use Settings\Entity\Attendance;

class AttendanceController extends ActionController
{

    public function indexAction()
    {
        $variables = array();
        $attendanceModel = $this->getServiceLocator()->get('Settings\Model\Attendance');
        
        $data = $attendanceModel->listAttendances();
        $variables['attendances'] = $data;
        return new ViewModel($variables);
    }

    public function newAction()
    {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery')->setEntity('Settings\Entity\Attendance');
        $attendanceObj = new Attendance();

        $options = array();
        $options['query'] = $query;
        $form = new AttendanceForm(/* $name = */ null, $options);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($attendanceObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $query->save($attendanceObj, $data);
                
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsAttendance'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['form'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $attendanceObj = $query->find('Settings\Entity\Attendance', $id);
        
        $attendanceObj->setActive(false);

        $query->save($attendanceObj);
        
        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsAttendance'));
        $this->redirect()->toUrl($url);
    }

    public function editAction()
    {
        $variables = array();
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $attendanceObj = $query->find('Settings\Entity\Attendance', $id);

        $options = array();
        $options['query'] = $query;
        $form = new AttendanceForm(/* $name = */ null, $options);
        $form->bind($attendanceObj);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($attendanceObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $query->save($attendanceObj);
                
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsAttendance'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['editForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }


}


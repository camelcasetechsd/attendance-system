<?php

namespace Settings\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Settings\Form\AttendanceForm;
use Settings\Entity\Attendance;

/**
 * Attendance Controller
 * 
 * attendance entries listing for current user
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @package settings
 * @subpackage controller
 */
class AttendanceController extends ActionController
{

    /**
     * List current user attendance entries
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * 
     * @return ViewModel
     */
    public function indexAction()
    {
        $variables = array();
        $attendanceModel = $this->getServiceLocator()->get('Settings\Model\Attendance');
        
        $data = $attendanceModel->listAttendances();
        $variables['attendances'] = $data;
        return new ViewModel($variables);
    }

    /**
     * Create new attendance
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses Attendance
     * @uses AttendanceForm
     * 
     * @return ViewModel
     */
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

    /**
     * Delete attendance
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
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

    /**
     * Edit attendance
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses AttendanceForm
     * 
     * @return ViewModel
     */
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


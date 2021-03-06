<?php

namespace Settings\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Settings\Form\FilterByYearForm;
use Settings\Form\HolidayForm;
use Settings\Entity\Holiday;

/**
 * Holidays Controller
 * 
 * holidays entries listing
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @package settings
 * @subpackage controller
 */
class HolidayController extends ActionController {

    /**
     * List holidays
     * Filter holidays by year if a year is selected
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses FilterByYearForm
     * 
     * @return ViewModel
     */
    public function indexAction() {
        $variables = array();
        $year = $this->getRequest()->getPost('year');

        $holidayModel = $this->getServiceLocator()->get('Settings\Model\Holiday');
        $query = $this->getServiceLocator()->get('wrapperQuery');

        $options = array();
        $options['query'] = $query;
        $options['year'] = $year;
        $filterForm = new FilterByYearForm(/* $name = */ null, $options);
        if (!empty($year)) {
            $holidayList = $holidayModel->filterByYear($year);
        } else {
            $holidayList = $query->findBy('Settings\Entity\Holiday', array('active' => 1));
        }
        foreach ($holidayList as $holiday) {
            $holiday->dateFrom = date_format($holiday->dateFrom, 'm/d/Y');
            $holiday->dateTo = date_format($holiday->dateTo, 'm/d/Y');
        }
        $variables['filterForm'] = $this->getFormView($filterForm);
        $variables['holidayList'] = $holidayList;
        return new ViewModel($variables);
    }

    /**
     * Get all holidays as JSON
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string JSON encoded holidays array
     */
    public function fetchallholidayAction() {
        $holidayModel = $this->getServiceLocator()->get('Settings\Model\Holiday');
        $query = $this->getServiceLocator()->get('wrapperQuery');

        $holidayList = $query->findBy('Settings\Entity\Holiday', array('active' => 1));
        $allholiday = $holidayModel->getAllHoliday($holidayList);

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode($allholiday));
        return $response;
    }

    /**
     * Create new holiday
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses Holiday
     * @uses HolidayForm
     * 
     * @return ViewModel
     */
    public function newAction() {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery')->setEntity('Settings\Entity\Holiday');
        $holidayObj = new Holiday();

        $form = new HolidayForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($holidayObj->getInputFilter());
            $form->setData($data);
            if (empty($data['dateTo'])) {
                $data['dateTo'] = $data['dateFrom'];
            }
            if ($form->isValid()) {
                $query->save($holidayObj, $data);

                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsHoliday'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['form'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    /**
     * Edit holiday
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses HolidayForm
     * 
     * @return ViewModel
     */
    public function editAction() {
        $variables = array();
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $holidayObj = $query->find('Settings\Entity\Holiday', $id);

        $form = new HolidayForm();
        $form->bind($holidayObj);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($holidayObj->getInputFilter());
            $form->setData($data);
            if (empty($data['dateTo'])) {
                $data['dateTo'] = $data['dateFrom'];
            }
            if ($form->isValid()) {
                $query->save($holidayObj);

                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsHoliday'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['editForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    /**
     * Delete holiday
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
    public function deleteAction() {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $holidayObj = $query->find('Settings\Entity\Holiday', $id);

        $holidayObj->setActive(0);

        $query->save($holidayObj);

        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsHoliday'));
        $this->redirect()->toUrl($url);
    }

}

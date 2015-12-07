<?php

namespace Settings\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Settings\Form\VacationForm;
use Settings\Entity\Vacation;

/**
 * Vacation Controller
 * 
 * vacations entries listing
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @package settings
 * @subpackage controller
 */
class VacationController extends ActionController {

    /**
     * List vacations
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     *  
     * @return ViewModel
     */
    public function indexAction() {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery');

        $vacations = $query->findBy('Settings\Entity\Vacation', array('active' => 1));
        $variables['vacations'] = $vacations;
        return new ViewModel($variables);
    }

    /**
     * Create new vacations
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses Vacation
     * @uses VacationForm
     * 
     * @return ViewModel
     */
    public function newAction() {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery')->setEntity('Settings\Entity\Vacation');
        $vacationObj = new Vacation();

        $form = new VacationForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($vacationObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $query->save($vacationObj, $data);

                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsVacation'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['form'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    /**
     * Edit vacation
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses VacationForm
     * 
     * @return ViewModel
     */
    public function editAction() {
        $variables = array();
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $vacationObj = $query->find('Settings\Entity\Vacation', $id);

        $form = new VacationForm();
        $form->bind($vacationObj);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($vacationObj->getInputFilter());
            $form->setData($data);
            if (empty($data['dateTo'])) {
                $data['dateTo'] = $data['dateFrom'];
            }
            if ($form->isValid()) {
                $query->save($vacationObj);

                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsVacation'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['editForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    /**
     * Delete vacation
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
    public function deleteAction() {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $vacationObj = $query->find('Settings\Entity\Vacation', $id);

        $vacationObj->setActive(0);

        $query->save($vacationObj);

        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsVacation'));
        $this->redirect()->toUrl($url);
    }

}

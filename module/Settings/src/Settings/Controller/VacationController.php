<?php

namespace Settings\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Settings\Form\VacationForm;
use Settings\Entity\Vacation;

/**
 * @author ahmed
 */
class VacationController extends ActionController {

    public function indexAction() {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery');

        $vacations = $query->findBy('Settings\Entity\Vacation', array('active' => 1));
        $variables['vacations'] = $vacations;
        return new ViewModel($variables);
    }

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

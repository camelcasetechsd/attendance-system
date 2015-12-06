<?php

namespace Settings\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Settings\Form\PositionForm;
use Settings\Entity\Position;

/**
 * @author ahmed
 */
class PositionController extends ActionController
{

    public function indexAction()
    {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery')->setEntity('Settings\Entity\Position');
        
        $data = $query->findAll(/*$entityName =*/null);
        $variables['positions'] = $data;
        return new ViewModel($variables);
    }

    public function newAction()
    {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery')->setEntity('Settings\Entity\Position');
        $positionObj = new Position();

        $form = new PositionForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($positionObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $query->save($positionObj, $data);
                
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsPosition'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['positionForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function editAction()
    {
        $variables = array();
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $positionObj = $query->find('Settings\Entity\Position', $id);

        $form = new PositionForm();
        $form->bind($positionObj);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($positionObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $query->save($positionObj);
                
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsPosition'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['positionForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $positionObj = $query->find('Settings\Entity\Position', $id);
        
        $query->remove($positionObj);
        
        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsPosition'));
        $this->redirect()->toUrl($url);
    }


}


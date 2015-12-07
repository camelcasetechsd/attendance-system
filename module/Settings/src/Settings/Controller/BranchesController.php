<?php

namespace Settings\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Settings\Form\BranchesForm;
use Settings\Entity\Branch;

/**
 * Branches Controller
 * 
 * branches entries listing
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author abdel-moneim
 * 
 * @package settings
 * @subpackage controller
 */
class BranchesController extends ActionController
{

    /**
     * List branches
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * 
     * @return ViewModel
     */
    public function indexAction()
    {
        $variables = array();
        $branchesModel = $this->getServiceLocator()->get('Settings\Model\Branches');
        
        $data = $branchesModel->listBranches();
        $variables['branches'] = $data;
        return new ViewModel($variables);
    }

    /**
     * Create new branch
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses Branch
     * @uses BranchesForm
     * 
     * @return ViewModel
     */
    public function newAction()
    {
        $variables = array();
        $query = $this->getServiceLocator()->get('wrapperQuery')->setEntity('Settings\Entity\Branch');
        $branchObj = new Branch();

        $options = array();
        $options['query'] = $query;
        $form = new BranchesForm(/* $name = */ null, $options);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($branchObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $branchObj->setStatus(Branch::STATUS_ACTIVE);
                $query->save($branchObj, $data);
                
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsBranches'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['branchesForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    /**
     * Edit branch
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses BranchesForm
     * 
     * @return ViewModel
     */
    public function editAction()
    {
        $variables = array();
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $branchObj = $query->find('Settings\Entity\Branch', $id);

        $options = array();
        $options['query'] = $query;
        $form = new BranchesForm(/* $name = */ null, $options);
        $form->bind($branchObj);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setInputFilter($branchObj->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $query->save($branchObj);
                
                $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsBranches'));
                $this->redirect()->toUrl($url);
            }
        }

        $variables['branchesForm'] = $this->getFormView($form);
        return new ViewModel($variables);
    }

    /**
     * Delete branch
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     */
    public function deleteAction()
    {
        $id = $this->params('id');
        $query = $this->getServiceLocator()->get('wrapperQuery');
        $branchObj = $query->find('Settings\Entity\Branch', $id);
        
        $branchObj->setStatus(Branch::STATUS_INACTIVE);

        $query->save($branchObj);
        
        $url = $this->getEvent()->getRouter()->assemble(array('action' => 'index'), array('name' => 'settingsBranches'));
        $this->redirect()->toUrl($url);
    }


}


<?php

namespace Users\Event;

use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;
use Users\Acl\Acl as AclClass;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Request as HttpRequest ;
use Zend\Http\Response;

/**
 * Authentication Event Handler Class
 *
 * This Event Handles Authentication
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author Marco Neumann <webcoder@binware.org>
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license http://binware.org/license/index/type:new-bsd New BSD License
 * 
 * @property AclClass $_aclClass
 * 
 * @package users
 * @subpackage event
 */
class AuthenticationEvent extends AbstractActionController {

    /**
     * @var AclClass
     */
    protected $_aclClass = null;

    /**
     * preDispatch Event Handler
     * Handle authentication process
     * Decide where user should be redirected to when logged in or not
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses AuthenticationService
     * @uses Response
     * 
     * @param \Zend\Mvc\MvcEvent $event
     * @throws \Exception
     */
    public function preDispatch(MvcEvent $event) {
        
        // ACL dispatcher is used only in HTTP requests not console requests
        if(! $event->getRequest() instanceof HttpRequest){
            return;
        }
        $userAuth = new AuthenticationService();
        $role = AclClass::DEFAULT_ROLE;
        $acl = $this->getAclClass();
        $user = array();
        $signInController = 'DefaultModule\Controller\Sign';
        if ($userAuth->hasIdentity()) {
            $user = $userAuth->getIdentity();
            $role = $user['rolename'];
        }


        $routeMatch = $event->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        $action = $routeMatch->getParam('action');

        if (!$acl->hasResource($controller)) {
            throw new \Exception('Resource ' . $controller . ' not defined');
        }

        if (!$userAuth->hasIdentity() && $controller != $signInController) {
            // redirect to sign/in
            $url = $event->getRouter()->assemble(array('action' => 'in'), array('name' => 'defaultSign'));
        } else if ($userAuth->hasIdentity() && isset($user['status']) && $user['status'] == 2) {
            $userAuth->clearIdentity();
            // redirect to sign/out
            $url = $event->getRouter()->assemble(array('action' => 'out'), array('name' => 'defaultSign'));
        } else if ($userAuth->hasIdentity() && $controller == $signInController &&
                $action == 'in') {
            // redirect to index
            $url = $event->getRouter()->assemble(array('action' => 'index'), array('name' => 'home'));
        } else if (!$acl->isAllowed($role, $controller, $action)) {
            // redirect to error
            $url = $event->getRouter()->assemble(array('action' => 'index'), array('name' => 'defaultError'));
        }



        if (isset($url)) {
            $event->setResponse(new Response());
            $this->redirect()->getController()->setEvent($event);
            $response = $this->redirect()->toUrl($url);
            return $response;
        }
    }

    /**
     * Sets ACL Class
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param \User\Acl\Acl $aclClass
     * @return Authentication
     */
    public function setAclClass(AclClass $aclClass) {
        $this->_aclClass = $aclClass;

        return $this;
    }

    /**
     * Gets ACL Class
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @uses AclClass
     * 
     * @return \User\Acl\Acl
     */
    public function getAclClass() {
        if ($this->_aclClass === null) {
            $this->_aclClass = new AclClass(array());
        }

        return $this->_aclClass;
    }

}

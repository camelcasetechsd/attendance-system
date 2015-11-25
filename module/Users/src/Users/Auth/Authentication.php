<?php

namespace Users\Auth;

use Utilities\Service\Query\Query;
use Users\Auth\Adapter;
use Zend\Authentication\AuthenticationService;

class Authentication
{
    private $request;
    private $query;

    public function __construct(Query $query)
    {
        $this->query = $query;
    }
    
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function authenticateMe()
    {
        //get value of username from post
        $username = $this->request->getPost('username');
        // get value of password from post
        $password = $this->request->getPost('password');
        // hashing password to compare
        $adapter = new Adapter($this->query, "username", "password");
        $adapter->setIdentity($username);
        $adapter->setCredential($password);
        $result = $adapter->authenticate();
        // check on result there's any problem in login
        // if not check on auth plugin
        return $result;
    }

    public function newSession()
    {
        $entity = $this->query->findOneBy(/*$entityName =*/ 'Users\Entity\User', array(
            'username' => $this->request->getPost('username'),
        ));
        $auth = new AuthenticationService();
        $storage = $auth->getStorage();
        // here to add new entries to the session
        $storage->write(array(
            'id' => $entity->id,
            'name' => $entity->name,
            'username' => $entity->username,
            'photo' => $entity->photo,
            'role' => $entity->role,
            'rolename' => $entity->role->name,
            'status' =>  $entity->status
        ));
    }

}

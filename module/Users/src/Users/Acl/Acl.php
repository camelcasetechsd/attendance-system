<?php

/**
 * File for Acl Class
 *
 * @category  User
 * @package   User_Acl
 * @author    Marco Neumann <webcoder_at_binware_dot_org-->
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
/**
 * @namespace
 */

namespace Users\Acl;

/**
 * @uses Zend\Acl\Acl
 * @uses Zend\Acl\Role\GenericRole
 * @uses Zend\Acl\Resource\GenericResource
 */
use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

/**
 * Class to handle Acl
 *
 * This class is for loading ACL defined in a config
 *
 * @category User
 * @package  User_Acl
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
class Acl extends ZendAcl {

    /**
     * Default Role
     */
    const DEFAULT_ROLE = 'Employee';

    /**
     * Constructor
     *
     * @param array $config
     * @return void
     * @throws \Exception
     */
    public function __construct($config) {
        if (!isset($config['acl']['roles']) || !isset($config['acl']['resources'])) {
            throw new \Exception('Invalid ACL Config found');
        }

        $roles = $config['acl']['roles'];
        if (!in_array(self::DEFAULT_ROLE, $roles)) {
            $roles[] = self::DEFAULT_ROLE;
        }

        $this->_addRoles($roles)
                ->_addResources($config['acl']);
    }

    /**
     * Adds Roles to ACL
     *
     * @param array $roles
     * @return User\Acl
     */
    protected function _addRoles($roles) {
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                $parent = array();
                $this->addRole(new Role($role), $parent);
            }
        }
        return $this;
    }

    /**
     * Adds Resources to ACL
     *
     * @param $acl
     * @return User\Acl
     * @throws \Exception
     */
    protected function _addResources($acl) {
        $whitelist = $acl["whitelist"];
        $blacklist = $acl["blacklist"];
        foreach ($acl['resources'] as $resource) {
            if (!$this->hasResource($resource)) {
                $this->addResource(new Resource($resource));
            }
        }
        foreach ($whitelist as $aclItem) {
            if(array_key_exists('resources',$aclItem)){
                foreach ($aclItem['resources'] as $resource) {
                    foreach ($aclItem['roles'] as $role) {
                        if(!isset($aclItem['privileges'])){
                            $privilege = null;
                            $this->allow($role, $resource, $privilege);
                        }else{
                            foreach ($aclItem['privileges'] as $privilege) {
                                $this->allow($role, $resource, $privilege);
                            }
                        }
                    }
                }
            }
        }
        foreach ($blacklist['resources'] as $resource) {
            foreach ($blacklist['roles'] as $role) {
                $this->deny($role, $resource, /* $privilege = */ null);
            }
        }
        return $this;
    }

}

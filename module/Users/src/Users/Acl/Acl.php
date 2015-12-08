<?php

namespace Users\Acl;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

/**
 * Class to handle Acl
 *
 * This class is for loading ACL defined in a config
 *
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author    Marco Neumann <webcoder@binware.org>
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 * 
 * @package users
 * @subpackage acl
 */
class Acl extends ZendAcl {

    /**
     * Default Role
     */
    const DEFAULT_ROLE = 'Employee';

    /**
     * Set roles and resources
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param array $config
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

        $this->addRoles($roles)
                ->addResources($config['acl']);
    }

    /**
     * Adds Roles to ACL
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access protected
     * @uses Role
     * 
     * @param array $roles
     * @return User\Acl
     */
    protected function addRoles($roles) {
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
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access protected
     * @uses Resource
     * 
     * @param $acl
     * @return User\Acl
     * @throws \Exception
     */
    protected function addResources($acl) {
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

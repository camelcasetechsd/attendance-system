<?php

namespace Settings\Model;

use Settings\Entity\Department as DepartmentsEntity;

/**
 * Departments Model
 * 
 * Handles Department Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @property Utilities\Service\Query\Query $query
 * 
 * @package settings
 * @subpackage model
 */
class Departments {

    /**
     *
     * @var Utilities\Service\Query\Query 
     */
    protected $query;

    /**
     * Set needed properties
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Utilities\Service\Query\Query $query
     */
    public function __construct($query) {
        $this->query = $query;
    }

    /**
     * Prepare departments for display
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access private
     * @param array $data departments array
     * @return array departments array after being prepared for display
     */
    private function prepareForDisplay($data) {
        foreach ($data as $department) {
            if (is_null($department->manager)) {
                $department->manager = "Manager manager";
            } elseif (is_object($department) && property_exists($department->manager, 'name')) {
                $department->manager = $department->manager->name;
            }
            switch ($department->status) {
                case DepartmentsEntity::STATUS_ACTIVE :
                    $department->status = 'Active';
                    $department->active = TRUE;
                    break;
                case DepartmentsEntity::STATUS_DELETED :
                    $department->status = 'Deleted';
                    $department->active = False;
                    break;
            }
        }
        return $data;
    }

    /**
     * List departments
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return array departments ready for display
     */
    public function listDepartments() {
        $departments = $this->query->findAll(/*$entityName =*/null);
        $this->prepareForDisplay($departments);
        return $departments;
    }

}

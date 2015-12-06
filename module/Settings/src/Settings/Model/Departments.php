<?php

namespace Settings\Model;

use Settings\Entity\Department as DepartmentsEntity;

/**
 * @author ahmed
 */
class Departments {

    protected $query;

    public function __construct($query) {
        $this->query = $query;
    }

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

    public function listDepartments() {
        $departments = $this->query->findAll(/*$entityName =*/null);
        $this->prepareForDisplay($departments);
        return $departments;
    }

}

<?php

namespace Settings\Model;

use Settings\Entity\Branch as BranchesEntity;

class Branches {

    protected $query;

    public function __construct($query) {
        $this->query = $query;
    }

    private function prepareForDisplay($data) {
        foreach ($data as $branch) {
            if (is_null($branch->manager)) {
                $branch->manager = "Manager manager";
            } elseif (is_object($branch) && property_exists($branch->manager, 'name')) {
                $branch->manager = $branch->manager->name;
            }
            switch ($branch->status) {
                case BranchesEntity::STATUS_ACTIVE :
                    $branch->status = 'Active';
                    $branch->active = TRUE;
                    break;
                case BranchesEntity::STATUS_INACTIVE :
                    $branch->status = 'InActive';
                    break;
            }
        }
        return $data;
    }

    public function listBranches() {
        $branches = $this->query->findAll(/*$entityName =*/null);
        $this->prepareForDisplay($branches);
        return $branches;
    }

}

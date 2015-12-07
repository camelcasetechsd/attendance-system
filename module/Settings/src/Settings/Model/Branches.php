<?php

namespace Settings\Model;

use Settings\Entity\Branch as BranchesEntity;

/**
 * Branches Model
 * 
 * Handles Branch Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author abdel-moneim
 * 
 * @property Utilities\Service\Query\Query $query
 * 
 * @package settings
 * @subpackage model
 */
class Branches {

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
     * Prepare branches for display
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access private
     * @param array $data branches array
     * @return array branches array after being prepared for display
     */
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

    /**
     * List branches
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return array branches ready for display
     */
    public function listBranches() {
        $branches = $this->query->findAll(/*$entityName =*/null);
        $this->prepareForDisplay($branches);
        return $branches;
    }

}

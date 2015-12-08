<?php

namespace Utilities\Service;

/**
 * Random
 * 
 * Generate random values
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @package utilities
 * @subpackage service
 */
class Random {

    /**
     * Get random and unique value
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string random and almost unique value
     */
    public function getRandomUniqueName() {
        $uniqid = uniqid(mt_rand(), true);
        $cid = str_replace('.', '',$uniqid.md5($uniqid));
        return $cid;
    }

}

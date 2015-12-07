<?php

namespace Myattendance\Model;

/**
 * Attendance Model
 * 
 * Handles Attendance Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @property Utilities\Service\Query\Query $query wrapper query
 * @package myattendance
 * @subpackage model
 */
class Attendance {

    /**
     *
     * @var Utilities\Service\Query\Query 
     */
    protected $query;

    /**
     * set needed properties
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param Utilities\Service\Query\Query $query
     */
    public function __construct($query) {
        $this->query = $query;
    }

    /**
     * Filter attendances by user and time frame
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $dateFrom minimum attendance sign in time
     * @param string $dateTo maximum attendance sign in time
     * @param string $userId logged in user id
     * @return array filtered attendances
     */
    public function filterByYear($dateFrom,$dateTo,$userId)
    {
        $repository = $this->query->entityRepository;
        $parameters = array(
            'user' => $userId,
            'dateTo' => date("Y-m-d 23:59:59", strtotime($dateTo)),
            'dateFrom' => date("Y-m-d", strtotime($dateFrom)),
        );

        $qb = $repository->createQueryBuilder('a');
        $attendances = $qb->select('a')
                        ->andWhere($qb->expr()->eq('a.user', ':user'))
                        ->andWhere($qb->expr()->lte('a.timeIn', ':dateTo'))
                        ->andWhere($qb->expr()->gte('a.timeIn', ':dateFrom'))
                        ->setParameters($parameters)
                        ->getQuery()->getResult();
        return $attendances;
    }
}

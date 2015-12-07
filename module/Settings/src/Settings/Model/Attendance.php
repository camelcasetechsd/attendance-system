<?php

namespace Settings\Model;

use Doctrine\ORM\Query\Expr\Join;

/**
 * Attendance Model
 * 
 * Handles Attendance Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @property Utilities\Service\Query\Query $query
 * 
 * @package settings
 * @subpackage model
 */
class Attendance {

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
     * List attendances
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return array attendances ready for display
     */
    public function listAttendances() {
        $repository = $this->query->entityRepository;
        $parameters = array(
            'active' => 1,
        );
        $qb = $repository->createQueryBuilder('a');
        $attendances = $qb->select('a, b.name as branchName')
                        ->innerJoin('Settings\Entity\Branch', 'b', Join::WITH,$qb->expr()->eq('a.branch', 'b.id'))
                        ->andWhere($qb->expr()->eq('a.active', ':active'))
                        ->setParameters($parameters)
                        ->getQuery()->getResult();
        foreach ($attendances as &$attendance) {
            $attendance[0]->branch = $attendance['branchName'];
            $attendance = $attendance[0];
            $attendance->startTime = date_format($attendance->startTime, 'H:i:s');
            $attendance->endTime = date_format($attendance->endTime, 'H:i:s');
        }
        return $attendances;
    }
}

<?php

namespace Settings\Model;

use Doctrine\ORM\Query\Expr\Join;
use Settings\Entity\Attendance as AttendanceEntity;

class Attendance {

    protected $query;

    public function __construct($query) {
        $this->query = $query;
    }

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

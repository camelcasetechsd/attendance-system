<?php

namespace Myattendance\Model;

class Attendance {

    protected $query;

    public function __construct($query) {
        $this->query = $query;
    }

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

<?php

namespace Settings\Model;

class Holiday {

    protected $query;

    public function __construct($query) {
        $this->query = $query;
    }

    public function filterByYear($year)
    {
        $repository = $this->query->entityRepository;
        $parameters = array(
            'active' => 1,
            'year' => $year.'-1-1',
            'yearPlus' => new \DateTime(($year+1).'-1-1'),
        );
        $qb = $repository->createQueryBuilder('h');
        $holidays = $qb->select('h')
                        ->andWhere($qb->expr()->eq('h.active', ':active'))
                        ->andWhere($qb->expr()->lte('h.dateFrom', ':yearPlus'))
                        ->andWhere($qb->expr()->gte('h.dateFrom', ':year'))
                        ->setParameters($parameters)
                        ->getQuery()->getResult();
        return $holidays;
    }
    
    public function getAllHoliday($holidayList) {
        $allevents = array();
        foreach ($holidayList as $holiday) {
            $events['id']     = $holiday->id;
            $events['title']  = $holiday->name;
            $events['start']  = date_format($holiday->dateFrom, 'Y-m-d');
            $events['end']    = date_format($holiday->dateFrom, 'Y-m-d');
            $events['allDay'] = FALSE;
            array_push($allevents, $events);
        }
        return $allevents;
    }

}

<?php

namespace Settings\Model;

/**
 * Holiday Model
 * 
 * Handles Holiday Entity related business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @property Utilities\Service\Query\Query $query
 * 
 * @package settings
 * @subpackage model
 */
class Holiday {

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
     * Filter holidays by year
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $year
     * @return array filtered holidays
     */
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
    
    /**
     * List all holidays
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return array holidays ready for display
     */
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

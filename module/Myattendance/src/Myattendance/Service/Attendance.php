<?php

namespace Myattendance\Service;

/**
 * Attendance service
 * 
 * Handles Attendance controller business
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package myattendance
 * @subpackage service
 */
class Attendance {

    /**
     * Group attendances list into lists per each month
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param string $dateFrom
     * @param string $dateTo
     * @param array $list all attendances list
     * @return array attendances ordered by months
     */
    public function groupIntoLists($dateFrom, $dateTo, $list) {
        $result = array();
        //create a list of these dates
        $start = new \DateTime($dateFrom);
        $start->modify('first day of this month');
        $end = new \DateTime($dateTo);
        $end->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);


        foreach ($period as $periodicDateTime) {
            $currentItem = array(
                'counter' => 0,
                'date' => $periodicDateTime->format("Y-F"),
                'list' => $this->fillDateWithRecords($periodicDateTime->format("Y-F"), $list),
            );

            $currentItem['counter'] = sizeof($currentItem['list']);            

            $result[] = $currentItem;
        }

        return $result;
    }

    /**
     * Get current date attendances list
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access private
     * @param string $currentDate month and year only
     * @param array $list all attendances list
     * @return array attendances that belong to currentDate only
     */
    private function fillDateWithRecords($currentDate, $list) {
        $fullList = array();

        foreach ($list as $record) {
            if (date_format($record->timeIn, 'Y-F') == $currentDate) {
                $fullList[] = $record;
            }
        }

        return $fullList;
    }

}

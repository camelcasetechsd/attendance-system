<?php

namespace Myattendance\Service;

class Attendance {

    public function groupIntoLists($dateFrom, $dateTo, $list) {
        $result = array();
        //create a list of these dates
        $start = new \DateTime($dateFrom);
        $start->modify('first day of this month');
        $end = new \DateTime($dateTo);
        $end->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);


        foreach ($period as $dt) {
            $currentItem = array(
                'counter' => 0,
                'date' => $dt->format("Y-F"),
                'list' => $this->fillDateWithRecords($dt->format("Y-F"), $list),
            );

            $currentItem['counter'] = sizeof($currentItem['list']);            

            $result[] = $currentItem;
        }

        return $result;
    }

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

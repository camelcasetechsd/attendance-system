<?php

namespace Myattendance\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Myattendance\Form\FilterByYearForm;
use Zend\Authentication\AuthenticationService;
use Utilities\Service\Time;

/**
 * Attendance Controller
 * 
 * Attendance entries listing for current user
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @package myattendance
 * @subpackage controller
 */
class AttendanceController extends ActionController {

    /**
     * List current user attendance entries
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @uses Time
     * @uses FilterByYearForm
     * @uses AuthenticationService
     * 
     * @access public
     * @return ViewModel
     */
    public function indexAction() {
        $variables = array();

        $query = $this->getServiceLocator()->get('wrapperQuery')->setEntity('Settings\Entity\AttendanceRecord');
        $attendanceModel = $this->getServiceLocator()->get('Myattendance\Model\Attendance');
        $attendanceService = $this->getServiceLocator()->get('Myattendance\Service\Attendance');
        $timeService = new Time();
        $filterForm = new FilterByYearForm();
        $request = $this->getRequest();
        $dateTo = $request->getPost('dateTo');
        $dateFrom = $request->getPost('dateFrom');

        $authenticationService = new AuthenticationService();
        $storage = $authenticationService->getIdentity();
        // get attendance entries for current user
        // filter entries by date if both date to and date after
        if (!empty($dateTo) && !empty($dateFrom) && $request->isPost()) {
            $list = $attendanceModel->filterByYear($dateFrom, $dateTo, $storage['id']);
        } else {
            $list = $query->findBy(/*$entityName =*/null, array('user' => $storage['id']));
        }

        // prepare entries for display as grouped lists
        foreach ($list as $currentRecord) {
            $currentRecord->signInDate = date_format($currentRecord->timeIn, 'Y-m-d');
            $currentRecord->signInTime = date_format($currentRecord->timeIn, 'H:i:s');
            $currentRecord->signOutTime = date_format($currentRecord->timeOut, 'H:i:s');
            $currentRecord->hourDifference = (int) $timeService->hourDifference($currentRecord->signInTime, $currentRecord->signOutTime);
        }
        $groupedList = $attendanceService->groupIntoLists($dateFrom, $dateTo, $list);

        $variables['filterForm'] = $this->getFormView($filterForm);
        $variables['list'] = $groupedList;
        return new ViewModel($variables);
    }

}

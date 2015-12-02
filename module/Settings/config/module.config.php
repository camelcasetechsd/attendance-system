<?php

namespace Settings;

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'aliases' => array(
            'settingsIndex' => 'Settings\Controller\IndexController',
            'settingsVacation' => 'Settings\Controller\VacationController',
            'settingsPosition' => 'Settings\Controller\PositionController',
            'settingsHoliday' => 'Settings\Controller\HolidayController',
            'settingsDepartments' => 'Settings\Controller\DepartmentsController',
            'settingsBranches' => 'Settings\Controller\BranchesController',
            'settingsAttendance' => 'Settings\Controller\AttendanceController',
        ),
        'factories' => array(
            'Settings\Model\Attendance' => 'Settings\Model\AttendanceFactory',
            'Settings\Model\Branches' => 'Settings\Model\BranchesFactory',
            'Settings\Model\Departments' => 'Settings\Model\DepartmentsFactory',
            'Settings\Model\Holiday' => 'Settings\Model\HolidayFactory',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Settings\Controller\Index' => 'Settings\Controller\IndexController',
            'Settings\Controller\Vacation' => 'Settings\Controller\VacationController',
            'Settings\Controller\Position' => 'Settings\Controller\PositionController',
            'Settings\Controller\Holiday' => 'Settings\Controller\HolidayController',
            'Settings\Controller\Departments' => 'Settings\Controller\DepartmentsController',
            'Settings\Controller\Branches' => 'Settings\Controller\BranchesController',
            'Settings\Controller\Attendance' => 'Settings\Controller\AttendanceController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'attendanceEdit' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/attendance/edit/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Attendance',
                        'action' => 'edit',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'attendanceDelete' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/attendance/delete/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Attendance',
                        'action' => 'delete',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'branchesEdit' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/branches/edit/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Branches',
                        'action' => 'edit',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'branchesDelete' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/branches/delete/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Branches',
                        'action' => 'delete',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'departmentsEdit' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/departments/edit/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Departments',
                        'action' => 'edit',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'departmentsDelete' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/departments/delete/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Departments',
                        'action' => 'delete',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'holidayEdit' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/holiday/edit/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Holiday',
                        'action' => 'edit',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'holidayDelete' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/holiday/delete/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Holiday',
                        'action' => 'delete',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'positionEdit' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/position/edit/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Position',
                        'action' => 'edit',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'positionDelete' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/position/delete/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Position',
                        'action' => 'delete',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'vacationEdit' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/vacation/edit/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Vacation',
                        'action' => 'edit',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'vacationDelete' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/settings/vacation/delete/:id',
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Vacation',
                        'action' => 'delete',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'settingsIndex' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /settings the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/settings/index[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the controller.
                     */
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Index',
                        'action' => 'index'
                    ),
                    /*
                      We only want to allow alphanumeric characters
                      with an exception to the dash and underscore.
                     */
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                )
            ),
            'settingsVacation' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /settings the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/settings/vacation[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the controller.
                     */
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Vacation',
                        'action' => 'index'
                    ),
                    /*
                      We only want to allow alphanumeric characters
                      with an exception to the dash and underscore.
                     */
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                )
            ),
            'settingsPosition' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /settings the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/settings/position[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the controller.
                     */
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Position',
                        'action' => 'index'
                    ),
                    /*
                      We only want to allow alphanumeric characters
                      with an exception to the dash and underscore.
                     */
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                )
            ),
            'settingsHoliday' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /settings the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/settings/holiday[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the controller.
                     */
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Holiday',
                        'action' => 'index'
                    ),
                    /*
                      We only want to allow alphanumeric characters
                      with an exception to the dash and underscore.
                     */
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                )
            ),
            'settingsDepartments' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /settings the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/settings/departments[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the controller.
                     */
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Departments',
                        'action' => 'index'
                    ),
                    /*
                      We only want to allow alphanumeric characters
                      with an exception to the dash and underscore.
                     */
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                )
            ),
            'settingsBranches' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /settings the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/settings/branches[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the controller.
                     */
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Branches',
                        'action' => 'index'
                    ),
                    /*
                      We only want to allow alphanumeric characters
                      with an exception to the dash and underscore.
                     */
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                )
            ),
            'settingsAttendance' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /settings the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/settings/attendance[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the controller.
                     */
                    'defaults' => array(
                        'controller' => 'Settings\Controller\Attendance',
                        'action' => 'index'
                    ),
                    /*
                      We only want to allow alphanumeric characters
                      with an exception to the dash and underscore.
                     */
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                )
            ),
        )
    )
);

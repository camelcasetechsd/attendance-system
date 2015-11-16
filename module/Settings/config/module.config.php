<?php

return array(
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

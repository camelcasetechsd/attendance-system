<?php

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'Myattendance\Service\Attendance' => 'Myattendance\Service\Attendance',
        ),
        'factories' => array(
            'Myattendance\Model\Attendance' => 'Myattendance\Model\AttendanceFactory',
            'Myattendance\Model\Vacation' => 'Myattendance\Model\VacationFactory',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Myattendance\Controller\Index' => 'Myattendance\Controller\IndexController',
            'Myattendance\Controller\Attendance' => 'Myattendance\Controller\AttendanceController',
            'Myattendance\Controller\Vacation' => 'Myattendance\Controller\VacationController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'myattendanceIndex' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /myattendance the main end point, with
                      an optional action.
                     */
                    'route' => '/myattendance/index[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action.
                     */
                    'defaults' => array(
                        'controller' => 'Myattendance\Controller\Index',
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
            'myattendanceAttendance' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /myattendance the main end point, with
                      an optional action.
                     */
                    'route' => '/myattendance/attendance[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action.
                     */
                    'defaults' => array(
                        'controller' => 'Myattendance\Controller\Attendance',
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
            'myattendanceVacation' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /myattendance the main end point, with
                      an optional action.
                     */
                    'route' => '/myattendance/vacation[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action.
                     */
                    'defaults' => array(
                        'controller' => 'Myattendance\Controller\Vacation',
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

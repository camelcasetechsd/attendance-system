<?php

namespace Requests;

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'aliases' => array(
            'requestsMyrequests' => 'Requests\Controller\MyrequestsController',
        )
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
            'Requests\Controller\Myrequests' => 'Requests\Controller\MyrequestsController',
            'Requests\Controller\Permission' => 'Requests\Controller\PermissionController',
            'Requests\Controller\Vacation' => 'Requests\Controller\VacationController',
            'Requests\Controller\Workfromhome' => 'Requests\Controller\WorkfromhomeController',
        )
    ),
    'router' => array(
        'routes' => array(
            'requestsMyrequests' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /requests the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/requests/myrequests[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action.
                     */
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Myrequests',
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
            'requestsPermission' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /requests the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/requests/permission[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action.
                     */
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Permission',
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
            'requestsVacation' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /requests the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/requests/vacation[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action.
                     */
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Vacation',
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
            'requestsWorkfromhome' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /requests the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/requests/workfromhome[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action.
                     */
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Workfromhome',
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

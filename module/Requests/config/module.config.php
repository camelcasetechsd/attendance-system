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
        ),
        'factories' => array(
            'Requests\Model\MyRequest' => 'Requests\Model\MyRequestFactory',
            'Requests\Model\Comment' => 'Requests\Model\CommentFactory',
            'Requests\Model\Permission' => 'Requests\Model\PermissionFactory',
            'Requests\Model\WorkFromHome' => 'Requests\Model\WorkFromHomeFactory',
            'Requests\Model\Vacation' => 'Requests\Model\VacationFactory',
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
            'Requests\Controller\Myrequests' => 'Requests\Controller\MyrequestsController',
            'Requests\Controller\Permission' => 'Requests\Controller\PermissionController',
            'Requests\Controller\Vacation' => 'Requests\Controller\VacationController',
            'Requests\Controller\Workfromhome' => 'Requests\Controller\WorkfromhomeController',
        )
    ),
    'router' => array(
        'routes' => array(
            'approveRequestsMyrequests' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/requests/myrequests/approve/:id/:requestType',
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Myrequests',
                        'action' => 'approve',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                        'requestType' => '[a-zA-Z]+',
                    ),
                )
            ),
            'declineRequestsMyrequests' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/requests/myrequests/decline/:id/:requestType',
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Myrequests',
                        'action' => 'decline',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                        'requestType' => '[a-zA-Z]+',
                    ),
                )
            ),
            'cancelRequestsMyrequests' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/requests/myrequests/cancel/:id/:requestType',
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Myrequests',
                        'action' => 'cancel',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                        'requestType' => '[a-zA-Z]+',
                    ),
                )
            ),
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
            'showRequestsPermission' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/requests/permission/show/:id',
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Permission',
                        'action' => 'show',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'deletecommentRequestsPermission' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/requests/permission/deletecomment/:id',
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Permission',
                        'action' => 'deletecomment',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
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
            'showRequestsVacation' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/requests/vacation/show/:id',
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Vacation',
                        'action' => 'show',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'deletecommentRequestsVacation' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/requests/vacation/deletecomment/:id',
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Vacation',
                        'action' => 'deletecomment',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
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
            'showRequestsWorkfromhome' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/requests/workfromhome/show/:id',
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Workfromhome',
                        'action' => 'show',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                )
            ),
            'deletecommentRequestsWorkfromhome' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/requests/workfromhome/deletecomment/:id',
                    'defaults' => array(
                        'controller' => 'Requests\Controller\Workfromhome',
                        'action' => 'deletecomment',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
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

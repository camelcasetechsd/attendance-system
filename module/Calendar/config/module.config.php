<?php

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Calendar\Controller\Index' => 'Calendar\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'calendar' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /calendar the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/calendar[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the index controller.
                     */
                    'defaults' => array(
                        'controller' => 'Calendar\Controller\Index',
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
            )
        )
    )
);

<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Index' => 'Users\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'users' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /users the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/users/index[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the index controller.
                     */
                    'defaults' => array(
                        'controller' => 'Users\Controller\Index',
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

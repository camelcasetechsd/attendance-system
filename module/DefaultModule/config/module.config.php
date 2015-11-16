<?php

return array(
    'view_manager' => array(
        // Create out template mapping
        'template_map' => array(
            'default-module/index/index' => __DIR__ . '/../view/default-module/index/index.phtml',
            'default-module/error/index' => __DIR__ . '/../view/default-module/error/index.phtml',
            'default-module/error/error' => __DIR__ . '/../view/default-module/error/error.phtml',
            'default-module/error/deactivated' => __DIR__ . '/../view/default-module/error/deactivated.phtml',
            'default-module/sign/index' => __DIR__ . '/../view/default-module/sign/index.phtml',
            'default-module/sign/in' => __DIR__ . '/../view/default-module/sign/in.phtml',
            'default-module/sign/out' => __DIR__ . '/../view/default-module/sign/out.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'DefaultModule\Controller\Index' => 'DefaultModule\Controller\IndexController',
            'DefaultModule\Controller\Error' => 'DefaultModule\Controller\ErrorController',
            'DefaultModule\Controller\Sign' => 'DefaultModule\Controller\SignController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'DefaultModule\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'defaultError' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /error the main end point, with
                      an optional action.
                     */
                    'route' => '/error[/:action]',
                    /*
                      We want a default end point (if no
                      action is given) to go to the index action
                      of the error controller.
                     */
                    'defaults' => array(
                        'controller' => 'DefaultModule\Controller\Error',
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
            'defaultSign' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /sign the main end point, with
                      an optional action.
                     */
                    'route' => '/sign[/:action]',
                    /*
                      We want a default end point (if no
                      action is given) to go to the index action
                      of the sign controller.
                     */
                    'defaults' => array(
                        'controller' => 'DefaultModule\Controller\Sign',
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

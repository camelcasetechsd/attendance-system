<?php
namespace Notifications;

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
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
            'Notifications\Controller\Index' => 'Notifications\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'notifications' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    /*
                      We want to make /notifications the main end point, with
                      an optional controller and action.
                     */
                    'route' => '/notifications/index[/:action]',
                    /*
                      We want a default end point (if no controller
                      and action is given) to go to the index action
                      of the index controller.
                     */
                    'defaults' => array(
                        'controller' => 'Notifications\Controller\Index',
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

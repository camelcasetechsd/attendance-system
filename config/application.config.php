<?php
// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
$env = getenv('APPLICATION_ENV');

/**
 * Configuration file generated by ZFTool
 * The previous configuration file is stored in application.config.old
 *
 * @see https://github.com/zendframework/ZFTool
 */
return array(
    'modules' => array(
        'ZendDeveloperTools',
        'DoctrineModule',
        'DoctrineORMModule',
        'Calendar',
        'DefaultModule',
        'Myattendance',
        'Notifications',
        'Requests',
        'Settings',
        'Users',
        'Mustache',
        'CustomMustache',
        'Utilities'
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
        ),
        'config_glob_paths' => array(
            sprintf('config/autoload/{,*.}{global,%s,local}.php', $env)
        )
    )
);

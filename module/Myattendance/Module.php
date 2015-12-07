<?php
namespace Myattendance;

/**
 * Myattendance Module
 * 
 * myattendance module configuration
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package myattendance
 */
class Module
{
    /**
     * Get config array
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return array module configuration array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Get autoloader config array
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return array module autoloader configuration array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
}

<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    const EVENT_REQUEST_PRE = 'event.request.pre';
    const EVENT_REQUEST_POST = 'event.request.post';
    
    /**
     *
     * @var Zend_EventManager_EventManager 
     */
    protected $_events;
 
    /**
     * Constructor
     * Ensure FrontController resource is registered
     * Register all event listeners
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @param  Zend_Application|Zend_Application_Bootstrap_Bootstrapper $application
     * 
     * @throws Zend_Application_Exception Listener need class and path keys to be defined
     * @throws Zend_Application_Exception Listener for class : $class ,at path : $path need to be defined
     */
    public function __construct($application)
    {
        parent::__construct($application);

        $this->registerListeners();
        
    }
    
    /**
     * Register all event listeners
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * @throws Zend_Application_Exception
     */
    public function registerListeners()
    {
        $listeners = Zend_Config_Yaml::decode(file_get_contents(
                                APPLICATION_PATH . '/configs/listeners.yaml'
        ));
        if (is_array($listeners)) {
            foreach ($listeners as $listener) {
                // load listener
                if (!isset($listener["class"]) || !isset($listener["path"])) {
                    throw new Zend_Application_Exception(
                    'Listener need class and path keys to be defined'
                    );
                }
                $class = $listener["class"];
                $path = $listener["path"];
                if (!class_exists($class, false)) {
                    require_once $path;
                    if (!class_exists($class, false)) {
                        throw new Zend_Application_Exception(
                        "Listener for class : $class ,at path : $path need to be defined"
                        );
                    }
                }
            }
            // register listener
            new $class($this->events());
        }    
    }

    /**
     * Get Zend_EventManager_EventManager instance
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @param Zend_EventManager_EventCollection $events default is null
     * @return Zend_EventManager_EventManager
     */
    public function events(Zend_EventManager_EventCollection $events = null)
    {
        if (null !== $events) {
            $this->_events = $events;
        } elseif (null === $this->_events) {
            $this->_events = new Zend_EventManager_EventManager(__CLASS__);
        }
        return $this->_events;
    }

    /**
     * Run the application
     * Checks to see that we have a default controller directory. If not, an exception is thrown.
     * Trigger EVENT_REQUEST_PRE event
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     *
     * @return mixed
     * @throws Zend_Application_Bootstrap_Exception
     */
    public function run()
    {
        $this->events()->trigger(/*$event =*/ self::EVENT_REQUEST_PRE, /*$target =*/ $this);
        $response = parent::run();
        $this->events()->trigger(/*$event =*/ self::EVENT_REQUEST_POST, /*$target =*/ $this);
        return $response;
    }
}


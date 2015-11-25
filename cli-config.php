<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
require_once 'vendor/autoload.php';

require 'init_autoloader.php';

// Create application, bootstrap, and run
$application = Zend\Mvc\Application::init(require 'config/application.config.php');

$entityManager = $application->getServiceManager()->get('entityManager');

return ConsoleRunner::createHelperSet($entityManager);
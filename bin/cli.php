<?php

use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
if (!ini_get('date.timezone')) {
    date_default_timezone_set("UTC");
}
require_once __DIR__ . '/../vendor/autoload.php';
$configFile = __DIR__ . '/../' . 'cli-config.php';
$commandsFile = __DIR__ . '/../' . 'cli-commands.php';
$helperSet = require $configFile;
$commands = require $commandsFile;

if ( ! ($helperSet instanceof HelperSet)) {
    foreach ($GLOBALS as $helperSetCandidate) {
        if ($helperSetCandidate instanceof HelperSet) {
            $helperSet = $helperSetCandidate;
            break;
        }
    }
}

ConsoleRunner::run($helperSet, $commands);
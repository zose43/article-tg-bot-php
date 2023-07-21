<?php

declare(strict_types = 1);

use Bot\Command;
use Dotenv\Dotenv;
use Bot\Processor;
use Bot\EventManager;
use Bot\Client\Client;

require 'vendor/autoload.php';

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();

$cmd = array_slice($argv, 1, 1);
$args = array_slice($argv, 2);
if (empty($cmd)) {
    echo 'Empty argument';
    exit(1);
}

$processor = new Processor();
$eventManager = new EventManager(
    new Command(),
    new Client(getenv('TG_TOKEN'), getenv('TG_API')));
$processor->run($cmd[0], $eventManager, $args);

exit(0);

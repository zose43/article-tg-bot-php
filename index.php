<?php

declare(strict_types = 1);

use Bot\Processor;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(500);
}

$processor = new Processor();
$processor->handleRequest();

exit(0);

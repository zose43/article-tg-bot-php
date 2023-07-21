<?php

declare(strict_types = 1);

use Bot\Processor;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();

$processor = new Processor();
$processor->handleRequest();

exit(0);

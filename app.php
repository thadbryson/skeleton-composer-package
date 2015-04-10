<?php

set_time_limit(0);

require __DIR__.'/vendor/autoload.php';

use TCB\Santa\Command\CreateCommand;
use TCB\Santa\Command\BuildCommand;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Shell;

define('BASE_DIR', __DIR__);

// Setup Application.
$app = new Application('Santa\'s Workshop', 'v2');

// Add commands to Application.
$app->add(new CreateCommand());
$app->add(new BuildCommand());

// Create Shell and add Application to it.
$shell = new Shell($app);

// Run the Workbench.
$shell->run();

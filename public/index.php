<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Load routes
(require __DIR__ . '/../src/Routes/Routes.php')($app);

$app->run();

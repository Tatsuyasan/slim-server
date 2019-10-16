<?php
/**
 * Owners and Renters
 * @version 1.0.0
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

// create container and configure it
$settings = require '../config/settings.php';
$settings = require '../config/dependencies.php';

// create app instance
$app = new App($container);

require '../src/routes/user.php';
require '../src/routes/property.php';
require '../src/routes/login.php';
require '../src/routes/request.php';
$app->run();
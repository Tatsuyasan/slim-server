<?php
/**
 * Owners and Renters
 * @version 1.0.0
 */

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Slim\App;
require '../src/routes/user.php';
$app->run();


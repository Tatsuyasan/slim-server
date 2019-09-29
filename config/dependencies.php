<?php

// DIC configuration
use Slim\Container;
use Slim\PDO\Database;

$container = new Container($settings);

$container['db'] = function ($container) {
    $db = $container->get('settings')['db'];
    $pdo = new Database('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(Database::ATTR_ERRMODE, Database::ERRMODE_EXCEPTION);
    $pdo->setAttribute(Database::ATTR_DEFAULT_FETCH_MODE, Database::FETCH_ASSOC);
    return $pdo;
};
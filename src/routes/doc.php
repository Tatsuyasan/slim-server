<?php


use Slim\Http\Response;
use OpenApi\Serializer;



$app->get('/v2/doc', function ($request, Response $response, $args) {
    $serializer = new Serializer();
    $dir = __DIR__; // Scan Controller folder
    $swagger = OpenApi\scan([$dir]);
    var_dump(json_encode($swagger));
    exit;
    $openapi = $serializer->deserialize($jsonString, 'OpenApi\Annotations\OpenApi');
    echo $openapi->toJson();

//    $dir = __DIR__; // Scan Controller folder
//    $swagger = OpenApi\scan([$dir]);
//    var_dump($swagger);exit;
//    //$response->write($swagger);
//    //$response = $response->withHeader('Content-Type', 'application/json');
//    return $response;
});
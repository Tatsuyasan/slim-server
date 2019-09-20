<?php

/**
 * POST createProperty
 * Summary: Create property
 * Notes:
 * Output-Formats: [application/json]
 */
$app->POST('/v2/property', function ($request, $response, $args) {


    $body = $request->getParsedBody();
    $response->write('How about implementing createProperty as a POST method ?');
    return $response;
});


/**
 * DELETE deleteProperty
 * Summary: Delete property
 * Notes:
 * Output-Formats: [application/json]
 */
$app->DELETE('/v2/property/{userId}', function ($request, $response, $args) {


    $response->write('How about implementing deleteProperty as a DELETE method ?');
    return $response;
});


/**
 * GET getAllPropertyByUserId
 * Summary: Get all property by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/property/{userId}', function ($request, $response, $args) {


    $response->write('How about implementing getAllPropertyByUserId as a GET method ?');
    return $response;
});


/**
 * PUT updatePropertyById
 * Summary: update property
 * Notes:
 * Output-Formats: [application/json]
 */
$app->PUT('/v2/property', function ($request, $response, $args) {


    $body = $request->getParsedBody();
    $response->write('How about implementing updatePropertyById as a PUT method ?');
    return $response;
});


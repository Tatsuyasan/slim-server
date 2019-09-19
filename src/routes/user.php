<?php

/**
 * POST loginUser
 * Summary: Logs user into the system
 * Notes:
 * Output-Formats: [application/json]
 */
$app->POST('/v2/login', function ($request, $response, $args) {


    $body = $request->getParsedBody();
    $response->write('How about implementing loginUser as a POST method ?');
    return $response;
});


/**
 * POST createUser
 * Summary: Create user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->POST('/v2/user', function ($request, $response, $args) {


    $body = $request->getParsedBody();
    $response->write('How about implementing createUser as a POST method ?');
    return $response;
});


/**
 * DELETE deleteUser
 * Summary: Delete user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->DELETE('/v2/user/{id}', function ($request, $response, $args) {


    $response->write('How about implementing deleteUser as a DELETE method ?');
    return $response;
});


/**
 * GET getDashboardInfoById
 * Summary: Get info dashboard by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/user/getDashboardInfoById/{id}', function ($request, $response, $args) {


    $response->write('How about implementing getDashboardInfoById as a GET method ?');
    return $response;
});


/**
 * GET getUserById
 * Summary: Get user by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/user/{id}', function ($request, $response, $args) {


    $response->write('How about implementing getUserById as a GET method ?');
    return $response;
});


/**
 * PUT updateUser
 * Summary: Updated user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->PUT('/v2/user', function ($request, $response, $args) {


    $body = $request->getParsedBody();
    $response->write('How about implementing updateUser as a PUT method ?');
    return $response;
});



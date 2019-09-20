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
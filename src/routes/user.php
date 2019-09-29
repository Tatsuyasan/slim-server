<?php

/**
 * GET getAllRentersOfOwner
 * Summary: get renters by owner id
 * Notes:
 */

use Slim\Http\Request;
use Slim\Http\Response;

$app->GET('/v2/getRentersByOwnerId/{id}', function ($request, $response, $args) {


    $response->write('How about implementing getAllRentersOfOwner as a GET method ?');
    return $response;
});


/**
 * POST createUser
 * Summary: Create user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->POST('/v2/user', function (Request $request, Response $response) {
    try {
        $dataRequest = $request->getParsedBody();
        $insertStatement = $this->db->insert(array_keys($dataRequest))
            ->into('users')
            ->values(array_values($dataRequest));
        $insertId = $insertStatement->execute(true);
        return $response->withJson(['message' => 'User number ' . $insertId . ' is create'], 201);
    } catch (Exception $e) {
        return $response->withJson(['message' => 'An error is occured'], 404);
    }

});


/**
 * DELETE deleteUser
 * Summary: Delete user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->DELETE('/v2/user/{id}', function (Response $response, $args) {
    $deleteStatement = $this->db->delete()
        ->from('users')
        ->where('id', '=', $args['id']);
    $affectedRows = $deleteStatement->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'User is delete'], 200);

    return $response->withJson(['message' => 'An error is occured'], 404);
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
$app->GET('/v2/user/{id}', function (Response $response, $args) {
    $selectStatement = $this->db->select()
        ->from('users')
        ->where('id', '=', $args['id']);
    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    $response = $response->withJson($data);

    if (empty($data))
        return $response->withJson(['message' => 'User not found'], 404);

    return $response;
});


/**
 * PUT updateUser
 * Summary: Updated user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->PUT('/v2/user', function (Request $request, Response $response) {
    $dataRequest = $request->getParsedBody();

    if (!isset($dataRequest['id']))
        return $response->withJson(['message' => 'User\'s ID is required'], 404);

    $updateStatement = $this->db->update($dataRequest)
        ->table('users')
        ->where('id', '=', $dataRequest['id']);
    $affectedRows = $updateStatement->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'User is update'], 200);

    return $response->withJson(['message' => 'User not found or no update data'], 404);
});



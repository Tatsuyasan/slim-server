<?php

/**
 * GET getAllRentersOfOwner
 * Summary: get renters by owner id
 * Notes:
 */

use Slim\Http\Request;
use Slim\Http\Response;

$app->GET('/v2/getRentersByOwnerId/{idOwner}', function ($request, $response, $args) {
    $sth = $this->db->prepare('
SELECT renter.id, renter.firstname, renter.lastname, renter.mail, renter.password, renter.date_creation, renter.date_modification, renter.phone, renter.adress, renter.additional_adress
FROM renter 
JOIN property ON renter.id = property.id_renter
JOIN `owner`  ON property.id = `owner`.id_property
WHERE `owner`.id = :idOwner');
    $sth->bindParam(':idOwner', $args['idOwner'], PDO::PARAM_INT);
    $sth->execute();
    $data = $sth->fetchAll();
    $response = $response->withJson($data);
    if (empty($data))
        return $response->withJson(['message' => 'User not found'], 404);

    return $response;
});


/**
 * POST createUser
 * Summary: Create user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->POST('/v2/owner', function (Request $request, Response $response) {
    try {
        $dataRequest = $request->getParsedBody();
        $insertStatement = $this->db->insert(array_keys($dataRequest))
            ->into('owner')
            ->values(array_values($dataRequest));
        $insertId = $insertStatement->execute(true);
        return $response->withJson(['message' => 'Owner number ' . $insertId . ' is create'], 201);
    } catch (Exception $e) {
        return $response->withJson(['message' => 'An error is occured'], 404);
    }

});

$app->POST('/v2/renter', function (Request $request, Response $response) {
    try {
        $dataRequest = $request->getParsedBody();
        $insertStatement = $this->db->insert(array_keys($dataRequest))
            ->into('renter')
            ->values(array_values($dataRequest));
        $insertId = $insertStatement->execute(true);
        return $response->withJson(['message' => 'Renter number ' . $insertId . ' is create'], 201);
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
$app->DELETE('/v2/owner/{id}', function (Request $request, Response $response, $args) {
    $deleteStatement = $this->db->delete()
        ->from('owner')
        ->where('id', '=', $args['id']);
    $affectedRows = $deleteStatement->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'Owner is delete'], 200);

    return $response->withJson(['message' => 'An error is occured'], 404);
});

/**
 * DELETE deleteUser
 * Summary: Delete user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->DELETE('/v2/renter/{id}', function (Request $request, Response $response, $args) {
    $deleteStatement = $this->db->delete()
        ->from('renter')
        ->where('id', '=', $args['id']);
    $affectedRows = $deleteStatement->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'Renter is delete'], 200);

    return $response->withJson(['message' => 'An error is occured'], 404);
});

/**
 * GET getDashboardInfoById
 * Summary: Get info dashboard by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/user/getDashboardInfoOwnerById/{id}', function (Request $request, Response $response, $args) {


    $response->write('How about implementing getDashboardInfoOwnerById as a GET method ?');
    return $response;
});

/**
 * GET getDashboardInfoById
 * Summary: Get info dashboard by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/user/getDashboardInfoByRenterId/{id}', function (Request $request, Response $response, $args) {


    $response->write('How about implementing getDashboardInfoByRenterId as a GET method ?');
    return $response;
});


/**
 * GET getUserById
 * Summary: Get user by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/owner/{idOwner}', function (Request $request, Response $response, $args) {
    $selectStatement = $this->db->select()
        ->from('owner')
        ->where('id', '=', $args['idOwner']);
    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    $response = $response->withJson($data);

    if (empty($data))
        return $response->withJson(['message' => 'Owner not found'], 404);

    return $response;
});

/**
 * GET getUserById
 * Summary: Get user by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/renter/{id}', function (Request $request, Response $response, $args) {
    $selectStatement = $this->db->select()
        ->from('renter')
        ->where('id', '=', $args['id']);
    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    $response = $response->withJson($data);

    if (empty($data))
        return $response->withJson(['message' => 'Renter not found'], 404);

    return $response;
});


/**
 * PUT updateUser
 * Summary: Updated user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->PUT('/v2/owner', function (Request $request, Response $response, $args) {
    var_dump('toto');exit;
    $dataRequest = $request->getParsedBody();

    if (!isset($dataRequest['id']))
        return $response->withJson(['message' => 'Owner\'s ID is required'], 404);

    $updateStatement = $this->db->update($dataRequest)
        ->table('owner')
        ->where('id', '=', $dataRequest['id']);
    $affectedRows = $updateStatement->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'Owner is update'], 200);

    return $response->withJson(['message' => 'Owner not found or no update data'], 404);
});

/**
 * PUT updateUser
 * Summary: Updated user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->PUT('/v2/renter', function (Request $request, Response $response, $args) {
    $dataRequest = $request->getParsedBody();

    if (!isset($dataRequest['id']))
        return $response->withJson(['message' => 'Renter\'s ID is required'], 404);

    $updateStatement = $this->db->update($dataRequest)
        ->table('renter')
        ->where('id', '=', $dataRequest['id']);
    $affectedRows = $updateStatement->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'Renter is update'], 200);

    return $response->withJson(['message' => 'Renter not found or no update data'], 404);
});


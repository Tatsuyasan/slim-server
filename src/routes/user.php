<?php

/**
 * GET getAllRentersOfOwner
 * Summary: get renters by owner id
 * Notes:
 */

$app->GET('/v2/getRentersByOwnerId/{idOwner}', function ($request, $response, $args) {
    $sth = $this->db->prepare('
SELECT ur.*
FROM `user` u 
JOIN `property` p ON u.id = p.id_owner
JOIN `rent` r ON p.id = r.id_property
JOIN `user` ur ON r.id_renter = ur.id
WHERE ur.type_user = 2 AND p.id_owner = :idOwner');
    $sth->bindParam(':idOwner', $args['idOwner'], PDO::PARAM_INT);
    $sth->execute();
    $data = $sth->fetchAll();
    $response = $response->withJson($data);
    if (empty($data))
        return $response->withJson(['message' => 'User(s) not found'], 404);
    return $response;
});


/**
 * POST createUser
 * Summary: Create user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json]
 */
$app->POST('/v2/user', function ($request, $response) {
    try {
        $dataRequest = $request->getParsedBody();
        $insertStatement = $this->db->insert(array_keys($dataRequest))
            ->into('user')
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
$app->DELETE('/v2/user/{id}', function ($request, $response, $args) {
    $deleteStatement = $this->db->delete()
        ->from('user')
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
$app->GET('/v2/user/{id}', function ($request, $response, $args) {
    $selectStatement = $this->db->select()
        ->from('user')
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
$app->PUT('/v2/user', function ($request, $response) {
    $dataRequest = $request->getParsedBody();

    if (!isset($dataRequest['id']))
        return $response->withJson(['message' => 'User\'s ID is required'], 404);

    $updateStatement = $this->db->update($dataRequest)
        ->table('user')
        ->where('id', '=', $dataRequest['id']);
    $affectedRows = $updateStatement->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'User is update'], 200);

    return $response->withJson(['message' => 'User not found or no update data'], 404);
});



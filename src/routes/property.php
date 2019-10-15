<?php

/**
 * POST createProperty
 * Summary: Create property
 * Notes:
 * Output-Formats: [application/json]
 */
$app->POST('/v2/property', function ($request, $response, $args) {
    try {
        $dataRequest = $request->getParsedBody();
        $insertStatement = $this->db->insert(array_keys($dataRequest))
            ->into('property')
            ->values(array_values($dataRequest));
        $insertId = $insertStatement->execute(true);
        return $response->withJson(['message' => 'Property number ' . $insertId . ' is create'], 201);
    } catch (Exception $e) {
        return $response->withJson(['message' => 'An error is occured'], 404);
    }
});


/**
 * DELETE deleteProperty
 * Summary: Delete property
 * Notes:
 * Output-Formats: [application/json]
 */
$app->DELETE('/v2/property/{id}', function ($request, Response $response, $args) {
    /**
     * Query database table
     *
     * @return Response
     *
     * @SWG\Get(
     *     path="/api/sample",
     *     description="Returns entries in table.",
     *     produces={"application/json"},
     *     tags={"Sample"},
     *     @SWG\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     )
     * )
     */
    //todo : delete property by id property, but don't forget to delete id_renter on property. (may be another routes in user).
    $deleteStatement = $this->db->delete()
        ->from('property')
        ->where('id', '=', $args['id']);
    $affectedRows = $deleteStatement->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'User is delete'], 200);

    return $response->withJson(['message' => 'An error is occured'], 404);
});


/**
 * GET getAllPropertyByUserId
 * Summary: Get all property by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/property/{userId}', function ($request, $response, $args) {
    $sth = $this->db->prepare('
SELECT p.*
FROM `user` u
JOIN `property` p ON u.id = p.id_owner
WHERE p.id_owner = :userId');
    $sth->bindParam(':userId', $args['userId'], PDO::PARAM_INT);
    $sth->execute();
    $data = $sth->fetchAll();
    $response = $response->withJson($data);
    if (empty($data))
        return $response->withJson(['message' => 'User(s) not found'], 404);
    return $response;
});


/**
 * PUT updatePropertyById
 * Summary: update property
 * Notes:
 * Output-Formats: [application/json]
 */
$app->PUT('/v2/property', function ($request, $response, $args) {
    $dataRequest = $request->getParsedBody();

    if (!isset($dataRequest['id']))
        return $response->withJson(['message' => 'Property\'s ID is required'], 404);

    $updateStatement = $this->db->update($dataRequest)
        ->table('property')
        ->where('id', '=', $dataRequest['id']);
    $affectedRows = $updateStatement->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'Property is update'], 200);

    return $response->withJson(['message' => 'Property not found or no update data'], 404);
});


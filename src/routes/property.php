<?php

/**
 * POST createProperty
 * Summary: Create property
 * Notes:
 * Output-Formats: [application/json]
 */

use Slim\Http\Request;
use Slim\Http\Response;

$app->POST('/v2/property', function (Request $request, Response $response, $args) {
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
$app->DELETE('/v2/property/{idOwner}', function (Request $request, Response $response, $args) {

    $sth = $this->db->prepare('
DELETE 
FROM property 
JOIN `owner` ON property.id = `owner`.id_property
WHERE `owner`.id = :idOwner;
'
    );
    $sth->bindParam(':idOwner', $args['idOwner'], PDO::PARAM_INT);
    $affectedRows = $sth->execute();

    $sth = $this->db->prepare('
UPDATE `owner` SET id_property = NULL
 WHERE `owner`.id = :idOwner');
    $sth->bindParam(':idOwner', $args['idOwner']);
    $sth->execute();
    if ($affectedRows)
        return $response->withJson(['message' => 'All property of user is delete'], 200);

    return $response->withJson(['message' => 'An error is occured'], 404);
});


/**
 * GET getAllPropertyByUserId
 * Summary: Get all property by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/property/{idOwner}', function ($request, $response, $args) {
    $sth = $this->db->prepare('
SELECT * FROM property
JOIN `owner` ON property.id = `owner`.id_property
WHERE `owner`.id = :idOwner');
    $sth->bindParam(':idOwner', $args['idOwner']);
    $sth->execute();
    $data = $sth->fetchAll();
    $response = $response->withJson($data);

    if (empty($data))
        return $response->withJson(['message' => 'Owner not found'], 404);

    return $response;
});


/**
 * PUT updatePropertyById
 * Summary: update property
 * Notes:
 * Output-Formats: [application/json]
 */
$app->PUT('/v2/property', function (Request $request, Response $response, $args) {
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


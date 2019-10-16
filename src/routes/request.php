<?php


/**
 * GET getUserById
 * Summary: Get user by user id
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/v2/request/{id}', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    $selectStatement = $this->db->select()
        ->from('request')
        ->where('id_origin', '=', $args['id']);
    $stmt = $selectStatement->execute();
    $data = $stmt->fetchAll();
    $response = $response->withJson($data);
    if (empty($data))
        return $response->withJson(['message' => 'User not found'], 404);

    return $response;
});
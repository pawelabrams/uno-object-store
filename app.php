<?php
/*
 * Uno object store main file and router.
 */

return function ($method, $path, $params, $requestBody) use ($db, $config) {

/** Helpers */

include 'helpers.php';

/** Controllers */

$delete = include 'methods/delete.php';
$get    = include 'methods/get.php';
$list   = include 'methods/list.php';
$patch  = include 'methods/patch.php';
$put    = include 'methods/put.php';

/** Router */

if (in_array($path, $config->listingPaths)) {
    return $list($path, !isset($params['pathsOnly']));
}

try {
    switch ($method) {
        case 'GET':
            $result = $get($path, !isset($params['full']));
            break;

        case 'POST':
        case 'PUT':
            $result = $put($path, $requestBody, isset($params['withStatus']));
            break;

        case 'PATCH':
            $result = $patch($path, $requestBody, isset($params['withStatus']));
            break;

        case 'DELETE':
            $result = $delete($path, isset($params['withStatus']));
            break;

        default:
            throw new Exception('Method not allowed', 405);
    }

    return $result;

} catch (Exception $e) {
    return [
        'error' => ['code' => $e->getCode(), 'message' => $e->getMessage()],
        '_withHeaders' => ['HTTP/1.1 '.error_map($e->getCode() ?? null)],
    ];
}

};

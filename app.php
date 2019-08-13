<?php
/*
 * Uno object store main file and router.
 */

return function ($method, $path, $requestBody) use ($db, $config) {

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
    return $list($path, isset($_GET['full']));
}

try {
    switch ($method) {
        case 'GET':
            $result = $get($path);
            break;

        case 'POST':
        case 'PUT':
            $result = $put($path, $requestBody);
            break;

        case 'PATCH':
            $result = $patch($path, $requestBody);
            break;

        case 'DELETE':
            $result = $delete($path);
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

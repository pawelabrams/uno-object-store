<?php
/*
 * Uno object store main file and router.
 */

/** Config */

$listingPaths = [''];

$path = trim($_SERVER['PATH_INFO'] ?? '', '/');
$data = file_get_contents('php://input');

$db = new \PDO('sqlite:'.dirname(__DIR__).'/data/store.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/** Helpers */

include 'helpers.php';

/** Controllers */

$delete = include 'methods/delete.php';
$get    = include 'methods/get.php';
$list   = include 'methods/list.php';
$patch  = include 'methods/patch.php';
$put    = include 'methods/put.php';

/** Router */

if (in_array($path, $listingPaths)) {
    echo json_encode($list($path, isset($_GET['full'])));
    return;
}

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $result = $get($path);
            break;

        case 'POST':
        case 'PUT':
            $result = $put($path, $data);
            break;

        case 'PATCH':
            $result = $patch($path, $data);
            break;

        case 'DELETE':
            $result = $delete($path);
            break;

        default:
            new Exception('Method not allowed', 405);
    }

    if (empty($result))
        header('HTTP/1.1 204 No content');

    echo json_encode($result);

} catch (Exception $e) {
    header('HTTP/1.1 '.error_map($e->getCode ?? null));

    echo json_encode(['error' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
}

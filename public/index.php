<?php
/*
 * Uno object store entry point.
 */

/** Config */

$config = (object)[
    /** Which paths should be listings, no trailing slashes, eg. category if there are paths like category/1, category/abc etc. */
    'listingPaths' => [''],
];

/** Database path here. Use data/schema.sql to create a store. */
$db = new \PDO('sqlite:'.dirname(__DIR__).'/data/store.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$path = trim($_SERVER['PATH_INFO'] ?? '', '/');
$requestBody = file_get_contents('php://input');

$app = include '../app.php';

$result = $app($_SERVER['REQUEST_METHOD'], $path, $_GET, $requestBody);

if (empty($result))
    header('HTTP/1.1 204 No content');

// TODO: ugly hack. It stays until a decision is made on an envelope or namedtuple implementation
if (isset($result['_withHeaders'])) {
    foreach ($result['_withHeaders'] as $header) header($header);
    unset($result['_withHeaders']);
}

echo json_encode($result);

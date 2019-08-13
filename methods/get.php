<?php

return function ($path, $bare = true) use ($db) {
    $results = [];
    $stmt = $db->prepare("SELECT * FROM store WHERE path = ?");
    $stmt->execute([$path]);

    $obj = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$obj) throw new Exception('Object not found', 404);

    $obj = unpackContents($obj);

    return $bare ? $obj['contents'] : $obj;
};

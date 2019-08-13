<?php

return function ($path) use ($db) {
    $results = [];
    $stmt = $db->prepare("SELECT * FROM store WHERE path = ?");
    $stmt->execute([$path]);

    $obj = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$obj) throw new Exception('Object not found', 404);

    return unpackContents($obj);
};
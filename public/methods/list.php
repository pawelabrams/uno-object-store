<?php

return function ($path, $full = false) use ($db) {
    if (!empty($path)) $path .= '/';

    $results = [];
    $stmt = $db->prepare("SELECT * FROM store WHERE path LIKE ?");
    $stmt->execute(["$path%"]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $results[] = $full ? unpackContents($row) : $row['path'];
    }

    return $results;
};
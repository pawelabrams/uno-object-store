<?php

return function ($path, $contents) use ($db) {
    $update = $db->prepare("UPDATE store SET contents = ? WHERE path = ?");
    $update->execute([$contents, $path]);

    if (($rowCount = $update->rowCount()) > 0) return ['rowCount' => $rowCount];

    $insert = $db->prepare("INSERT INTO store (path, contents) VALUES (?, ?)");
    $insert->execute([$path, $contents]);

    if (($rowCount = $insert->rowCount()) > 0) return ['rowCount' => $rowCount];

    throw new Exception('Path not found and could not be created', 409);
};
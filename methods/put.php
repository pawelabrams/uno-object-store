<?php

return function ($path, $contents, $withStatus = false) use ($db) {
    $update = $db->prepare("UPDATE store SET contents = ? WHERE path = ?");
    $update->execute([$contents, $path]);

    if (($rowCount = $update->rowCount()) > 0) return $withStatus ? ['rowCount' => $rowCount] : null;

    $insert = $db->prepare("INSERT INTO store (path, contents) VALUES (?, ?)");
    $insert->execute([$path, $contents]);

    if (($rowCount = $insert->rowCount()) > 0) return $withStatus ? ['rowCount' => $rowCount] : null;

    throw new Exception('Path not found and could not be created', 409);
};

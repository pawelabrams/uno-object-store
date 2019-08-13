<?php

return function ($path) use ($db) {
    $results = [];
    $stmt = $db->prepare("DELETE FROM store WHERE path = ?");
    $stmt->execute([$path]);

    if ($stmt->rowCount()) return [];

    throw new Exception('Object to be deleted was not found', 404);
};
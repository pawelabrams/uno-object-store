<?php

return function ($path, $withStatus = false) use ($db) {
    $results = [];
    $stmt = $db->prepare("DELETE FROM store WHERE path = ?");
    $stmt->execute([$path]);

    if (($rowCount = $stmt->rowCount()) > 0) return $withStatus ? ['rowCount' => $rowCount] : null;

    throw new Exception('Object to be deleted was not found', 404);
};

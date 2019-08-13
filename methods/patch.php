<?php

return function ($path, $contents, $withStatus = false) use ($db) {
    $stmt = $db->prepare("SELECT * FROM store WHERE path = ? LIMIT 1");
    $stmt->execute([$path]);

    $old = $stmt->fetch(PDO::FETCH_ASSOC);
    $oldContents = $old['contents'];
    $old = unpackContents($old);

    $contents = json_decode($contents, true) ?? $contents;

    if (is_array($contents) && is_array($old['contents']))
        $contents = array_merge($old['contents'], $contents);

    $update = $db->prepare("UPDATE store SET contents = ? WHERE path = ? AND contents = ?");
    $update->execute([json_encode($contents), $path, $oldContents]);

    if (($rowCount = $update->rowCount()) > 0) return $withStatus ? ['rowCount' => $rowCount] : null;

    throw new Exception('Patch was interrupted', 409);
};

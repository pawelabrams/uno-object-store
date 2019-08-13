<?php
/*
 * Helpers for Uno object store
 */

function assoc_map(callable $f, array $a) {
    return array_column(array_map($f, array_keys($a), $a), 1, 0);
}

function error_map($code) {
    switch ($code) {
        case '405': return '405 Method not allowed';
        case '409': return '409 Conflict';
        default: return '400 Bad Request';
    }
}

function unpackContents(array $row) {
    if (array_key_exists('contents', $row)) {
    	$row['contents'] = json_decode($row['contents'], true) ?? $row['contents'];
    }

    return $row;
}

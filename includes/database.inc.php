<?php

function db_num_rows(&$connection, $sql) {
    $sql = "SELECT COUNT(1) AS num_rows FROM (" . $sql . ") AS sub";
    $result = $connection->query($sql);
    $rows = db_get_rows($connection, $sql, null, false);
    return (int) $rows['num_rows'];
}

function db_get_rows(&$connection, $sql, $mode = null, $strict = false) {
    $result = $connection->query($sql);
    if (strtolower($mode) === 'request') {
        $array = array();
        $w = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) :
            foreach ($row as $key => $value) :
                $array[$key . $w] = $value;
            endforeach;
            $w ++;
        endwhile;
        $array['rowsLength'] = $w;
        return $array;
    } else {
        $rows = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) :
            $rows[] = $row;
        endwhile;
        return count($rows) === 1 && $strict === false ? $rows[0] : $rows;
    }
}

function db_valid(&$connection, $sql) {
    $result = $connection->query($sql);
    $rows = $result->fetch(PDO::FETCH_ASSOC);
    return $rows === false || count($rows) === 0 ? false : true;
}

function db_find(&$connection, $table, $field, $value) {
    $sql = "SELECT 1 FROM " . $table . " WHERE " . $field . " = '" . trim($value) . "'";
    return db_valid($connection, $sql);
}

function db_max(&$connection, $table, $field = 'serial') {
    $sql = "SELECT MAX(" . $field . ") AS max FROM " . $table;
    $rows = db_get_rows($connection, $sql);
    return (int) $rows['max'];
}

function db_next(&$connection, $table, $field = 'serial') {
    $sql = "SELECT MAX(" . $field . ") AS max FROM " . $table;
    $rows = db_get_rows($connection, $sql);
    return ((int) $rows['max']) + 1;
}

function db_get_row(&$connection, $table, $where = 'TRUE', $mode = null) {
    $sql = "SELECT * FROM " . $table . " WHERE " . $where;
    $rows = db_get_rows($connection, $sql, $mode);
    return count($rows) === 0 ? array() : $rows;
}

function db_insert(&$connection, $table, $data, $echo = false) {
    $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($data)) . ") VALUES (";
    $values = null;
    foreach ($data as $value) :
        $values .= $values === null ? "'" . $value . "'" : ", '" . $value . "'";
    endforeach;
    $sql .= $values . ")";
    $output = str_replace("''", "NULL", $sql);
    if ($echo === true) {
        echo $output;
    }
    $connection->exec($output);
}

function db_update(&$connection, $table, $set, $where, $echo = false) {
    $sql = "UPDATE " . $table . " SET ";
    $s = 0;
    foreach ($set as $field => $value) :
        $sql .= $s === 0 ? null : ", ";
        $sql .= $field . " = '" . $value . "'";
        $s ++;
    endforeach;
    $sql .= " WHERE ";
    $w = 0;
    foreach ($where as $field => $value) :
        $sql .= $w === 0 ? null : " AND ";
        $sql .= $field . " = '" . $value . "'";
        $w ++;
    endforeach;
    $sql = str_replace("''", "NULL", $sql);
    if ($echo === true) {
        echo $sql;
    }
    $connection->exec($sql);
}

function db_insertorupdate(&$connection, $table, &$data, $field, $value, $echo = false) {
    if (db_find($connection, $table, $field, $value) === true) {
        db_update($connection, $table, $data, array($field => $value), $echo);
        $data['dbAction'] = 'update';
    } else {
        db_insert($connection, $table, $data, $echo);
        $data['dbAction'] = 'insert';
    }
}

function db_delete(&$connection, $table, $where, $echo = false) {
    $sql = "DELETE FROM " . $table . " WHERE " . $where;
    if ($echo === true) {
        echo $sql;
    }
    $connection->exec($sql);
}

function db_login(&$connection, $request, $echo = false) {
    if (!isset($request['email']) || !$request['password']) {
        return false;
    }
    $sql = "SELECT 1 FROM tm_usuariosxx WHERE v_usuaremail = '" . $request['email'] . "' AND v_usuarclave = '" . $request['password'] . "'";
    if ($echo === true) {
        echo $sql;
    }
    return db_valid($connection, $sql);
}

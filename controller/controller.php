<?php
$pdo = new PDO('mysql:host=localhost;dbname=buchladen', 'root', '');

function getTables($pdo) {
    $stmt = $pdo->query("SHOW TABLES");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getTableData($pdo, $table, $search = '', $sort = '') {
    $stmt = $pdo->prepare("DESCRIBE " . $table);
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sql = "SELECT * FROM " . $table;
    if ($search) {
        $searchTerms = [];
        foreach ($columns as $column) {
            $searchTerms[] = "$column LIKE :search";
        }
        $sql .= " WHERE " . implode(' OR ', $searchTerms);
    }

    if ($sort) {
        $sql .= " ORDER BY " . $sort;
    }

    $stmt = $pdo->prepare($sql);
    if ($search) {
        $stmt->bindValue(':search', '%' . $search . '%');
    }
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return ['columns' => $columns, 'rows' => $rows];
}

function getRecord($pdo, $table, $id) {
    $idColumnName = resolveIdColumnName($table);
    $stmt = $pdo->prepare("SELECT * FROM " . $table . " WHERE " . $idColumnName . " = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addRecord($pdo, $table, $data) {
    $columns = array_keys($data);

    $placeholders = array_map(function($col) { return ':' . $col; }, $columns);

    $stmt = $pdo->prepare("INSERT INTO " . $table . " (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")");

    foreach ($data as $column => $value) {
        $stmt->bindValue(':' . $column, $value);
    }

    $stmt->execute();
}

function updateRecord($pdo, $table, $id, $data) {
    $idColumnName = resolveIdColumnName($table);
    $sets = array_map(function($col) use ($idColumnName) {
        if ($col == 'id') {
            return $col . ' = :id';
        }

        return $col . ' = :' . $col;
    }, array_keys($data));

    $stmt = $pdo->prepare("UPDATE " . $table . " SET " . implode(', ', $sets) . " WHERE " . $idColumnName ." = :id");

    foreach ($data as $column => $value) {
        $stmt->bindValue(':' . $column, $value);
    }
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt->execute();
}

function deleteRecord($pdo, $table, $id) {
    $idColumnName = resolveIdColumnName($table);
    $stmt = $pdo->prepare("DELETE FROM " . $table . " WHERE " . $idColumnName . " = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function resolveIdColumnName($table) {
    global $columnName;
    switch ($table) {
        case "buecher_has_sparten":
        case "buecher_has_lieferanten":
            $columnName = "buecher_buecher_id";
            break;
        case "autoren_has_buecher":
            $columnName = "autoren_autoren_id";
            break;
        default:
            $columnName = $table . "_id";
    }

    return $columnName;
}
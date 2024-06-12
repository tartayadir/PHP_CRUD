<?php
$pdo = new PDO('mysql:host=localhost;dbname=buchladen', 'root', '');

function getTables($pdo) {
    $stmt = $pdo->query("SHOW TABLES");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getTableData($pdo, $table) {
    $stmt = $pdo->prepare("DESCRIBE " . $table);
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = $pdo->prepare("SELECT * FROM " . $table);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return ['columns' => $columns, 'rows' => $rows];
}

function getRecord($pdo, $table, $id) {
    $stmt = $pdo->prepare("SELECT * FROM " . $table . " WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addRecord($pdo, $table, $data) {
    $columns = array_keys($data);
    $values = array_values($data);

    $placeholders = array_map(function($col) { return ':' . $col; }, $columns);

    $stmt = $pdo->prepare("INSERT INTO " . $table . " (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")");

    foreach ($data as $column => $value) {
        $stmt->bindValue(':' . $column, $value);
    }

    $stmt->execute();
}

function updateRecord($pdo, $table, $id, $data) {
    $sets = array_map(function($col) { return $col . ' = :' . $col; }, array_keys($data));

    $stmt = $pdo->prepare("UPDATE " . $table . " SET " . implode(', ', $sets) . " WHERE id = :id");

    foreach ($data as $column => $value) {
        $stmt->bindValue(':' . $column, $value);
    }
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt->execute();
}

function deleteRecord($pdo, $table, $id) {
    $stmt = $pdo->prepare("DELETE FROM " . $table . " WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
?>

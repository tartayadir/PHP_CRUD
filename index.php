<?php
require './controller/controller.php';
$tables = getTables($GLOBALS['pdo']);
$selectedTable = isset($_GET['table']) ? $_GET['table'] : $tables[0];
$data = getTableData($GLOBALS['pdo'], $selectedTable);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-5">Database Manager</h1>
    <div class="btn-group mb-3">
        <?php foreach ($tables as $table): ?>
            <a href="?table=<?= $table ?>" class="btn btn-secondary"><?= $table ?></a>
        <?php endforeach; ?>
    </div>
    <a href="crud/add_record.php?table=<?= $selectedTable ?>" class="btn btn-primary mb-3">Add New Record</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <?php foreach ($data['columns'] as $column): ?>
                <th><?= $column ?></th>
            <?php endforeach; ?>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['rows'] as $row): ?>
            <tr>
                <?php foreach ($data['columns'] as $column): ?>
                    <td><?= $row[$column] ?></td>
                <?php endforeach; ?>
                <td><a href="crud/edit_record.php?table=<?= $selectedTable ?>&id=<?= $row['id'] ?>" class="btn btn-warning">Edit</a></td>
                <td><a href="crud/delete_record.php?table=<?= $selectedTable ?>&id=<?= $row['id'] ?>" class="btn btn-danger">Delete</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

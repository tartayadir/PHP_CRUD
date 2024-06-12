<!DOCTYPE html>
<html lang="en">

<?php
require './controller/controller.php';
require './util/pipes.php';

$tables = getTables($GLOBALS['pdo']);
$selectedTable = isset($_GET['table']) ? $_GET['table'] : $tables[0];
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$data = getTableData($GLOBALS['pdo'], $selectedTable, $search, $sort);

require './components/header.php';
require './components/navbar.php';
?>

    <body">
    <div class="container p-3 my-3 border">
        <table class="table table-bordered">
            <thead>
            <tr>
                <?php foreach ($data['columns'] as $column): ?>
                    <th><a href="?table=<?= $selectedTable ?>&sort=<?= $column ?>"><?= normalizeTextView($column) ?></a></th>
                <?php endforeach; ?>
                <th>Bearbeiten</th>
                <th>Löschen</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['rows'] as $row): ?>
                <tr>
                    <?php foreach ($data['columns'] as $column): ?>
                        <td><?= $row[$column] ?></td>
                    <?php endforeach; ?>
                    <td><a href="./crud/edit_record.php?table=<?= $selectedTable ?>&id=<?= array_values($row)[0] ?>" class="btn btn-warning">Bearbeiten</a></td>
                    <td><a href="./crud/delete_record.php?table=<?= $selectedTable ?>&id=<?= array_values($row)[0] ?>" class="btn btn-danger">Löschen</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </body>
    </html>

<?php
require './components/footer.php';
?>

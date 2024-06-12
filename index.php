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
?>
    <body>
    <div class="container">
        <h1 class="mt-5">Database Manager</h1>
        <div class="btn-group mb-3">
            <?php foreach ($tables as $table): ?>
                <a href="?table=<?= $table ?>" class="btn btn-secondary"><?= normalizeTestView($table) ?></a>
            <?php endforeach; ?>
        </div>

        <form method="get" class="mb-3">
            <input type="hidden" name="table" value="<?= $selectedTable ?>">
            <input type="text" name="search" value="<?= $search ?>" placeholder="Search..." class="form-control">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <?php foreach ($data['columns'] as $column): ?>
                    <th><a href="?table=<?= $selectedTable ?>&sort=<?= $column ?>"><?= normalizeTestView($column) ?></a></th>
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
                    <td><a href="./crud/edit_record.php?table=<?= $selectedTable ?>&id=<?= array_values($row)[0] ?>" class="btn btn-warning">Edit</a></td>
                    <td><a href="./crud/delete_record.php?table=<?= $selectedTable ?>&id=<?= array_values($row)[0] ?>" class="btn btn-danger">Delete</a></td>
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

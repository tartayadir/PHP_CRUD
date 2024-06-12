<?php
require '../controller/controller.php';
require '../util/pipes.php';
$selectedTable = $_GET['table'];
$id = $_GET['id'];
$record = getRecord($GLOBALS['pdo'], $selectedTable, $id);
$columns = array_keys($record);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($columns as $column) {
        $data[$column] = $_POST[$column];
    }
    updateRecord($GLOBALS['pdo'], $selectedTable, $id, $data);
    header('Location: ../index.php?table=' . $selectedTable);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Edit Record in <?= $selectedTable ?></h1>
    <form method="post">
        <?php foreach ($columns as $column): ?>
            <div class="form-group">
                <label for="<?= $column ?>"><?= normalizeTestView($column) ?></label>
                <input type="text" class="form-control" id="<?= $column ?>" name="<?= $column ?>" value="<?= $record[$column] ?>" required>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
</body>
</html>

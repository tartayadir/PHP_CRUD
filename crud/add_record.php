<?php
require '../controller/controller.php';
require '../util/pipes.php';
$selectedTable = $_GET['table'];
$columns = getTableData($GLOBALS['pdo'], $selectedTable)['columns'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($columns as $column) {
        $data[$column] = $_POST[$column];
    }
    addRecord($GLOBALS['pdo'], $selectedTable, $data);
    header('Location: ../index.php?table=' . $selectedTable);
    exit;
}

require '../components/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Add Record to <?= $selectedTable ?></h1>
    <form method="post">
        <?php foreach ($columns as $column): ?>
            <div class="form-group">
                <label for="<?= $column ?>"><?= normalizeTestView($column) ?></label>
                <input type="text" class="form-control" id="<?= $column ?>" name="<?= $column ?>" required>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>
</body>
</html>

<?php
require '../components/footer.php';
?>
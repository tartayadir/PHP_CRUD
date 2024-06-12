<?php
$tables = getTables($GLOBALS['pdo']);
$selectedTable = isset($_GET['table']) ? $_GET['table'] : $tables[0];
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$data = getTableData($GLOBALS['pdo'], $selectedTable, $search, $sort);

$currentUrl = $_SERVER['REQUEST_URI'];
$showSearch = strpos($currentUrl, '/crud') === false;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Database Manager</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if ($showSearch): ?>
            <ul class="navbar-nav mr-auto">
                <?php foreach ($tables as $table): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?table=<?= $table ?>"><?= normalizeTextView($table) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="my-2 my-lg-0 mr-sm-2">
                <a href="./crud/add_record.php?table=<?= $selectedTable ?>" class="btn btn-outline-info my-2 my-sm-0">Neuen Datensatz hinzufügen</a>

            </div>

            <form method="get" class="form-inline my-2 my-lg-0">
                <input type="hidden" name="table" value="<?= $selectedTable ?>">
                <input type="text" name="search" value="<?= $search ?>" placeholder="Suchen..."
                       class="form-control mr-sm-2">
                <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Suchen</button>
            </form>
        <?php endif; ?>
    </div>
</nav>
<?php
require '../controller/controller.php';
$selectedTable = $_GET['table'];
$id = $_GET['id'];
deleteRecord($GLOBALS['pdo'], $selectedTable, $id);
header('Location: ../index.php?table=' . $selectedTable);
exit;
?>

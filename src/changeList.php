<?php
$db = new SQLite3("database.db");
$newList = explode("t", $_GET["newListID"])[1];
$task = explode("k", $_GET["taskID"])[1];

$stmt = $db->prepare("UPDATE tasks SET listID = :newList WHERE taskID = :task");
$stmt->bindValue(":newList", $newList, SQLITE3_INTEGER);
$stmt->bindValue(":task", $task, SQLITE3_INTEGER);
$result = $stmt->execute();
?>
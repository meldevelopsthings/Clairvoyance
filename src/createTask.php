<?php
$db = new SQLite3("database.db");

$listID = intval($_GET["listID"]);
$taskName = $_GET["name"];
$date = date("Y-m-d H:i:s");

$stmt = $db->prepare("INSERT INTO tasks (listID, taskName, creationDate) VALUES (:listID, :taskName, :creationDate)");
$stmt->bindValue(":listID", $listID, SQLITE3_INTEGER);
$stmt->bindValue(":taskName", $taskName, SQLITE3_TEXT);
$stmt->bindValue(":creationDate", $date, SQLITE3_TEXT);
$result = $stmt->execute();
?>
<?php
$db = new SQLite3("database.db");
$taskID = intval($_GET["taskID"]);

$stmt = $db->prepare("DELETE FROM tasks WHERE taskID = :taskID");
$stmt->bindValue(":taskID", $taskID, SQLITE3_INTEGER);
$result = $stmt->execute();
?>
<?php
$db = new SQLite3("database.db");
$currentBoardID = intval($_GET["boardID"]);

$stmt = $db->prepare("DELETE FROM boards WHERE boardID = :currentBoardID");
$stmt->bindValue(":currentBoardID", $currentBoardID, SQLITE3_INTEGER);
$result = $stmt->execute();
?>
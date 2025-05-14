<?php
$db = new SQLite3("database.db");
$currentBoardID = intval($_GET["boardID"]);
$list = "newList";

$stmt = $db->prepare("INSERT INTO lists (boardID, listName) VALUES(:boardID, :listName)");
$stmt->bindValue(":boardID", $currentBoardID, SQLITE3_INTEGER);
$stmt->bindValue(":listName", $list, SQLITE3_TEXT);
$result = $stmt->execute();
?>
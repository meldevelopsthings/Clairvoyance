<?php
$db = new SQLite3("database.db");

$boardName = $_GET["name"];
$boardID =  $_GET["boardID"];

$stmt = $db->prepare("UPDATE boards SET boardName = :boardName WHERE boardID = :boardID");
$stmt->bindValue(":boardName", $boardName, SQLITE3_TEXT);
$stmt->bindValue(":boardID", $boardID, SQLITE3_INTEGER);
$result = $stmt->execute();
?>
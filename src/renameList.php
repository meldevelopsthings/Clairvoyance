<?php
$db = new SQLite3("database.db");

$listID = intval($_GET["listID"]);
$listName =$_GET["name"];

$stmt = $db->prepare("UPDATE lists SET listName = :listName WHERE listID = :listID");
$stmt->bindValue(":listName", $listName, SQLITE3_TEXT);
$stmt->bindValue(":listID", $listID, SQLITE3_INTEGER);
$result = $stmt->execute();
?>
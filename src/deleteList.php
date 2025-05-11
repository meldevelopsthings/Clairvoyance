<?php
$db = new SQLite3("database.db");
$listID = intval($_GET["listID"]);

$stmt = $db->prepare("DELETE FROM lists WHERE listID = :listID");
$stmt->bindValue(":listID", $listID, SQLITE3_INTEGER);
$result = $stmt->execute();
?>
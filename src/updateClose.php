<?php
$db = new SQLite3("database.db");
$boardID = $_GET["boardID"];
$date = date("Y-m-d H:i:s");

$stmt = $db->prepare("UPDATE boards SET closeDate = :closeDate WHERE boardID = :boardID");
$stmt->bindValue(":closeDate", $date, SQLITE3_TEXT);
$stmt->bindValue(":boardID", $boardID, SQLITE3_INTEGER);
$result = $stmt->execute();
?>
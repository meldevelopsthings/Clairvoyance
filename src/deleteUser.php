<?php
session_start();
$db = new SQLite3("database.db");
$userID = $_SESSION["userID"];

$stmt = $db->prepare("DELETE FROM userAccounts WHERE userID = :userID");
$stmt->bindValue(":userID", $userID, SQLITE3_INTEGER);
$result = $stmt->execute();
?>
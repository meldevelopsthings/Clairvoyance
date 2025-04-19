<?php
session_start();
$db = new SQLite3("database.db");
$currentUserID = $_SESSION["userID"];

switch ($_SERVER["REQUEST_URI"]) {
    case "/Clairvoyance/src/teams.php":
        // Gets all teams that the currently authenticated user is a part of.
        $stmt = $db->prepare("SELECT * FROM teams WHERE teamID IN (SELECT teamID FROM teamMemberAuth WHERE userID = :userID)");
        $stmt->bindValue(":userID", $currentUserID, SQLITE3_TEXT);
        $result = $stmt->execute();
        $teams = [];

        while ($team = $result->fetchArray(SQLITE3_ASSOC)) {
            $teams[] = $team;
        }
        break;
    case "/Clairvoyance/src/recently-closed.php":

        break;
    case "/Clairvoyance/src/recently-deleted.php":

        break;
    case "/Clairvoyance/src/boards.php":
        // Gets all boards belonging to the currently authenticated user
        $stmt = $db->prepare("SELECT * FROM boards WHERE boardID IN (SELECT boardID FROM boardAuth WHERE userID = :userID)");
        $stmt->bindValue(":userID", $currentUserID, SQLITE3_TEXT);
        $result = $stmt->execute();
        $boards = [];

        while ($board = $result->fetchArray(SQLITE3_ASSOC)) {
            $boards[] = $board;
        }
        break;
}
?>
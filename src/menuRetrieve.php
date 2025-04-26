<?php
session_start();
$db = new SQLite3("database.db");
//REMOVE THIS
$db->enableExceptions(true);
$currentUserID = $_SESSION["userID"];
$url = explode("?",$_SERVER["REQUEST_URI"]);

switch ($url[0]) {
    case "/Clairvoyance/src/teams.php":
        // Gets all teams that the currently authenticated user is a part of.
        $stmt = $db->prepare("SELECT * FROM teams WHERE teamID IN (SELECT teamID FROM teamMemberAuth WHERE userID = :userID)");
        $stmt->bindValue(":userID", $currentUserID, SQLITE3_TEXT);
        $result = $stmt->execute();

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

        while ($board = $result->fetchArray(SQLITE3_ASSOC)) {
            $boards[] = $board;
        }
        break;
    case "/Clairvoyance/src/usingBoard.php":
        // Gets all lists belonging to the currently in use board
        $currentBoardID = $_GET["boardID"];
        $stmt = $db->prepare("SELECT * FROM lists WHERE boardID = :boardID");
        $stmt->bindValue(":boardID", $currentBoardID, SQLITE3_TEXT);
        $result = $stmt->execute();

        while ($list = $result->fetchArray(SQLITE3_ASSOC)) {
            $lists[] = $list;
            $currentListIDs[] = $list["listID"];
        }
        break;
}
?>
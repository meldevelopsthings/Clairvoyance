<?php
session_start();
$db = new SQLite3("database.db");
$currentUserID = $_SESSION["userID"];

// Initially, we run a method to create a new board with just the name and its creation date. Then, we grab the boardID that generates from SQL auto increment and the currently authenticated userID and insert both of those values into the boardAuth table, allowing the user to access that board.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $boardName = $_POST["boardName"];
    $creationDate = date("Y-m-d H:i:s");

    $stmt = $db->prepare("INSERT INTO boards (boardName, creationDate) VALUES (:boardName, :creationDate)");
    $stmt->bindValue(":boardName", $boardName, SQLITE3_TEXT);
    $stmt->bindValue(":creationDate", $creationDate, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($boardName == "") {
        echo 'Board name is required.';
    } else {
        // Then, we grab the boardID that generates from SQL auto increment and the currently authenticated userID and insert both of those values into the boardAuth table, allowing the user to access that board.
        if ($result) {
            $creationID = $db->lastInsertRowID();

            $stmt = $db->prepare("INSERT INTO boardAuth (userID, boardID) VALUES (:userID, :boardID)");
            $stmt->bindValue(":userID", $currentUserID, SQLITE3_TEXT);
            $stmt->bindValue(":boardID", $creationID, SQLITE3_TEXT);
            $stmt->execute();

        }
    }
}
?>
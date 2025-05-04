<?php
session_start();
$db = new SQLite3("database.db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $teamName = $_POST["teamName"];
    $usernamesInvs = array_filter(explode(", ", $_POST["teamUsernames"]));
    
    // OKAY SO NOW YOU NEED TO TAKE THESE USERNAMES, MATCH THEM WITH THEIR ID AND THEN USE THOSE IDS IN THE TEAM CREATION PROCESS BELOW
    
    $stmt0 = $db->prepare("SELECT userID FROM userAccounts WHERE userID = :username");
    $stmt0->bindValue(":username", $usernamesInvs, SQLITE3_TEXT);
    $userIDs = $stmt0->execute();
    


    $stmt = $db->prepare("INSERT INTO teams (teamName) VALUES (:teamName)");
    $stmt->bindValue(":teamName", $teamName, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($teamName == "") {
        echo 'Team name is required.';
    } else {
        if ($result) {
            echo 'Team created successfully.';
        } else {
            echo 'Failed to create team. ' . $db->lastErrorMsg();
        }
    }
}

?>
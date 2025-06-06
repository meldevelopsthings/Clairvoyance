<?php
session_start();
$db = new SQLite3("database.db");
$creationDate = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $teamName = $_POST["teamName"];
    $usernamesInvs = array_filter(explode(", ", $_POST["teamUsernames"]));
    
    if (empty($teamName)) {
        die("Team name is required.");
    }
    
    // After retrieving teamname and user invites, begin transaction to create a new team and invite all usernames provided to the team.
    try {
        $db->exec('BEGIN TRANSACTION');

        $stmt = $db->prepare("INSERT INTO teams (teamName, creationDate) VALUES (:teamName, :creationDate)");
        $stmt->bindValue(":teamName", $teamName, SQLITE3_TEXT);
        $stmt->bindValue(":creationDate", $creationDate, SQLITE3_TEXT);
        $stmt->execute();

        $teamID = $db->lastInsertRowID();

        $userIDs = [$_SESSION["userID"]];  
        $stmt = $db->prepare("SELECT userID FROM userAccounts WHERE username = :username");
        
        foreach ($usernamesInvs as $username) {
            $stmt->bindValue(":username", $username, SQLITE3_TEXT);
            $result = $stmt->execute();
            $row = $result->fetchArray(SQLITE3_ASSOC);
            
            if ($row && isset($row["userID"])) {
                $userIDs[] = (int)$row["userID"];
            }
        }

        $stmt2 = $db->prepare("INSERT INTO teamMemberAuth (userID, teamID) VALUES (:userID, :teamID)");

        foreach ($userIDs as $userID) {
            $stmt2->bindValue("userID", $userID, SQLITE3_INTEGER);
            $stmt2->bindValue("teamID", $teamID, SQLITE3_INTEGER);
            $stmt2->execute();
            $stmt2->reset();
        }

        $db->exec('COMMIT');
    
    } catch (Exception $e) {
        $db->exec("ROLLBACK");
        die('Error: ' . $e->getMessage());
    }
}
?>
<?php
session_start();
$db = new SQLite3("database.db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $teamName = $_POST["teamName"];
    $usernamesInvs = array_filter(explode(", ", $_POST["teamUsernames"]));
    
    if (empty($teamName)) {
        die("Team name is required.");
    }
    
    try {
        $db->exec('BEGIN TRANSACTION');

        $stmt = $db->prepare("INSERT INTO teams (teamName) VALUES (:teamName)");
        $stmt->bindValue(":teamName", $teamName, SQLITE3_TEXT);
        $stmt->execute();

        $teamID = $db->lastInsertRowID();

        $userIDs = [];
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
        echo 'Team created successfully with ' . count($userIDs) . ' members';
    
    } catch (Exception $e) {
        $db->exec("ROLLBACK");
        die('Error: ' . $e->getMessage());
    }
}
?>
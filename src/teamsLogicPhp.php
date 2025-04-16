<?php
$db = new SQLite3("database.db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $teamName = $_POST["teamName"];

    $stmt = $db->prepare('INSERT INTO teams (teamName) VALUES (:teamName)');
    $stmt->bindValue(":teamName", $teamName, SQLITE3_TEXT);

    if ($stmt->execute()) {
        echo 'Team created successfully.';
    } else {
        echo 'Failed to create team.';
    }
}
?>
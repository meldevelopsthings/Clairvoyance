<?php
session_start();
$db = new SQLite3("database.db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $teamName = $_POST["teamName"];
    var_dump($_POST);

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
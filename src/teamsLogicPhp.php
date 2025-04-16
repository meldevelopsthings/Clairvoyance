<?php
$db = new SQLite3("database.db");
$data = file_get_contents("php://input");
$json = json_decode($data, true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $teamName = $_POST["teamName"];

    $stmt = $db->prepare("INSERT INTO teams (teamName) VALUES (:teamName)");
    $stmt->bindValue(":teamName", $teamName, SQLITE3_TEXT);

    if ($stmt->execute()) {
        echo 'Team created successfully.';
    } else {
        echo 'Failed to create team.';
    }
}

if (isset($json["usernames"])) {
    $usernames =$json["usernames"];
    $placeholders = rtrim(str_repeat('?,', count($usernames)), ',');

    $stmt = $db->prepare("SELECT userID FROM userAccounts WHERE username IN ($placeholders)");
    $result = $stmt->execute($usernames);
}
?>
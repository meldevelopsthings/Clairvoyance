<?php
$db = new SQLite3("database.db");
var_dump($_POST);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $firstName = $_POST["firstName"];
    $password = $_POST["password"];
    $confPassword = $_POST["confPassword"];

    if ($password == $confPassword) {
        
    $stmt = $db->prepare("INSERT INTO userAccounts (username, fname, password) VALUES (:username, :firstName, :password)");
    $stmt->bindValue(":username", $username, SQLITE3_TEXT);
    $stmt->bindValue(":firstName", $firstName, SQLITE3_TEXT);
    $stmt->bindValue(":password", $password, SQLITE3_TEXT);
    $result = $stmt->execute();

    echo 'Account created successfully! Try logging in!';

    } else {
        echo 'Passwords not matching.';
    }
}
?>
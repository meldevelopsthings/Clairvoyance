<?php
session_start();
$db = new SQLite3("database.db");

// Retrieve users form inputs and compare them to the database, if successfully found a match, log the user in and set session variables.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    //hash entered password for comparison with hashed one in DB
    $password = md5($_POST["password"]);
    
    $stmt = $db->prepare("SELECT password, userID FROM userAccounts WHERE username = :username");
    $stmt->bindValue(":username", $username, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            
        if ($password === $row["password"]) {

            $_SESSION["username"] = $username;
            $_SESSION["userID"] = $row["userID"];
            echo 'success';
        } else {
            echo 'Invalid password, try again.';
        }
    } else {
        echo 'User not found, try again.';
    }
}
?>
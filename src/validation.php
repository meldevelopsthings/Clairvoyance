<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    try {
        $db = new SQLite3("database.db");

        $stmt = $db->prepare("SELECT password FROM userAccounts WHERE username = :username");
        $stmt->bindValue(":username", $username, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            
            if ($password === $row["password"]) {

                $_SESSION["username"] = $username;
                echo 'success';
            } else {
                echo 'Invalid password';
            }
        } else {
            echo 'User not found';
        }
    } catch (Exeception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
<?php
session_start();
$db = new SQLite3("database.db");

$currentUserID = $_SESSION["userID"];

/* TO ADD: live view of user account info so they know what to change it from.
$stmt = $db->prepare("SELECT fname FROM userAccounts WHERE userID = :userID");
$stmt->bindValue(":userID", $currentUserID, SQLITE3_INTEGER);
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);
echo $user["fname"];
*/

// Code for retireiving form inputs and processing them through the database to run an update command.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['changeUsername'] ?? null;
    $password = $_POST['changePassword'] ?? null;
    $firstName = $_POST['changeFName'] ?? null;
    $currentPassword = $_POST['confPassword'];

    $stmt = $db->prepare("SELECT password FROM userAccounts WHERE userID = :userID");
    $stmt->bindValue(":userID", $currentUserID, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user) {
        if ($currentPassword == $user["password"]) {
            $updateFields = [];
            if ($username) {
                $updateFields[] = 'username = :newUsername';
            }
            if ($password) {
                $updateFields[] = 'password = :newPassword';
            }
            if ($firstName) {
                $updateFields[] = 'fName = :newFName';
        }
        
        if (count($updateFields) > 0) {
            $updateQuery = 'UPDATE userAccounts SET ' . implode(', ', $updateFields) . ' WHERE userID = :userID';
            $stmt = $db->prepare($updateQuery);

            if ($username) {
                $stmt->bindValue(":newUsername", $username, SQLITE3_TEXT);
            }
            if ($password) {
                $stmt->bindValue(":newPassword", $password, SQLITE3_TEXT);
            }
            if ($firstName) {
                $stmt->bindValue(":newFName", $firstName, SQLITE3_TEXT);
            }
            $stmt->bindValue(":userID", $currentUserID, SQLITE3_INTEGER);
            $stmt->execute();
            
            echo '<div class="navclose:pl-[22%] absolute my-160 text-text-500">!User details updated successfully!</div>';
        } else {
            echo '<div class="navclose:pl-[22%] absolute my-160 text-text-500">!No changes were made!</div>';
        }
    } else {
        echo '<div class="navclose:pl-[22%] absolute my-160 text-text-500">!The current password you have entered is incorrect!</div>';
    }
    } else {
        echo '<div class="navclose:pl-[22%] absolute my-160 text-text-500">ERROR</div>';
    }
}
?>
<?php
$db = new SQLite3("database.db");

 // Gets all lists belonging to the currently in use board
$currentBoardID = $_GET["boardID"];
$stmt = $db->prepare("SELECT * FROM lists WHERE boardID = :boardID");
$stmt->bindValue(":boardID", $currentBoardID, SQLITE3_TEXT);
$result = $stmt->execute();

while ($list = $result->fetchArray(SQLITE3_ASSOC)) {
    $lists[] = $list;
    $currentListIDs[] = $list["listID"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <title>board x</title>
</head>
<body>
    <?php
        if ($lists) {
            foreach ($lists as $row) {
                echo '<div class="w-full mt-5 p-4 bg-darker-500 grid grid-cols-2 rounded-full drop-shadow-outer inset-shadow-inner" id="clickedBoard">';
                echo '<p>' . $row["listName"] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p class="mt-10 text-3xl"> You have no lists currently. </p>';
        }
        
        foreach ($currentListIDs as $currentListID) {
            $stmt = $db->prepare("SELECT * FROM tasks WHERE listID = :listID");
            $stmt->bindValue(":listID", $currentListID, SQLITE3_INTEGER);
            $resulttwo = $stmt->execute();

            while ($task = $resulttwo->fetchArray(SQLITE3_ASSOC)) {
                if ($task) {
                    echo $task["listID"] . " ";
                    echo $task["taskName"] . "<br>";
                    $tasks[] = $task;
                }
            }
        }
    ?>
</body>
</html>
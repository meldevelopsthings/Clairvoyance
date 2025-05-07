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
<body class="text-text-500">
    <header class="bg-darker-500 w-full p-8 border-b-3 border-border-500">
        <?php
        echo '<p class="text-3xl">' . $_GET["boardName"] . '</p>';
        ?>
        <input type="button" value="x" class="fixed right-0 mr-4 top-4 text-6xl select-none" onclick="window.location.href = 'boards.php'">
    </header>
    <div class="flex overflow-x-auto gap-4 mt-5 pb-3 pl-4"> 
    <?php
        if ($lists) {
            foreach ($lists as $row) {
                echo '<div class="draggableList w-1/5 p-4 bg-darker-500 rounded-lg drop-shadow-outer inset-shadow-inner" id="list'.$row["listID"].'">';
                echo '<p class="text-center mb-4 text-3xl">' . $row["listName"] . '</p>';

                $currentListID = $row["listID"];
                $stmt = $db->prepare("SELECT * FROM tasks WHERE listID = :listID");
                $stmt->bindValue(":listID", $currentListID, SQLITE3_INTEGER);
                $resulttwo = $stmt->execute();
                

                echo '<div>';
                while ($task = $resulttwo->fetchArray(SQLITE3_ASSOC)) {
                    if ($task) {
                        echo '<div draggable="true" class="draggableTask p-2 mb-2 bg-lighter-500 rounded-full" id="task'.$task["taskID"].'">';
                        echo $task["taskName"];
                        echo '</div>';
                    }
                }
                echo '</div></div>';
            }
        } else {
            echo '<p class="mt-10 text-3xl"> You have no lists currently. </p>';
        }
        echo '</div>';
    ?>
</body>
<script src="boardsLogic.js"></script>
</html>
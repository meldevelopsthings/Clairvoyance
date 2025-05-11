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
<!-- Toolbar for managing transactions between the database. This allows the user to create new lists/tasks and also to delete the board. -->
    <header class="bg-darker-500 w-full p-8 border-b-3 border-border-500 z-10">
        <?php
        echo '<p class="inline-block text-3xl w-fit border-r-3 pr-2 border-border-500">' . $_GET["boardName"] . '</p>';
        ?>
        <input type="button" value="New List" class="inline-block text-xl w-fit border-r-3 pl-1 pr-2 border-border-500" onclick="newList()">
        <input type="button" value="New Task" class="inline-block text-xl w-fit border-r-3 pl-1 pr-2 border-border-500" onclick="">
        <input type="button" value="Delete Board" class="inline-block text-xl w-fit border-r-3 pl-1 pr-2 border-border-500" onclick="deleteWarningOpen()">
        <input type="button" value="×" class="fixed right-0 mr-4 top-3 text-6xl select-none" onclick="window.location.href = 'boards.php'">
    </header>
<!-- Popup warning for deleting the board -->
    <div class="fixed hidden w-full h-full bg-lighter-500 z-20" id="deleteBoardWarning">
        <div class="absolute text-center w-250 top-1/3 left-1/3">
            <p class="text-4xl mb-10">You are about to delete this board, removing all lists and tasks inside of it, would you like to proceed?</p>
            <input class="text-4xl bg-darker-500 rounded-full p-4 mr-20 drop-shadow-outer border-t-1 border-r-1 border-l-1 border-border-500" type="button" value="Yes" onclick="deleteBoard()">
            <input class="text-4xl bg-darker-500 rounded-full p-4 drop-shadow-outer border-t-1 border-r-1 border-l-1 border-border-500" type="button" value="No" onclick="deleteWarningClose()">
        </div>
    </div>
    <div class="flex overflow-x-auto gap-4 mt-5 pb-3 pl-4"> 
    <?php
        if ($lists) {
            foreach ($lists as $row) {
                echo '<div class="taskList w-1/5 p-4 bg-darker-500 rounded-lg drop-shadow-outer inset-shadow-inner" id="list'.$row["listID"].'">';
                echo '<form onsubmit="renameList()" method="GET" class="text-center mb-4">
                        <input type="text" class="text-3xl form-control bg-transparent outline-0 text-center placeholder-text-500" placeholder="' . $row["listName"] . '"name="listName"">
                        <input type="submit" class="hidden">
                        </form>';
                echo '<img src="./img/trash.svg" class="delButton mr-3 fixed top-0 right-0 mt-3" data-list-id="'.$row["listID"].'">';

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
                echo '<form class="p-2 mb-2 bg-lighter-500 rounded-full">';
                echo '<input placeholder="+" type="text" class="createTask text-center text-2xl placeholder-text-500 w-full focus:outline-0">';
                echo '</form>';

                echo '</div></div>';
            }
        } else {
            echo '<p class="mt-10 text-3xl"> You have no lists currently. </p>';
        }
        echo '</div>';
    ?>
    <div id="message"></div>
</body>
<script src="boardsLogic.js"></script>
</html>
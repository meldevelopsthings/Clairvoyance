<?php
session_start();
$db = new SQLite3("database.db");
$currentBoardID = $_GET["boardID"];

// Runs a check that makes it so users must have a valid session at every instance of the application to prevent mishandling
if (!$_SESSION["userID"]){
    header("Location: index.php");
    die();
}

$userID = $_SESSION["userID"];

// Runs an additional check to ensure that the user is authenticated to the board they are trying to access: this prevents a user from entering the url of a board to bypass the menu.
$stmt = $db->prepare("SELECT * FROM boardAuth WHERE userID = :userID AND boardID = :boardID");
$stmt->bindValue(":userID", $userID, SQLITE3_INTEGER);
$stmt->bindValue(":boardID", $currentBoardID, SQLITE3_INTEGER);
$result = $stmt->execute();
$result->fetchArray(SQLITE3_ASSOC);

if (!$result) {
    header("Location: boards.php");
}


 // Gets all lists belonging to the currently in use board
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
    <script type="text/javascript" src="boardsLogic.js"></script>
</head>
<body class="text-text-500">
<!-- Toolbar for managing transactions between the database. This allows the user to create new lists/tasks and also to delete the board. -->
    <header class="bg-darker-500 w-full p-8 border-b-3 border-border-500 z-10">
        <?php
        echo '<input type="text" placeholder="' . $_GET["boardName"] . '" class="inline-block text-3xl w-fit border-r-3 pr-2 placeholder-text-500 outline-0 border-border-500 truncate whitespace-nowrap" onkeydown="if(event.key === `Enter`) renameBoard(this)" data-board-id="' . $_GET["boardID"] . '">';
        ?>
        <input type="button" value="New List" class="inline-block text-xl w-fit border-r-3 pl-1 pr-2 border-border-500" onclick="newList()">
        <input type="button" value="Delete Board" class="inline-block text-xl w-fit border-r-3 pl-1 pr-2 border-border-500" onclick="deleteWarningOpen()">
        <input type="button" value="×" class="fixed right-0 mr-4 top-3 text-6xl select-none" onclick="closeBoard(this)" data-board-id=<?= $_GET['boardID'] ?>>
    </header>
<!-- Popup warning for deleting the board. -->
    <div class="fixed hidden w-full h-full bg-lighter-500 z-20" id="deleteBoardWarning">
        <div class="absolute text-center w-250 top-1/3 left-1/3">
            <p class="text-4xl mb-10">You are about to delete this board, removing all lists and tasks inside of it, would you like to proceed?</p>
            <input class="text-4xl bg-darker-500 rounded-full p-4 mr-20 drop-shadow-outer border-t-1 border-r-1 border-l-1 border-border-500" type="button" value="Yes" onclick="deleteBoard()">
            <input class="text-4xl bg-darker-500 rounded-full p-4 drop-shadow-outer border-t-1 border-r-1 border-l-1 border-border-500" type="button" value="No" onclick="deleteWarningClose()">
        </div>
    </div>
<!-- Display all lists and tasks belonging to a board. -->
    <div class="flex overflow-x-auto gap-4 mt-5 pb-3 pl-4"> 
    <?php
        if ($lists) {
            foreach ($lists as $row) {
                echo '<div class="taskList w-1/5 p-4 bg-darker-500 rounded-lg drop-shadow-outer inset-shadow-inner" id="list'.$row["listID"].'">';
                echo '<input type="text" class="taskListText text-3xl form-control bg-transparent outline-0 text-center placeholder-text-500 mb-2 truncate whitespace-nowrap" placeholder="' . $row["listName"] . '"name="listName"  onkeydown="if(event.key === `Enter`) renameList(this)" data-list-id="' . $row["listID"] . '">';
                echo '<img src="./img/trash.svg" class="delButton mr-3 fixed top-0 right-0 mt-3" data-list-id="' . $row["listID"] . '">';
                
                $currentListID = $row["listID"];
                $stmt = $db->prepare("SELECT * FROM tasks WHERE listID = :listID");
                $stmt->bindValue(":listID", $currentListID, SQLITE3_INTEGER);
                $resulttwo = $stmt->execute();
                

                echo '<div>';
                while ($task = $resulttwo->fetchArray(SQLITE3_ASSOC)) {
                    if ($task) {
                        echo '<div draggable="true" class="draggableTask p-2 mb-2 bg-lighter-500 rounded-full flex items-center justify-between" id="task' . $task["taskID"] . '">';
                        echo '<p class="ml-2 flex-1 truncate whitespace-nowrap min-w-0">' . $task["taskName"] . '</p>';
                        echo '<img src="./img/more.svg" class="moreTask ml-2 shrink-0" data-task-id="' . $task["taskID"] . '" data-task-name="' . $task["taskName"] . '" data-task-desc="' . $task["description"] . '" data-task-date="' . $task["creationDate"] . '" onclick="openTaskMenu(this)">';
                        echo '</div>';
                    }
                }
                echo '<input placeholder="+" type="text" class="createTask p-2 mb-2 bg-lighter-500 rounded-full text-center text-2xl placeholder-text-500 w-full focus:outline-0" onkeydown="if(event.key === `Enter`) createTask(this)" data-list-id="' . $row["listID"] .'">';
                echo '</div></div>';
            }
        } else {
            echo '<p class="mt-10 text-3xl"> You have no lists currently. </p>';
        }
        echo '</div>';
    ?>
    <!-- Menu overlay for editing task information. -->
    <div class="fixed hidden inset-0 bg-stone-800/50 z-50" id="taskMenu">
        <div class="fixed top-[calc(8rem+5%)] left-1/2 transform -translate-x-1/2 max-w-5xl w-full h-3/4 bg-darker-500 rounded-4xl drop-shadow-outer border-border-500 border-t-1 border-r-1 border-l-1">
            <div class="text-center">
                <div class="flex justify-between items-center relative">
                    <img src="./img/trash.svg" class="delTaskButton p-8" onclick="deleteTask(taskID)">
                    <p id="taskMenuHeading" class="text-4xl absolute left-1/2 transform -translate-x-1/2 mt-10"></p>
                </div>
                <p id="taskDesc" class="text-2xl"></p>
                <p id="taskDate" class="text-2xl mb-20 mt-5"></p>
                <button onclick="closeTaskMenu()" class="absolute top-4 right-6 text-6xl">×</button>
            </div>
            <form class="ml-10" id="taskForm">
                <input type="text" placeholder="Task Name" name="taskName" class="bg-inner-500 rounded-full w-100 h-8 drop-shadow-outer insert-shadow-outer placeholder-text-500 mb-10 text-center"><br>
                <input type="text" placeholder="Task Description" name="taskDesc" class="bg-inner-500 rounded-full w-100 h-8 drop-shadow-outer insert-shadow-outer placeholder-text-500 mb-10 text-center"><br>
                <input type="submit" value="Confirm" class="text-2xl bg-darker-500 rounded-full p-4 mr-20 drop-shadow-outer border-t-1 border-r-1 border-l-1 border-border-500">
            </form>
        </div>
    </div>
    <div id="message"></div>
</body>
<script src="boardsLogic.js"></script>
</html>
<?php
include_once 'boardsLogicPhp.php';

// Runs a check that makes it so users must have a valid session at every instance of the application to prevent mishandling
if (!$_SESSION["userID"]){
    header("Location: index.php");
    die();
}

// Gets all boards belonging to the currently authenticated user
$stmt = $db->prepare("SELECT * FROM boards WHERE boardID IN (SELECT boardID FROM boardAuth WHERE userID = :userID)");
$stmt->bindValue(":userID", $currentUserID, SQLITE3_TEXT);
$result = $stmt->execute();

while ($board = $result->fetchArray(SQLITE3_ASSOC)) {
    $boards[] = $board;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <title>All Boards</title>
</head>
<!-- Menu button to toggle siderbar, only for smaller views -->
<button id="navbar-toggle" class="navclose:hidden fixed top-0 right-0 p-3 text-3xl text-text-500 bg-darker-500 rounded-[15px] z-50 transition-all duration-700">
        <img src="./img/menu.svg">
    </button>
<body class="">
<!-- Sidebar code, allows user to navigate the site -->
        <nav id="navbar" class="text-text-500 text-xl bg-darker-500 list-none m-0 p-0 navclose:w-1/5 w-full h-screen fixed overflow-auto border-r-3 border-border-500 flex flex-col transition-transform duration-700 navclose:translate-x-0 -translate-x-full">
        <div class="flex-grow">
        <a href="userSettings.php">
            <li class="flex items-center p-2 border-b-3 border-border-500">
                <img src="./img/avatar.svg" class="mr-2">
                <p class="text-nowrap">User</p>
            </li>
        </a>
        <a href="boards.php">
            <li class="flex items-center p-2">
                <img src="./img/boards.svg" class="mr-2">
                <p class="text-nowrap">All Boards</p>
            </li>
        </a>
        <a href="teams.php">
            <li class="flex items-center p-2 border-b-3 border-border-500">
                <img src="./img/teams.svg" class="mr-2">
                <p class="text-nowrap">All Teams</p>
            </li>
        </a>
        <a href="recentlyClosed.php">
            <li class="flex items-center p-2">
                <img src="./img/recent.svg" class="mr-2">
                <p class="text-nowrap">Recently Closed</p>
            </li>
        </a>
        <a href="recentlyDeleted.php">
            <li class="flex items-center p-2">
                <img src="./img/trash.svg" class="mr-2">
                <p class="text-nowrap">Recently Deleted</p>
            </li>
        </a>
        </div>
        <a href="index.php">
            <li class="flex items-center p-2 border-t-3 border-border-500 w-full">
                <img src="./img/logout.svg" class="mr-2">
                <p class="text-nowrap">Logout</p>
            </li>
        </a>
        </nav>    
    </div>
    <!-- Headers and also where the user can create new boards using the input forms -->
    <main class="navclose:pl-[22%] text-text-500 text-center p-8">
        <h1 class="text-5xl">All Boards</h1>
        <form method="POST" class="w-full mt-10 p-4 bg-darker-500 grid grid-cols-3 rounded-full drop-shadow-outer inset-shadow-inner">
            <input placeholder="Type name here" class="bg-lighter-500 rounded-full text-center placeholder-text-500" type="text" name="boardName">
            <select id="template" name="template" class="bg-lighter-500 border-border-500 text-center min-w-fit rounded-full">
                <option value="template">Select Template</option>
                <option value="default">Default</option>
                <option value="todo">To-do</option>
                <option value="code">Code</option>    
            </select>
            <button type="submit" class="bg-darker-500 rounded-full right-4">
            <p class="inline-block text-nowrap align-middle mr-2">Create New</p>
            <img src="./img/new.svg" class="inline-block align-middle">
        </button>
        </form>

    <!-- Dynamic board display, based on what the user actually has access to -->
        <div class="w-full mt-5 p-4 text-2xl grid grid-cols-3">
            <p>Name</p>
            <p>Last Closed</p>
            <p>Date Created</p>
        </div>
        <?php
            if ($boards) {
                foreach ($boards as $row) {
                    echo '<a href="usingBoard.php?boardID=' . $row["boardID"] . '&boardName='. $row["boardName"] .'">';
                    echo '<div class="w-full mt-5 p-4 bg-darker-500 grid grid-cols-3 rounded-full drop-shadow-outer inset-shadow-inner" id="clickedBoard">';
                    echo '<p class="truncate whitespace-nowrap">' . $row["boardName"] . '</p>';
                    echo '<p>' . $row["closeDate"] . '</p>';
                    echo '<p>' . $row["creationDate"] . '</p>';
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                echo '<p class="mt-10 text-3xl"> You have no boards currently. </p>';
            }
        ?>
    </main>
</body>
<script src="navbar.js"></script>
</html>
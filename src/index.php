<?php
include_once 'validation.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <title>All Boards</title>
</head>
<button id="navbar-toggle" class="navclose:hidden fixed top-1 left-2 p-2 text-3xl text-text-500 z-50 transition-all duration-300">
        <img src="./img/menu.svg">
    </button>
<body class="flex">
<!-- Sidebar code, allows user to navigate the site -->
        <nav id="navbar" class="text-text-500 text-xl bg-darker-500 list-none m-0 p-0 md:w-1/5 min-w-1/5 w-full h-screen fixed overflow-auto border-r-3 border-border-500 flex flex-col transition-transform duration-300 navclose:translate-x-0 -translate-x-full">
        <div class="flex-grow">
        <a href="user-settings.php">
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
        <a href="recently-closed.php">
            <li class="flex items-center p-2">
                <img src="./img/recent.svg" class="mr-2">
                <p class="text-nowrap">Recently Closed</p>
            </li>
        </a>
        <a href="recently-deleted.php">
            <li class="flex items-center p-2">
                <img src="./img/trash.svg" class="mr-2">
                <p class="text-nowrap">Recently Deleted</p>
            </li>
        </a>
        </div>
        <a href="login.php">
            <li class="flex items-center p-2 border-t-3 border-border-500 w-full">
                <img src="./img/logout.svg" class="mr-2">
                <p class="text-nowrap">Logout</p>
            </li>
        </a>
        </nav>    
    </div>
<!-- Main content -->
    <div class="flex-1 ml-1/5 p-4 flex justify-center items-center">
        <h1 class="text-text-500 text-5xl">All Boards</h1>
    </div>
</body>
<script src="navbar.js"></script>
</html>
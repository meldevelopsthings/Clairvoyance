<?php
include_once 'menuRetrieve.php';

// Runs a check that makes it so users must have a valid session at every instance of the application to prevent mishandling
if (!$_SESSION["userID"]){
    header("Location: index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <title>Recently Deleted</title>
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
    <!-- Main Content, should be dynamically updated based on user's recently deleted boards -->
    <main class="navclose:pl-[22%] text-center p-8">
        <h1 class="text-text-500 text-5xl">Recently Deleted</h1>
        <div class="w-full mt-10 p-4 text-2xl text-text-500  grid grid-cols-3">
            <p>Name</p>
            <p>Deleted</p>
            <p>Date Created</p>
        </div>
        <div class="w-full mt-5 p-4 text-text-500 bg-darker-500 grid grid-cols-3 rounded-full drop-shadow-outer inset-shadow-inner">
            <p>uni</p>
            <p>13:51 01/04/2025</p>
            <p>15:00 16/09/2024</p>
        </div>
        <div class="w-full mt-5 p-4 text-text-500 bg-darker-500 grid grid-cols-3 rounded-full drop-shadow-outer inset-shadow-inner">
            <p>group work</p>
            <p>09:45 30/03/2025</p>
            <p>12:00 22/01/2025</p>
        </div>
    </main>
</body>
<script src="navbar.js"></script>
</html>
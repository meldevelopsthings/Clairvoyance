<?php
$db = new SQLite3("./database.db");

$connection = $db->query('SELECT * FROM userAccounts');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <title>Login</title>
    <script src="showPass.js"></script>
</head>
<body>
    <div class="my-30">
        <h1 class="text-text-500 text-6xl w-full lg:w-[65%] m-auto text-center font-default font-bold">Create an account</h1>
    </div>
    <div class="m-auto text-center text-text-500 font-default">
        <form action="./index.php">
            <div class="py-8">
            <label class="text-2xl" for="username">Username:</label><br>
            <input class="bg-inner-500 rounded-full w-100 h-8 text-center drop-shadow-outer insert-shadow-outer" type="text" id="username" required autofocus>
            </div>
            <div class="">
                <label class="text-2xl" for="fname">First Name:</label><br>
                <input class="bg-inner-500 rounded-full w-100 h-8 text-center drop-shadow-outer insert-shadow-outer" type="text" id="fname" required>
            </div>
            <div class="py-8">
            <label class="text-2xl" for="password">Password:</label><br>
            <input class="bg-inner-500 rounded-full w-100 h-8 text-center drop-shadow-outer insert-shadow-outer" type="text" id="password" required><br>
            </div>
            <div>
                <label class="text-2xl" for="confirmPassword">Confirm Password:</label><br>
                <input class="bg-inner-500 rounded-full q-100 h-8 text-center drop-shadow-outer insert-shadow-outer" type="text" id="confPass" required><br>
            </div>
            <div class="py-8">
            <input class="w-65 h-12 text-3xl font-bold bg-inner-500 rounded-full drop-shadow-outer insert-shadow-outer" type="submit" value="Create Account">
            </div>
          </form> 
          <div class="text-2xl block">
            <h4>Already have an account? Login <u><a href="index.php">here</a></u></h4>
          </div>
    </div>
</body>
</html>
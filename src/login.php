<?php
include_once 'validation.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="showPass.js"></script>
    <title>Login</title>
</head>
<body>
    <!-- header -->
    <div class="my-30">
        <h1 class="text-text-500 text-6xl w-full lg:w-[65%] m-auto text-center font-default font-bold">Login to your account</h1>
    </div>
    <!-- login form -->
    <div class="m-auto text-center text-text-500 font-default">
        <form action="validation.php" method="post">
            <div class="py-8">
            <label class="text-2xl" for="username">Username:</label><br>
            <input class="bg-inner-500 border-solid border-3 rounded-2xl border-border-500 w-100 h-8 text-center" type="text" id="username" name="username" required autofocus>
            </div>
            <div>
            <label class="text-2xl" for="password">Password:</label><br>
            <input class="bg-inner-500 border-solid border-3 rounded-2xl border-border-500 w-100 h-8 text-center" type="password" id="password" name="password"required>
            </div>
            <div>
                <input type="checkbox" onclick="showPass()"> Show Password
            </div>
            <div class="py-8">
            <input class="w-30 h-12 text-3xl font-bold bg-inner-500 border-solid border-3 rounded-3xl border-border-500" type="submit" value="Login">
            </div>
          </form> 
          <div class="text-2xl">
            <h4>No account? Register <u><a href="registration.php">here</a></u></h4>
          </div>
    </div>
</body>
</html>
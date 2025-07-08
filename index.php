<?php
require_once "php/cookies.php";
session_start();
require_once("php/functions.php");

// If user is already logged in, redirect them to the dashboard
if (isset($_SESSION['userID'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Egg Counter</title>
    <meta name="description" content="A simple app to count eggs.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css?v=<?= $css_version?>">
</head>

<body>
    <header>
    </header>

    <main>
        <h1>An EGGcellent counting app</h1>
        <div class="tab">
            <button class="tablinks" onclick="openForm(event, 'Log in')" id="defaultOpen">Log in</button>
            <button class="tablinks" onclick="openForm(event, 'Sign up')">Sign up</button>
        </div>

        <div id="Log in" class="tabcontent">
            <form id="loginForm" method="POST" action="authenticate.php">
                <div class="form-group">
                    <label for="loginUsername">Username</label>
                    <input id="loginUsername" name="username" type="text" required onblur="validateUsername(this)">
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input id="loginPassword" name="password" type="password" required onblur="validatePassword(this)">
                </div>
                <input type="submit" value="Log In" class="btn" name="loginSubmit">
                <div id="loginErrorMessage" class="error-message"></div>
            </form>
        </div>

        <div id="Sign up" class="tabcontent">
            <form id="signupForm" method="POST" action="authenticate.php">
                <div class="form-group">
                    <label for="signupUsername">Username</label>
                    <input id="signupUsername" name="username" type="text" required onblur="validateUsername(this)">
                </div>
                <div class="form-group">
                    <label for="signupPassword">Password</label>
                    <input id="signupPassword" name="password" type="password" required onblur="validatePassword(this)">
                </div>
                <div class="form-group">
                    <label for="signupEmail">Email</label>
                    <input id="signupEmail" name="email" type="email" required>          
                </div>
                <input type="submit" value="Sign Up" class="btn" name="SignupSubmit">
                <div id="signupErrorMessage" class="error-message"></div>
            </form>
        </div>
    </main>

    <footer>

    </footer>

    <script src="main.js" async defer></script>
</body>

</html>
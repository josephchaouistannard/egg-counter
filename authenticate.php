<?php
require_once "php/cookies.php";
session_start();
include("php/functions.php");

// If user is already logged in, redirect them to a dashboard or home page
if (isset($_SESSION['userID'])) {
    header("Location: dashboard.php"); // Or whatever your main authenticated page is
    exit;
}

// Check form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // If login submitted
    if (isset($_POST["loginSubmit"])) {
        if (isset($_POST['username'])) {
            $username = trim(htmlspecialchars($_POST["username"]));
        }
        if (isset($_POST['password'])) {
            $plainPassword = trim(htmlspecialchars($_POST["password"]));
        }

        $authenticatedUser = checkPassword($username, $plainPassword);

        if ($authenticatedUser !== false) {
            session_regenerate_id(true);
            $_SESSION["userID"] = $authenticatedUser["id"];
            $_SESSION["username"] = $authenticatedUser["data"]["username"];
            header("Location: dashboard.php");
            exit;

        }
    }
    // Else if sign up submitted
    elseif (isset($_POST["signupSubmit"])) {
        if (isset($_POST['username'])) {
            $username = trim(htmlspecialchars($_POST["username"]));
        }
        if (isset($_POST['password'])) {
            $plainPassword = trim(htmlspecialchars($_POST["password"]));
        }
        if (isset($_POST['email'])) {
            $email = trim(htmlspecialchars($_POST["email"]));
        }
    }
}
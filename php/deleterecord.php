<?php
require_once "cookies.php";
session_start();
require_once "functions.php";

if (!isset($_SESSION["userID"])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_SESSION["userID"];
    $recordID = $_POST["recordID"];

    $eggRecords = getEggRecordsUser($userID);

    // Call the modified addEggRecord function
    $success = deleteEggRecord($userID, $recordID);

    if ($success) {
        header("Location: ../dashboard.php");
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add record"]);
    }

} else {
    // Handle non-POST requests
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
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

    $eggRecords = getEggRecordsUser($userID);

    // Determine the next record ID
    $recordID = 1; // Default ID if no records exist
    if (!empty($eggRecords)) {
        // Find the maximum existing ID and add 1
        $maxID = 0;
        foreach ($eggRecords as $existingRecord) {
            if (isset($existingRecord["id"]) && $existingRecord["id"] > $maxID) {
                $maxID = $existingRecord["id"];
            }
        }
        $recordID = $maxID + 1;
    }

    $quantity = intval($_POST["quantity"] ?? 0);
    $notes = "";
    $Date = new DateTime('now', new DateTimeZone('UTC'));
    $Date = $Date->format('Y-m-d\TH:i:s\Z');

    $record = [
        "id" => $recordID,
        "quantity" => $quantity,
        "notes" => $notes,
        "recordedAt" => $Date
    ];

    // Call the modified addEggRecord function
    $success = addEggRecord($userID, $record);

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
// No closing ?> tag
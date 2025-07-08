<?php
require_once "config.php";
require_once "dbmanager.php";
$dbaccess = new dbManager();
$all_data = $dbaccess->readJSON();

function findUser($username)
{
    global $all_data;
    // Iterate through the users array (which is now associative with ID keys)
    foreach ($all_data['users'] as $userID => $user) {
        if ($user["username"] === $username) {
            // Return an array containing the user ID and the user data
            return ['id' => $userID, 'data' => $user];
        }
    }

    // User not found
    return false;
}

function checkPassword($username, $plain_password)
{
    $user_result = findUser($username);
    if (isset($user_result)) {
        if (password_verify($plain_password, $user_result['data']["passwordHash"])) {
            return $user_result;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function addEggRecord($userID, $record)
{
    global $all_data;
    global $dbaccess; // Access the global dbaccess object

    // Find the user by ID
    if (isset($all_data['users'][$userID])) {
        // Append the new record to the existing egg_records array
        $all_data['users'][$userID]['egg_records'][] = $record;

        // Save the updated data back to the JSON file
        $dbaccess->writeJSON($all_data);

        return true; // Indicate success
    } else {
        // Handle case where user ID doesn't exist
        error_log("Attempted to add egg record for non-existent user ID: " . $userID);
        return false; // Indicate failure
    }
}

function getEggRecordsUser($userID)
{
    global $all_data;
    return $all_data['users'][$userID]['egg_records'];
}

function countEggs($usersEggRecords)
{
    $eggsToday = 0;
    $eggsWeek = 0;
    $eggsMonth = 0;
    $eggsYear = 0;
    $now = new Datetime();
    $todayStart = (clone $now)->setTime(0, 0, 0);
    $last7DaysStart = (clone $now)->setTime(0, 0, 0)->modify('-7 days');
    $last30DaysStart = (clone $now)->setTime(0, 0, 0)->modify('-30 days');
    $last365DaysStart = (clone $now)->setTime(0, 0, 0)->modify('-365 days');
    foreach ($usersEggRecords as $record) {
        $recordDate = new DateTime($record["recordedAt"]);
        $recordDayStart = (clone $recordDate)->setTime(0, 0, 0);
        if ($recordDayStart->format('Y-m-d') === $todayStart->format('Y-m-d')) {
            $eggsToday += $record["quantity"];
        }
        if ($recordDayStart < $todayStart and $recordDayStart >= $last7DaysStart) {
            $eggsWeek += $record["quantity"];
        }
        if ($recordDayStart < $todayStart and $recordDayStart >= $last30DaysStart) {
            $eggsMonth += $record["quantity"];
        }
        if ($recordDayStart < $todayStart and $recordDayStart >= $last365DaysStart) {
            $eggsYear += $record["quantity"];
        }
    }
    return ["today" => $eggsToday, "week" => $eggsWeek, "month" => $eggsMonth, "year" => $eggsYear];
}

function getEggCountHTML($usersEggRecords)
{
    $count = countEggs($usersEggRecords);
    return "
    <p>Today: {$count['today']}</p>
    <p>7 days: {$count['week']} <i>(" . round($count['week'] / 7, 2) . ")</i></p>
    <p>30 days: {$count['month']} <i>(" . round($count['month'] / 30, 2) . ")</i></p>
    <p>1 year: {$count['year']} <i>(" . round($count['year'] / 365, 2) . ")</i></p>
    ";
}

function printEggRecordList($usersEggRecords)
{
    usort($usersEggRecords, function ($a, $b) {
        return strtotime($b['recordedAt']) <=> strtotime($a['recordedAt']);
    });
    $all_string = '<div class="egg-record-list">';
    foreach ($usersEggRecords as $record) {
        $date = new DateTime($record['recordedAt']);
        $string = '<p><strong>' . $date->format('H:i, j F') . '</strong> - ' . $record['quantity'] . ' eggs</p>';
        $all_string = $all_string . $string;
    }
    return $all_string . '</div>';
}
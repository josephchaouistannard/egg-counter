<?php
require_once "php/cookies.php";
session_start();
require_once "php/functions.php";

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["userID"])) {
    header("Location: index.php"); // Or your login page
    exit;
}

// $eggAccess = new EggAccess($_SESSION["userID"]);

// User is logged in, you can now access their session data
$userID = $_SESSION["userID"];
$username = $_SESSION["username"]; // Assuming you stored it

// var_dump($eggAccess->getUserRecords());
$usersEggRecords = getEggRecordsUser($userID);

function refreshEggRecords()
{
    global $usersEggRecords, $eggAccess;
    $usersEggRecords = $eggAccess->getUserRecords();
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
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <nav>
            <a href="logout.php">Log out</a>
        </nav>
    </header>

    <main>
        <h1>Welcome, <?= $username ?>!</h1>
        <div>
            <h5>Egg Production</h5>
            <div id="eggCount">
                <?= getEggCountHTML($usersEggRecords) ?>
            </div>
        </div>
        <div>
            <h5>Record Eggs</h5>
            <form method="POST" action="php/submitrecord.php">
                <div id="recorder">
                    <div id="-" onclick="incrementCounter('-')">-</div>
                    <h3 id="recorderCount">0</h3>
                    <div id="+" onclick="incrementCounter('+')">+</div>
                </div>
                <input type="text" name="notes" placeholder="one egg with two yolks...">
                <input type="hidden" id="quantityInput" name="quantity" value="0">
                <input type="submit" id="submitRecord" value="Save">
            </form>
        </div>

        <?php echo printEggRecordList($usersEggRecords) ?>

    </main>

    <footer>

    </footer>

    <script src="main.js" async defer></script>
</body>

</html>
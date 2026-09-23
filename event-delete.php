<?php

session_start();



if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}

require_once "included/connection.php";
/** @var mysqli $db */
$id = mysqli_escape_string($db, $_GET['id']);

$query = "SELECT * FROM events  WHERE id=$id";
$results = mysqli_query($db, $query);

$events = mysqli_fetch_assoc($results);


if (isset($_GET['continue'])) {
    $query = "DELETE  FROM events WHERE id=$id";
    $results = mysqli_query($db, $query);

    mysqli_close($db);
    header('Location:calendar.php');

    exit;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
                
    <title>delete-event</title>
</head>
<body>
    
<div>
    <h1>Are you sure you want to delete this event: <?= htmlentities($events['name']) ?>?</h1>
    <a href="event-delete.php?id=<?= $id ?>&continue">Yes, delete!</a>
    <a href="event.php?id=<?= $id ?>">No</a>
</div>
</body>
</html>
<?php
session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}
require_once "included/connection.php";

/** @var mysqli $db */
$id = (int)($_GET['id'] ?? 0);

$query = "SELECT events.*, users.username 
          FROM events 
          JOIN users ON events.user_id = users.id 
          WHERE events.id = $id";
$result = mysqli_query($db, $query);
$event = mysqli_fetch_assoc($result);

if (!$event) {
    die("Event niet gevonden");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['name']) ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/event.css">

</head>
<body>
    <?php require_once "components/nav.php"; ?>
    <header>
            <a href="/calendar.php">
                <span>↫</span>
            </a>
            <h1><?= htmlspecialchars($event['name']) ?></h1>
        </header>
    <main>
    <div class="info">
    <p>Organizer: <?= htmlspecialchars($event['username']) ?></p>
    <p>Date: <?= htmlentities(date('d-m-Y H:i', strtotime($event['date']))); ?></td>
    <p>Description:<br><?= $event['description'] ?></p>
    </div>

    <a class= "button" href="event-delete.php?id=<?= htmlentities($event['id']) ?>">Delete</a>
    <a class= "button" href="event-edit.php?id=<?= htmlentities($event['id']) ?>">edit</a>
    </main>


<?php require_once "components/footer.php"; ?>
</body>
</html>
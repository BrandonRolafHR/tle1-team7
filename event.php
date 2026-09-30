<?php
session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}
require_once "included/connection.php";
require_once "included/functions.php";

/** @var mysqli $db */
$userId  = (int)$_SESSION['loggedInUser']['id'];
$eventId = (int)($_GET['id'] ?? 0);

$event = getVisibleEvent($db, $eventId, $userId);
if (!$event) {
    die("Event niet gevonden");
}
// $query = "SELECT events.*, users.username 
//           FROM events 
//           JOIN users ON events.user_id = users.id 
//           WHERE events.id = $id";
// $result = mysqli_query($db, $query);
// $event = mysqli_fetch_assoc($result);

// Doet deze gebruiker al mee?
$stmt = mysqli_prepare($db, "SELECT 1 FROM user_event WHERE user_id = ? AND event_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $userId, $eventId);
mysqli_stmt_execute($stmt);
$isJoined = mysqli_stmt_get_result($stmt)->num_rows > 0;

// Is dit mijn eigen event?
$isOwner = ($event['user_id'] == $userId);

// Wie doen er mee?
$stmt = mysqli_prepare($db,
    "SELECT users.username
     FROM user_event
     JOIN users ON user_event.user_id = users.id
     WHERE user_event.event_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $eventId);
mysqli_stmt_execute($stmt);
$participants = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);


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
    <p>Date: <?= htmlentities(date('d-m-Y H:i', strtotime($event['date']))); ?></p>
    <p>Description:<br><?= $event['description'] ?></p>
    </div>

    <?php if (!$isOwner): ?>
        <form action="/join-event.php" method="POST">
            <input type="hidden" name="event_id" value="<?= (int)$event['id'] ?>">
            <?php if ($isJoined): ?>
                <button class="button" type="submit" name="action" value="leave">Afmelden</button>
            <?php else: ?>
                <button class="button" type="submit" name="action" value="join">Deelnemen</button>
            <?php endif; ?>
        </form>
    <?php endif; ?>
    
        <h2>Deelnemers</h2>
        <?php if (empty($participants)): ?>
           <br> <p>Nog niemand.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($participants as $p): ?>
                    <li><?= htmlspecialchars($p['username']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($isOwner): ?>
           <br> <a class="button" href="event-delete.php?id=<?= (int)$event['id'] ?>">Delete</a>
            <a class="button" href="event-edit.php?id=<?= (int)$event['id'] ?>">edit</a>
        <?php endif; ?>
    </main>


<?php require_once "components/footer.php"; ?>
</body>
</html>
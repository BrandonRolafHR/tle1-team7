<?php
session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: Register/login.php');
    exit;
}

require_once "included/connection.php";
require_once "included/functions.php";
/** @var mysqli $db */

$userId = (int)$_SESSION['loggedInUser']['id'];

/* Events die ik mag zien, niet van mezelf, en waar ik nog niet bij zit */
$sql = "SELECT events.*, users.username
        FROM events
        JOIN users ON events.user_id = users.id
        WHERE events.user_id != ?
          AND events.id NOT IN (
                SELECT event_id FROM user_event WHERE user_id = ?
          )
          AND (
                events.visibility = 'everyone'
                OR (events.visibility = 'friends' AND events.user_id IN (
                    SELECT friend_id FROM friends WHERE user_id = ?
                    UNION
                    SELECT user_id FROM friends WHERE friend_id = ?
                ))
          )
        ORDER BY events.date ASC";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, 'iiii', $userId, $userId, $userId, $userId);
mysqli_stmt_execute($stmt);
$discoverEvents = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ontdekken</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/calendar.css">
</head>
<?php $activePage = 'discover'; ?>
<body>
<?php require_once "components/nav.php"; ?>

<main>
    <h1>Evenementen ontdekken</h1>

    <div class="events-table">
        <table>
            
            <?php if (empty($discoverEvents)): ?>
                <tr><td colspan="4">Geen nieuwe events om te ontdekken.</td></tr>
            <?php else: ?>
                <?php foreach ($discoverEvents as $event): ?>
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Organizer</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="event.php?id=<?= (int)$event['id'] ?>"><?= htmlentities($event['name']) ?></a></td>
                        <td><?= htmlentities($event['username']) ?></td>
                        <td><?= htmlentities(date('d-m-Y H:i', strtotime($event['date']))) ?></td>
                        <td>
                            <form action="/join-event.php" method="POST">
                                <input type="hidden" name="event_id" value="<?= (int)$event['id'] ?>">
                                <button class="button" type="submit" name="action" value="join">Deelnemen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<?php require_once "components/footer.php"; ?>
</body>
</html>
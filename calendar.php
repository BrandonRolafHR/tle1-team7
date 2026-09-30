<?php
session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: Register/login.php');
    exit;
}


require_once "included/connection.php";
require_once "included/functions.php";

/** @var mysqli $db */
if ($db->connect_error) {
    die("Database fout");
}

$userId = (int)$_SESSION['loggedInUser']['id'];

/* ===== Maand & jaar ===== */
$month = (int)($_GET['month'] ?? date('m'));
$year  = (int)($_GET['year'] ?? date('Y'));

$daysInMonth  = getDaysInMonth($year, $month);
$firstWeekDay = getFirstWeekDay($year, $month);
$monthName    = getMonthName($month);

[$prevMonth, $prevYear] = getPreviousMonth($month, $year);
[$nextMonth, $nextYear] = getNextMonth($month, $year);

/* ===== Reserveringen vooraf ophalen ===== */
// $eventsByDate = [];
// for ($day = 1; $day <= $daysInMonth; $day++) {
//     $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
//   $query = "SELECT events.*, users.username 
//           FROM events 
//           JOIN users ON events.user_id = users.id 
//           WHERE DATE(events.date) = '$date'";
//     $results = mysqli_query($db, $query);
//     $eventsByDate[$date] = mysqli_fetch_all($results, MYSQLI_ASSOC);
// }
// /* ===== Alle events ophalen voor de lijst ===== */
// $allEventsQuery = "SELECT events.*, users.username 
//                     FROM events 
//                     JOIN users ON events.user_id = users.id 
//                     ORDER BY events.date ASC";
// $allEventsResult = mysqli_query($db, $allEventsQuery);
// $allEvents = mysqli_fetch_all($allEventsResult, MYSQLI_ASSOC);
// mysqli_close($db);

// $sql = "SELECT events.*, users.username
//         FROM events
//         JOIN users ON events.user_id = users.id
//         WHERE events.user_id = ?
//            OR events.visibility = 'everyone'
//            OR (events.visibility = 'friends' AND events.user_id IN (
//                 SELECT friend_id FROM friends WHERE user_id = ?
//                 UNION
//                 SELECT user_id FROM friends WHERE friend_id = ?
//            ))
//         ORDER BY events.date ASC";
// $stmt = mysqli_prepare($db, $sql);
// mysqli_stmt_bind_param($stmt, 'iii', $userId, $userId, $userId);
// mysqli_stmt_execute($stmt);
// $allEvents = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

$sql = "SELECT events.*, users.username
        FROM events
        JOIN users ON events.user_id = users.id
        WHERE events.user_id = ?
           OR events.id IN (
                SELECT event_id FROM user_event WHERE user_id = ?
           )
        ORDER BY events.date ASC";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $userId, $userId);
mysqli_stmt_execute($stmt);
$allEvents = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
/* ===== Groeperen per datum voor de kalender ===== */
$eventsByDate = [];
foreach ($allEvents as $event) {
    $eventsByDate[substr($event['date'], 0, 10)][] = $event;
}

mysqli_close($db);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>calendar</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.gif"> 
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/calendar.css">
</head>
<?php $activePage = 'calendar'; ?>
<body>
<?php require_once "components/nav.php"; ?>

<main >
    <div class="websiteContainer">
        <header>
     <h1>Calendar</h1>
        </header>
<div class="agenda__header">
            <a class="agenda__button" href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>">←</a>
            <h2 class="agenda__title"><?= $monthName ?> <?= $year ?></h2>
            <a class="agenda__button" href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>">→</a>
        </div>
    
        <table class="table">
            <tr>
                <th>Ma</th><th>Di</th><th>Wo</th><th>Do</th>
                <th>Vr</th><th>Za</th><th>Zo</th>
            </tr>
            <tr>
                <?php for ($i = 0; $i < $firstWeekDay; $i++): ?>
                    <td></td>
                <?php endfor; ?>

                <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>
                <?php
                $currentDate = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                ?>
                <td class="table dates">
                    <strong><?= $day ?></strong><br>
                  <?php foreach ($eventsByDate[$currentDate] ?? [] as $event): ?>
                    <a href="/event.php?id=<?= (int)$event['id'] ?>">
                        <?= htmlentities($event['username']) ?><br>
                        <?= htmlentities($event['name']) ?><br>
                    </a>
                    <?php endforeach; ?>  
                </td>

                <?php if ((($day + $firstWeekDay) % 7) == 0): ?>
            </tr><tr>
                <?php endif; ?>
                <?php endfor; ?>
            </tr>
        </table>

        <div class="joinBox">
            <a href="discover-event.php" class="eventButton">Join new events</a>
        </div>

            <div class="events">
            <h2>Alle events</h2>
       <div class="events-table">
    <table>
        <?php if (empty($allEvents)): ?>
            <tr><td colspan="4">Geen nieuwe events om te ontdekken.</td></tr>
        <?php else: ?>
            <thead>
            <tr>
                <th>Event</th>
                <th>Organizer</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allEvents as $i => $allEvent): ?>
                <tr>
                    <td><a href="event.php?id=<?= (int)$allEvent['id'] ?>"><?= htmlentities($allEvent['name']) ?></a></td>
                    <td><?= htmlentities($allEvent['username']) ?></td>
                    <td><?= htmlentities(date('d-m-Y H:i', strtotime($allEvent['date']))) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        <?php endif; ?>
    </table>
</div>
</main>
<?php require_once "components/footer.php"; ?>
</body>
</html>
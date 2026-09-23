<?php
session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}


require_once "included/connection.php";
require_once "included/functions.php";

/** @var mysqli $db */
if ($db->connect_error) {
    die("Database fout");
}
/* ===== Maand & jaar ===== */
$month = (int)($_GET['month'] ?? date('m'));
$year  = (int)($_GET['year'] ?? date('Y'));

$daysInMonth  = getDaysInMonth($year, $month);
$firstWeekDay = getFirstWeekDay($year, $month);
$monthName    = getMonthName($month);

[$prevMonth, $prevYear] = getPreviousMonth($month, $year);
[$nextMonth, $nextYear] = getNextMonth($month, $year);

/* ===== Reserveringen vooraf ophalen ===== */
$eventsByDate = [];
for ($day = 1; $day <= $daysInMonth; $day++) {
    $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
  $query = "SELECT events.*, users.username 
          FROM events 
          JOIN users ON events.user_id = users.id 
          WHERE DATE(events.date) = '$date'";
    $results = mysqli_query($db, $query);
    $eventsByDate[$date] = mysqli_fetch_all($results, MYSQLI_ASSOC);
}
/* ===== Alle events ophalen voor de lijst ===== */
$allEventsQuery = "SELECT events.*, users.username 
                    FROM events 
                    JOIN users ON events.user_id = users.id 
                    ORDER BY events.date ASC";
$allEventsResult = mysqli_query($db, $allEventsQuery);
$allEvents = mysqli_fetch_all($allEventsResult, MYSQLI_ASSOC);
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
</head>
<body>
<?php require_once "components/nav.php"; ?>

<main >
     <h1>Calendar</h1>  
<div class="agenda__header">
            <a class="agenda__button" href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>">← Vorige</a>
            <h2 class="agenda__title"><?= $monthName ?> <?= $year ?></h2>
            <a class="agenda__button" href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>">Volgende →</a>
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
                <?php foreach ($eventsByDate[$currentDate] as $event): ?>
                    <a href="event.php?id=<?= $event['id'] ?>">
                    <?= $event['username'] ?><br>
                    <?= $event['name'] ?><br>
                    </a>
                <?php endforeach; ?>
                    
                </td>

                <?php if ((($day + $firstWeekDay) % 7) == 0): ?>
            </tr><tr>
                <?php endif; ?>
                <?php endfor; ?>
            </tr>
        </table>
        <div>
            <h2>Alle events</h2>

    
            <table class="events">
                <thead>
                <tr>
                
                    <th>Event</th>
                    <th>Organizer</th>
                    <th>Date</th>
                    
                    

                </tr>
                </thead>
                <tfoot>
                
                </tfoot>
                <tbody>
                <!--        Loop through all albums in the collection-->
                <?php foreach ($allEvents as $i => $allEvent) { ?>

                    <tr>
                        
                        <td><?= htmlentities($allEvent['name']); ?></td>
                        <td><?= htmlentities($allEvent['username']); ?></td>
                        <!-- <td><?= htmlentities($allEvent['date']); ?></td> -->
                         <td><?= htmlentities(date('d-m-Y H:i', strtotime($allEvent['date']))); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
</main>
<?php require_once "components/footer.php"; ?>
</body>
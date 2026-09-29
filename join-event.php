<?php
session_start();

if (!isset($_SESSION['loggedInUser']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /calendar.php');
    exit;
}

require_once "included/connection.php";
require_once "included/functions.php";
/** @var mysqli $db */

$userId  = (int)$_SESSION['loggedInUser']['id'];
$eventId = (int)($_POST['event_id'] ?? 0);

// Mag deze gebruiker dit event zien? Zo niet: stoppen.
if (!getVisibleEvent($db, $eventId, $userId)) {
    http_response_code(403);
    exit('Geen toegang tot dit event.');
}

// Direct joinen/verlaten, zonder dat iemand dit hoeft goed te keuren
if (($_POST['action'] ?? '') === 'leave') {
    $stmt = mysqli_prepare($db,
        "DELETE FROM user_event WHERE user_id = ? AND event_id = ?");
} else {
    $stmt = mysqli_prepare($db,
        "INSERT IGNORE INTO user_event (user_id, event_id, status)
         VALUES (?, ?, 'going')");
}
mysqli_stmt_bind_param($stmt, 'ii', $userId, $eventId);
mysqli_stmt_execute($stmt);

mysqli_close($db);
header("Location: /event.php?id=$eventId");
exit;
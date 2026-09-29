<?php

/* ===== Maandnamen ===== */
function getMonthName(int $month): string
{
    $months = [
        1 => 'januari', 2 => 'februari', 3 => 'maart', 4 => 'april',
        5 => 'mei', 6 => 'juni', 7 => 'juli', 8 => 'augustus',
        9 => 'september', 10 => 'oktober', 11 => 'november', 12 => 'december'
    ];

    return $months[$month] ?? '';
}

/* ===== Aantal dagen ===== */
function getDaysInMonth(int $year, int $month): int
{
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

/* ===== Eerste weekdag (ma = 0) ===== */
function getFirstWeekDay(int $year, int $month): int
{
    $day = date('w', strtotime("$year-$month-01"));
    return ($day == 0) ? 6 : $day - 1;
}

/* ===== Vorige maand ===== */
function getPreviousMonth(int $month, int $year): array
{
    return ($month == 1)
        ? [12, $year - 1]
        : [$month - 1, $year];
}

/* ===== Volgende maand ===== */
function getNextMonth(int $month, int $year): array
{
    return ($month == 12)
        ? [1, $year + 1]
        : [$month + 1, $year];
}

function getVisibleEvent(mysqli $db, int $eventId, int $userId): ?array
{
    $sql = "SELECT events.*, users.username
            FROM events
            JOIN users ON events.user_id = users.id
            WHERE events.id = ?
              AND (
                events.user_id = ?
                OR events.visibility = 'everyone'
                OR (events.visibility = 'friends' AND events.user_id IN (
                    SELECT friend_id FROM friends WHERE user_id = ?
                    UNION
                    SELECT user_id FROM friends WHERE friend_id = ?
                ))
              )";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'iiii', $eventId, $userId, $userId, $userId);
    mysqli_stmt_execute($stmt);
    $event = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    return $event ?: null;
}
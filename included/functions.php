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



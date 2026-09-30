<?php

global $db;
session_start();

require_once 'included/connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['loggedInUser'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

$userId = (int)$_SESSION['loggedInUser']['id'];

$search = trim($_GET['q'] ?? '');

if ($search === '') {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT id, username, avatar_id
    FROM users
    WHERE username LIKE ?
    AND id != ?
    ORDER BY username ASC
    LIMIT 10
";

$stmt = $db->prepare($sql);

$searchTerm = "%" . $search . "%";

$stmt->bind_param("si", $searchTerm, $userId);

$stmt->execute();

$result = $stmt->get_result();

echo json_encode($result->fetch_all(MYSQLI_ASSOC));
<?php


session_start(); // must be called before checking/using $_SESSION


if (!isset($_SESSION['loggedInUser'])) {
    header('Location: /Register/login.php');
    exit;
}


include 'included/connection.php';

class Friends
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getFriends($userId)
    {
        $sql = "
            SELECT users.id, users.username, users.avatar_id
            FROM friends
            INNER JOIN users ON users.id = friends.friend_id
            WHERE friends.user_id = ?
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $userId);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
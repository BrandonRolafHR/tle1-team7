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

    public function addFriend($userId, $friendId)
    {
        $sql = "
            INSERT INTO friends (user_id, friend_id)
            VALUES (?, ?)
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("ii", $userId, $friendId);

        return $stmt->execute();
    }

    public function deleteFriend($userId, $friendId)
    {
        $sql = "
            DELETE FROM friends
            WHERE user_id = ?
            AND friend_id = ?
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("ii", $userId, $friendId);

        return $stmt->execute();
    }

}
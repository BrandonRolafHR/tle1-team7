<?php

session_start();

require_once 'friends.php';

//if (!isset($_SESSION['loggedInUser'])) {
//    header('Location: /Register/login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
//    exit;
//}

$friends = new Friends($db);

$userId = 1;

$friendList = $friends->getFriends($userId);
?>

<h1>Friends</h1>

<div class="friends-list">

    <?php foreach ($friendList as $friend): ?>

        <div class="friend">
            <span>
                <?= htmlspecialchars($friend['username']) ?>
            </span>
        </div>

    <?php endforeach; ?>

</div>
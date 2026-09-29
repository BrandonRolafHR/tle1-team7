<?php

global $db;
require_once 'friends.php';

$friends = new Friends($db);

$userId = $_SESSION['loggedInUser'];

$friendList = $friends->getFriends($userId);
?>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/friends.css">

<div class="upper-section-friends">
    <h1>Friends</h1>

    <div class="search-container">

        <div class="search-input">
            <input type="text" id="friend-search" placeholder="Search username...">

            <button id="search-button">Search</button>
        </div>

        <div id="search-dropdown"></div>

    </div>
</div>

<div class="friends-list">

        <?php foreach ($friendList as $friend): ?>

            <div class="friend">

                <div class="friend-profile">
                    <div class="friend-icon">
                        <img src="images/friend-profile-placeholder.png">
                    </div>

                    <span class="friend-name">
                        <?= htmlspecialchars($friend['username']) ?>
                    </span>
                </div>

                <div class="friend-actions">
                    <span>
                        <img src="images/call-icon.png">
                    </span>
                    <span>
                        <img src="images/chat.png">
                    </span>
                    <span>
                        <img src="images/more-options.png">
                    </span>
                </div>

            </div>

        <?php endforeach; ?>

    </div>
</main>
<script src="js/friendsearch.js"></script>
<?php require_once "components/footer.php" ?>

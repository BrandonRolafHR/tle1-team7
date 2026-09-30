<?php

global $db;
require_once 'friends.php';

$friends = new Friends($db);

$userId = $_SESSION['loggedInUser'];


// Add / delete friend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $action = $_POST['action'] ?? '';
    $friendId = (int)($_POST['friend_id'] ?? 0);

    if ($action === 'add') {

        $success = $friends->addFriend($userId, $friendId);

    } elseif ($action === 'delete') {

        $success = $friends->deleteFriend($userId, $friendId);

    } else {

        $success = false;
    }

    echo json_encode([
            'success' => $success
    ]);

    exit;
}


$friendList = $friends->getFriends($userId);
?>


    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
              name="viewport">
        <meta content="ie=edge" http-equiv="X-UA-Compatible">
        <title></title>
        <link rel="icon" type="image/x-icon" href="/images/favicon.gif">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/friends.css">
    </head>
<?php $activePage = 'friends'; ?>
    <body>
    <div class="websiteContainer">
    <div class="upper-section-friends">
        <h1 class="white">Friends</h1>
    </div>
        <section>
        <div class="search-container">
            <div class="search-input">
                <input type="text" id="friend-search" placeholder="Search username...">
                <button id="search-button">Search</button>
            </div>
        </section>
            <div id="search-dropdown"></div>



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

                    <span class="more-options" data-user-id="<?= $friend['id'] ?>">
                    <img src="images/more-options.png">
                </span>

                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>
    </main>

    <script src="js/friendsearch.js"></script>

<?php require_once "components/footer.php" ?>
    </body>
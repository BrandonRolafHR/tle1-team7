<?php
require_once './included/connection.php';

$query = "SELECT posts.*, users.username, users.avatar_id 
          FROM posts 
          JOIN users ON posts.user_id = users.id
          ORDER BY posts.id DESC";
$result = mysqli_query($db, $query);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title></title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.gif">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
<header>
    <h1>home</h1>
    <?php require_once "components/nav.php"; ?>
</header>

<main>
    <section>
        <?php foreach ($posts as $post) { ?>
            <div class="post-container">
                <div class="profile-container">
                    <?php if (!empty($post['avatar_id'])) { ?>

                        <img class="pfp" src="../images/placeholder.png" alt="profile picture">
                    <?php } else { ?>
                        <img class="pfp" src="../images/placeholder.png" alt="profile picture">
                    <?php } ?>
                    <h3><?= htmlspecialchars($post['username']) ?></h3>
                </div>
                <div class="post-content">
                    <?php if ($post['image'] !== null) { ?>
                        <img class="post-image" src="data:image/jpeg;base64,<?= base64_encode($post['image']) ?>" alt="image">
                    <?php } ?>
                    <h2><?= htmlspecialchars($post['title']) ?></h2>
                    <p><?= htmlspecialchars($post['text']) ?></p>
                    <?php if (!empty($post['location'])) { ?>
                        <p class="post-location"><?= htmlspecialchars($post['location']) ?></p>
                    <?php } ?>
                </div>
                <?php if ($post['comment_id'] !== NULL) {
                    $query = "SELECT emoji FROM comments WHERE id=$post[comment_id]";
                    $result = mysqli_query($db, $query);
                    $emoji = mysqli_fetch_assoc($result);
                    ?>
                    <div class="comment-container">
                        <p><?= htmlspecialchars($emoji['emoji']) ?></p>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </section>
</main>
<?php require_once "components/footer.php"; ?>
</body>
</html>
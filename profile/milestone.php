<?php
session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: /tle1-team7/Register/login.php');
    exit;
}else {
    require_once "../included/connection.php";
    $id = $_GET['post_id'];
    //print_r($id)
    
    $query = "SELECT * FROM posts WHERE id = " . $id;
    $result = mysqli_query($db, $query);
    $post = mysqli_fetch_assoc($result);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>milestone</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header class="settings-header">
        <a href="profile.php">
            <span>↫</span>
        </a>
        <h1><?= $post['title'] ?></h1>
    </header>

    <main>
        <section class="milestone-post">
            <div class="post-image">
                <?php if ($post['image'] !== null) { ?>
                    <img class="post-image" src="data:image/jpeg;base64,<?= base64_encode($post['image']) ?>" alt="image">
                <?php } ?>
            </div>
            <div>
                <p><?= htmlspecialchars($post['text']) ?></p>
            </div>
        </section>
    </main>
</body>
</html>
<?php
    require_once './included/connection.php';

    $query = "SELECT * FROM posts";
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

            <?php
                foreach ($posts as $post) {
                    print_r($post);

                    $query = "SELECT username, avatar_id FROM users WHERE id=$post[user_id]";
                    $result = mysqli_query($db, $query);
                    $user = mysqli_fetch_assoc($result);
                    print_r($user);

                    ?>
                        <div class="post-container">
                            <div class="profile-container">
                                <?php if($user['avatar_id'] !== NULL) { ?>
                                <img class="pfp" src="<?php $user['avatar_id'] ?>" alt="profile picture">
                                <?php } else {?> 
                                <img class="pfp" src="../images/placeholder.png" alt="profile picture">
                                <?php } ?>
                                <h3><?= $user['username'] ?></h3>
                        </div>
                            <div class="post-content">
                                <?php if ($post['image'] !== NULL) { ?>
                                <img class="post-image" src="<?php $post['image'] ?>" alt="image">
                                <?php } ?>
                                <h2><?php echo $post['title']; ?></h2>
                                <p><?= $post['text'] ?></p>
                            </div>
                        </div>

                    <?php
                };
            ?>

        </section>

    </main>
        <?php require_once "components/footer.php"; ?>
</body>
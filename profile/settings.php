<?php
session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}else {
    require_once "../included/connection.php";

    $query = "SELECT * FROM users WHERE id = " . $_SESSION['loggedInUser']['id'];
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);
    mysqli_close($db);
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>settings</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
        <header class="settings-header">
            <a href="profile.php">
                <span>↫</span>
            </a>
            <h1>settings</h1>
        </header>
    <main>
        <section class="user-info">
            <h2>account details</h2>
            <p>username: <?= $user['username'] ?></p>
            <p>email: <?= $user['email'] ?></p>
            <p>birthdate: <?= $user['birthdate'] ?></p>
            <p>bio: <?= $user['bio'] ?></p>
            <a href="edit-profile.php">
                <div>edit ✏️</div>
            </a>

            <a href="../Register/logout.php">
                <div>log out</div>
            </a>

        </section>
    </main>

</body>
</html>
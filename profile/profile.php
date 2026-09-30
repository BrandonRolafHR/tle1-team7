<?php
session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: /2026_2027/tle_t7/Register/login.php');
    exit;
}else {
    require_once "../included/connection.php";

    $query = "SELECT * FROM users WHERE id = " . $_SESSION['loggedInUser']['id'];
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);

    $query = "SELECT * FROM milestones WHERE user_id = " . $_SESSION['loggedInUser']['id'] . " ORDER BY created_at DESC";
    $result = mysqli_query($db, $query);
    $milestones = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($db);
}


?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel</title>
    <link rel="stylesheet" href="../css/style.css">
    <script defer src="../js/profile.js"></script>
</head>
<?php $activePage = 'profile'; ?>
<body>
    <header class="profile-header">
        <h1><?= $user['username']?>'s journey</h1>
        <a href="settings.php">
            <img src="../images/settings-icon.png" alt="icon for settings" class="settings-link">
        </a>
    </header>

    <main>
        <div class="bg-image"><?= $user['bio'] ?></div>
        <section class="milestones">
        <h2>Milestones</h2>
        <div class="milestone-overzicht">
            <?php foreach ($milestones as $milestone): ?>
                <div class="milestone-item" data-id="<?= $milestone['id'] ?>">
                    <img src="<?= $milestone['milestone'] ?>" alt="milestone image" class="<?= $milestone['size']?>-milestone">
                </div>
            <?php endforeach; ?>
        </div>
        

    </section>
    </main>
    <?php require_once "../components/footer.php" ?>
</body>
</html>
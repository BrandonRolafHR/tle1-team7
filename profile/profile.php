<?php
// session_start();

// if (!isset($_SESSION['loggedInUser'])) {
    // header('Location: /tle1-team7/Register/login.php');
//     exit;
// }else {
//     require_once "included/connection.php";

//     $query = "SELECT * FROM users WHERE id = " . $_SESSION['loggedInUser']['id'];
//     $result = mysqli_query($db, $query);
//     $user = mysqli_fetch_assoc($result);
//     mysqli_close($db);
// }


?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php $activePage = 'profile'; ?>
<body>
    <header class="profile-header">
        <h1>username's journey</h1>
        <a href="settings.php">
            <img src="../images/settings-icon.png" alt="icon for settings" class="settings-link">
        </a>
    </header>

    <main>
        <div class="bg-image">Bio</div>
        <section class="milestones">
        <h2>Milestones</h2>
        <div class="milestone-path">
            <img src="../images/milestone-path.png" alt="milestone" class="milestone-img">
            <a href="bday-milestone.php" class="milestone-img">
            <img src="../images/bday-stone.png" alt="milestone" class="milestone-img">
            </a>
        </div>

    </section>
    </main>
    <?php require_once "../components/footer.php" ?>
</body>
</html>